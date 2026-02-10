<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class CustomerController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $featuredProducts = Product::latest()->take(6)->get();
        $newArrivals = Product::orderBy('created_at', 'desc')->take(5)->get();
        $bestSelling = Product::withCount('orderItems')
                        ->orderBy('order_items_count', 'desc')
                        ->take(5)
                        ->get();
                        
        return view('customer.index', compact('categories', 'featuredProducts', 'newArrivals', 'bestSelling'));
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
}
