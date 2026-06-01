<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the customer's wishlist.
     */
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product.category')
            ->latest()
            ->get();

        return view('customer.order.wishlist-modern', compact('wishlistItems'));
    }

    /**
     * Toggle add/remove a product in the wishlist.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;

        $existing = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            $status = 'removed';
            $message = 'Produk dihapus dari wishlist!';
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            $status = 'added';
            $message = 'Produk ditambahkan ke wishlist!';
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
