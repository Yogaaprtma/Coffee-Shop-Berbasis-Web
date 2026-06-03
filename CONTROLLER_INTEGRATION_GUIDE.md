<?php
// ==========================================
// Coffee Shop - Modern Views Integration Guide
// ==========================================
// Use this file to understand what needs to be updated
// in your controllers to use the modern views

/*
OLD VIEWS (Bootstrap-based)          → NEW VIEWS (Tailwind-based)
=================================================================

index.blade.php                      → index-modern.blade.php
(layouts/main.blade.php)            → (layouts/main-modern.blade.php)

order.blade.php                      → order-modern.blade.php
cart.blade.php                       → cart-modern.blade.php
profile/index.blade.php              → (needs modernization)
*/

// ==========================================
// STEP 1: CustomerController
// ==========================================

namespace App\Http\Controllers;

class CustomerController extends Controller
{
    /**
     * Display home page
     * 
     * UPDATE: Change view from 'customer.index' to 'customer.index-modern'
     */
    public function index()
    {
        $categories = Category::all();
        $featuredProducts = Product::where('featured', true)->take(8)->get();
        $newArrivals = Product::latest()->take(6)->get();
        $bestSelling = Product::withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(6)
            ->get();

        // ⬇️ CHANGE THIS LINE:
        // Old: return view('customer.index', compact(...));
        return view('customer.index-modern', compact(
            'categories', 
            'featuredProducts', 
            'newArrivals', 
            'bestSelling'
        ));
    }

    /**
     * Display customer profile
     * 
     * TODO: Create modern profile view
     */
    public function profile()
    {
        $user = auth()->user();
        $orderCount = $user->orders()->count();
        
        // Current: return view('customer.profile.index', compact('user', 'orderCount'));
        // TODO: return view('customer.profile.index-modern', ...);
    }

    /**
     * Display blog page
     * 
     * TODO: Modernize blog view with Tailwind
     */
    public function blog()
    {
        // Current: return view('customer.blog.index', ...);
        // TODO: return view('customer.blog.index-modern', ...);
    }
}

// ==========================================
// STEP 2: OrderController
// ==========================================

class OrderController extends Controller
{
    /**
     * Show products for ordering
     * 
     * UPDATE: Change view from 'customer.order' to 'customer.order.order-modern'
     */
    public function showProducts()
    {
        $products = Product::with('category')->paginate(12);
        $categories = Category::all();

        // ⬇️ CHANGE THIS LINE:
        // Old: return view('customer.order', compact('products', 'categories'));
        return view('customer.order.order-modern', compact(
            'products', 
            'categories'
        ));
    }

    /**
     * Show shopping cart
     * 
     * UPDATE: Change view from 'customer.cart' to 'customer.order.cart-modern'
     */
    public function showCart()
    {
        $cart = session('cart') ?? [];
        
        // ⬇️ CHANGE THIS LINE:
        // Old: return view('customer.order.cart', compact('cart'));
        return view('customer.order.cart-modern', compact('cart'));
    }

    /**
     * Add product to cart
     * 
     * This stays the same - uses session cart storage
     * The modern view will handle the display
     */
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'nama' => $product->nama,
                'gambar' => $product->gambar,
                'harga' => $product->harga,
                'category_name' => $product->category->nama ?? 'Coffee',
                'quantity' => 1
            ];
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * Update cart item quantity
     * 
     * Modern cart view has +/- buttons that call this
     */
    public function updateCart(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;
        
        $cart = session()->get('cart', []);
        
        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['quantity'] = $quantity;
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Cart updated!');
    }

    /**
     * Remove item from cart
     * 
     * Modern cart view has remove buttons that call this
     */
    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        unset($cart[$request->product_id]);
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Item removed!');
    }
}

// ==========================================
// STEP 3: New Controllers to Create (Optional)
// ==========================================

/**
 * ReviewController - Handle product reviews
 * 
 * TODO: Create this controller when ready for reviews feature
 * 
 * Methods needed:
 * - store() - Create new review
 * - destroy() - Delete review
 * - update() - Edit review
 * - helpful() - Mark as helpful
 */
class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        ProductReview::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'verified_purchase' => true, // Check if user bought the product
        ]);

        return redirect()->back()->with('success', 'Review posted!');
    }

    public function destroy(ProductReview $review)
    {
        $this->authorize('delete', $review);
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted!');
    }
}

/**
 * WishlistController - Handle favorite products
 * 
 * TODO: Create this controller when ready for wishlist feature
 * 
 * Methods needed:
 * - toggle() - Add/remove from wishlist
 * - index() - Show wishlist page
 */
class WishlistController extends Controller
{
    public function toggle(Product $product)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['action' => 'removed']);
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ]);
            return response()->json(['action' => 'added']);
        }
    }

    public function index()
    {
        $wishlisted = auth()->user()->wishlists()->with('product')->get();
        return view('customer.wishlist.index-modern', compact('wishlisted'));
    }
}

/**
 * PromoController - Handle discount codes
 * 
 * TODO: Create this controller when ready for promo feature
 * 
 * Methods needed:
 * - validate() - Check if code is valid
 * - apply() - Apply discount to order
 */
class PromoController extends Controller
{
    public function validate(Request $request)
    {
        $promo = PromoCode::where('code', $request->code)
            ->active()
            ->available()
            ->first();

        if (!$promo) {
            return response()->json(['error' => 'Invalid promo code'], 404);
        }

        $discount = $promo->calculateDiscount($request->subtotal ?? 0);

        return response()->json([
            'valid' => true,
            'discount' => $discount,
            'message' => "Saved Rp " . number_format($discount)
        ]);
    }
}

// ==========================================
// STEP 4: Routes (Update in routes/web.php)
// ==========================================

/*
Customer Routes - No changes needed!
The views will automatically work with existing routes.

Current routes still work:
- GET  /customer/home → showProducts() 
- GET  /customer/order → showProducts()
- POST /customer/order/add → addToCart()
- GET  /customer/cart → showCart()
- POST /customer/cart/update → updateCart()
- POST /customer/cart/remove → removeFromCart()

Just update the controller return view() statements!
*/

// ==========================================
// QUICK CHECKLIST
// ==========================================

/*
☐ 1. Update CustomerController::index() to use 'customer.index-modern'
☐ 2. Update OrderController::showCart() to use 'customer.order.cart-modern'
☐ 3. Update OrderController::showProducts() to use 'customer.order.order-modern'
☐ 4. Test all modern pages in browser
☐ 5. Create ReviewController (when ready)
☐ 6. Create WishlistController (when ready)
☐ 7. Create PromoController (when ready)
☐ 8. Modernize admin panel
☐ 9. Add modern profile page
☐ 10. Deploy to production!
*/
