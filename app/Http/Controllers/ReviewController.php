<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created product review.
     */
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ]);

        $userId = Auth::id();

        // Check if user has ordered this product before and order is completed
        $hasPurchased = Order::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereHas('orderItems', function ($q) use ($productId) {
                $q->where('product_id', $productId);
            })
            ->exists();

        // Create or update review
        ProductReview::updateOrCreate(
            [
                'product_id' => $productId,
                'user_id' => $userId,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'verified_purchase' => $hasPurchased,
                'helpful_count' => 0,
            ]
        );

        return redirect()->back()->with('success', 'Ulasan Anda berhasil dikirim!');
    }
}
