<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function showProducts(Request $request)
    {
        $query = Product::with('category')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        // Filter berdasarkan pencarian nama produk
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search . '%';
            $query->whereRaw("LOWER(nama) LIKE ?", [strtolower($searchTerm)]);
        }

        // Sorting berdasarkan harga (rendah ke tinggi atau tinggi ke rendah)
        if ($request->has('sort')) {
            if ($request->sort == 'low-high') {
                $query->orderBy('harga', 'asc');
            } elseif ($request->sort == 'high-low') {
                $query->orderBy('harga', 'desc');
            } elseif ($request->sort == 'newest') {
                $query->orderBy('created_at', 'desc'); 
            }
        }

        $products = $query->get();

        return view('customer.order.order-modern', compact('products'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        $jumlah = $request->input('jumlah', 1);
        if ($jumlah < 1) {
            $jumlah = 1;
        }

        $size = $request->input('size', 'S');
        $temperature = $request->input('temperature', 'hot');
        $sugar = $request->input('sugar', 'normal');
        $extras = $request->input('extras', []);

        // Price calculation
        $base_price = $product->harga;
        $extra_price = 0;
        
        if ($size === 'M') {
            $extra_price += 5000;
        } elseif ($size === 'L') {
            $extra_price += 10000;
        }
        
        if (in_array('extra_espresso', $extras)) {
            $extra_price += 5000;
        }
        if (in_array('caramel_syrup', $extras)) {
            $extra_price += 3000;
        }
        
        $item_price = $base_price + $extra_price;
        $options = [
            'size' => $size,
            'temperature' => $temperature,
            'sugar' => $sugar,
            'extras' => $extras
        ];

        // Unique cart key based on product + options
        $cart_key = $product->id . '_' . md5(json_encode($options));
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$cart_key])) {
            $cart[$cart_key]['jumlah'] += $jumlah;
            $cart[$cart_key]['total'] = $cart[$cart_key]['jumlah'] * $item_price;
        } else {
            $cart[$cart_key] = [
                "product_id" => $product->id,
                "nama" => $product->nama,
                "jumlah" => $jumlah,
                "harga" => $item_price,
                "total" => $item_price * $jumlah,
                "gambar" => $product->gambar,
                "options" => $options,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('customer.cart')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');

            $quantity = $request->quantity < 1 ? 1 : $request->quantity;
            
            $cart[$request->id]['jumlah'] = $quantity;

            $cart[$request->id]['total'] = $cart[$request->id]['harga'] * $quantity;
            
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Keranjang diperbarui!');
        }
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('customer.order.cart', compact('cart'));
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart');
        
        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'order_type' => 'required|in:dine_in,takeaway',
            'table_number' => 'required_if:order_type,dine_in|nullable|string',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart')->with('error', 'Keranjang belanja kosong!');
        }

        // Calculate subtotal
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['total'];
        }

        // Check for promo code in session
        $promoSession = session()->get('promo');
        $promoId = null;
        $discount = 0;

        if ($promoSession) {
            $promo = \App\Models\PromoCode::find($promoSession['id']);
            if ($promo && $promo->isValid() && $subtotal >= $promo->min_purchase) {
                $discount = $promo->calculateDiscount($subtotal);
                $promoId = $promo->id;
                // Increment used count
                $promo->use();
            }
        }

        $tax = ($subtotal - $discount) * 0.1;
        $totalAmount = ($subtotal - $discount) + $tax;

        // Create Order
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'order_type' => $request->order_type,
            'table_number' => $request->order_type === 'dine_in' ? $request->table_number : null,
            'promo_code_id' => $promoId,
            'discount_amount' => $discount,
            'total_amount' => $totalAmount,
        ]);

        // Create Order Items
        foreach ($cart as $key => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga'],
                'options' => $item['options'] ?? null,
            ]);
        }

        // Clear Cart & Promo
        session()->forget('cart');
        session()->forget('promo');

        return redirect()->route('customer.payment', ['order_id' => $order->id]);
    }

    public function orderHistory()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('customer.order.history-modern', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = Order::with('orderItems.product', 'payment')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('customer.order.order-detail-modern', compact('order'));
    }
}