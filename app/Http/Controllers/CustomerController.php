<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $featuredProducts = Product::with('category')
                        ->withCount('reviews')
                        ->withAvg('reviews', 'rating')
                        ->latest()
                        ->take(6)
                        ->get();
        $newArrivals = Product::with('category')
                        ->withCount('reviews')
                        ->withAvg('reviews', 'rating')
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
        $bestSelling = Product::with('category')
                        ->withCount('reviews')
                        ->withAvg('reviews', 'rating')
                        ->withCount('orderItems')
                        ->orderBy('order_items_count', 'desc')
                        ->take(5)
                        ->get();
                        
        return view('customer.index-modern', compact('categories', 'featuredProducts', 'newArrivals', 'bestSelling'));
    }

    public function blog()
    {
        $blogs = [
            [
                'id' => 1,
                'title' => 'Perfect V60 Guide',
                'excerpt' => 'The ultimate guide to brewing clear coffee manually at home.',
                'image' => 'images/blog1.jpg',
                'date' => '12 Oct 2023',
                'category' => 'Tips'
            ],
            [
                'id' => 2,
                'title' => 'Arabica vs Robusta',
                'excerpt' => 'Understanding the key differences in taste, caffeine, and growing conditions.',
                'image' => 'images/blog1.jpg',
                'date' => '15 Oct 2023',
                'category' => 'Knowledge'
            ],
            [
                'id' => 3,
                'title' => 'The History of Espresso',
                'excerpt' => 'How a machine changed the way we drink coffee forever.',
                'image' => 'images/blog1.jpg',
                'date' => '20 Oct 2023',
                'category' => 'History'
            ],
            [
                'id' => 4,
                'title' => 'Perfect V60 Guide',
                'excerpt' => 'The ultimate guide to brewing clear coffee manually at home.',
                'image' => 'images/blog1.jpg',
                'date' => '12 Oct 2023',
                'category' => 'Tips'
            ],
            [
                'id' => 5,
                'title' => 'Arabica vs Robusta',
                'excerpt' => 'Understanding the key differences in taste, caffeine, and growing conditions.',
                'image' => 'images/blog1.jpg',
                'date' => '15 Oct 2023',
                'category' => 'Knowledge'
            ],
            [
                'id' => 6,
                'title' => 'The History of Espresso',
                'excerpt' => 'How a machine changed the way we drink coffee forever.',
                'image' => 'images/blog1.jpg',
                'date' => '20 Oct 2023',
                'category' => 'History'
            ],
            [
                'id' => 7,
                'title' => 'Perfect V60 Guide',
                'excerpt' => 'The ultimate guide to brewing clear coffee manually at home.',
                'image' => 'images/blog1.jpg',
                'date' => '12 Oct 2023',
                'category' => 'Tips'
            ],
            [
                'id' => 8,
                'title' => 'Arabica vs Robusta',
                'excerpt' => 'Understanding the key differences in taste, caffeine, and growing conditions.',
                'image' => 'images/blog1.jpg',
                'date' => '15 Oct 2023',
                'category' => 'Knowledge'
            ],
            [
                'id' => 9,
                'title' => 'The History of Espresso',
                'excerpt' => 'How a machine changed the way we drink coffee forever.',
                'image' => 'images/blog1.jpg',
                'date' => '20 Oct 2023',
                'category' => 'History'
            ],
        ];

        return view('customer.blog.index', compact('blogs'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('customer.profile.index', compact('user'));
    }

    public function productDetail($id)
    {
        $product = Product::with('category')->findOrFail($id);
        
        $reviews = \App\Models\ProductReview::where('product_id', $id)
            ->with('user')
            ->latest()
            ->get();
            
        $avgRating = \App\Models\ProductReview::where('product_id', $id)->avg('rating') ?: 0.0;
        $totalReviews = $reviews->count();
        
        $isWishlisted = false;
        if (Auth::check()) {
            $isWishlisted = \App\Models\Wishlist::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();
        }
        
        // Fetch related products (same category)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('customer.order.detail-modern', compact('product', 'reviews', 'avgRating', 'totalReviews', 'isWishlisted', 'relatedProducts'));
    }
}
