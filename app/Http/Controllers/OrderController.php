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
        $query = Product::query();

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

        return view('customer.order.order', compact('products'));
    }

    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);

        $product = Product::findOrFail($request->product_id);
        $cart[$product->id] = [
            "nama" => $product->nama,
            "jumlah" => $request->jumlah,
            "harga" => $product->harga,
            "total" => $product->harga * $request->jumlah,
        ];

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

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart')->with('error', 'Keranjang belanja kosong!');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending'
        ]);

        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('customer.payment', ['order_id' => $order->id]);
    }

    public function orderHistory()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('customer.order.history', compact('orders'));
    }
}