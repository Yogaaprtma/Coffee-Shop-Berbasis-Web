<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $totalOrders = Order::count();

        $totalRevenue = OrderItem::whereHas('order', function ($query) {
            $query->where('status', 'completed');
        })->sum(DB::raw('harga * jumlah'));

        $totalCustomers = User::whereHas('orders')->count();

        $totalProducts = Product::count();
        
        return view('admin.index', compact('user', 'totalOrders', 'totalRevenue' ,'totalCustomers', 'totalProducts'));
    }

    public function category()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    public function product()
    {
        $products = Product::with('category')->get();
        return view('admin.product.index', compact('products'));
    }

    public function order()
    {
        $orders = Order::with('user', 'orderItems.product', 'payment')->get();
        return view('admin.order.index', compact('orders'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }
}