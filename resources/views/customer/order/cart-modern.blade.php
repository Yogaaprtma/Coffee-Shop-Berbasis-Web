@extends('customer.layouts.main-modern')

@section('title', 'Shopping Cart')

@section('content')

<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-slate-900 mb-8">Shopping Cart</h1>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            @if(session('cart') && count(session('cart')) > 0)
                <div class="space-y-4">
                    @foreach(session('cart') as $item)
                    <div class="card p-6 flex gap-6 hover:shadow-hover transition-all">
                        <!-- Product Image -->
                        <div class="flex-shrink-0 w-24 h-24 rounded-lg overflow-hidden bg-slate-100">
                            <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama'] }}" class="w-full h-full object-cover">
                        </div>
                        
                        <!-- Product Details -->
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg text-slate-900 mb-2">{{ $item['nama'] }}</h3>
                            <p class="text-sm text-slate-600 mb-4">{{ $item['category_name'] ?? 'Coffee' }}</p>
                            
                            <!-- Quantity Control -->
                            <div class="flex items-center gap-3 bg-slate-100 rounded-lg w-fit p-2">
                                <form action="{{ route('customer.cart.update') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                    <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center text-slate-600 hover:text-coffee-700 transition">
                                        <i class="fas fa-minus text-sm"></i>
                                    </button>
                                </form>
                                
                                <span class="w-8 text-center font-semibold">{{ $item['quantity'] }}</span>
                                
                                <form action="{{ route('customer.cart.update') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                    <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center text-slate-600 hover:text-coffee-700 transition">
                                        <i class="fas fa-plus text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Price & Remove -->
                        <div class="flex flex-col items-end justify-between flex-shrink-0">
                            <div class="text-right">
                                <p class="text-2xl font-bold text-coffee-700">Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</p>
                                <p class="text-sm text-slate-500">Rp {{ number_format($item['harga'], 0, ',', '.') }} each</p>
                            </div>
                            
                            <form action="{{ route('customer.cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                <button type="submit" class="text-red-500 hover:text-red-700 transition font-semibold text-sm">
                                    <i class="fas fa-trash mr-1"></i> Remove
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Continue Shopping -->
                <div class="mt-8">
                    <a href="{{ route('customer.order') }}" class="inline-flex items-center gap-2 text-coffee-700 font-semibold hover:text-coffee-800 transition">
                        <i class="fas fa-arrow-left"></i>
                        Continue Shopping
                    </a>
                </div>
            @else
                <div class="card p-12 text-center">
                    <i class="fas fa-shopping-bag text-6xl text-slate-300 mb-4"></i>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">Your cart is empty</h3>
                    <p class="text-slate-600 mb-8">Add some delicious coffee to get started!</p>
                    <a href="{{ route('customer.order') }}" class="btn-coffee">Start Shopping</a>
                </div>
            @endif
        </div>

        <!-- Cart Summary -->
        <div class="lg:col-span-1">
            <div class="card p-6 sticky top-32 space-y-6">
                <h2 class="text-2xl font-bold text-slate-900">Order Summary</h2>
                
                @if(session('cart') && count(session('cart')) > 0)
                    <!-- Subtotal -->
                    <div class="space-y-3 pb-4 border-b border-slate-200">
                        @php
                            $subtotal = 0;
                            foreach(session('cart') as $item) {
                                $subtotal += $item['harga'] * $item['quantity'];
                            }
                        @endphp
                        
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Shipping</span>
                            <span class="text-green-600 font-semibold">Free</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Tax (10%)</span>
                            <span>Rp {{ number_format($subtotal * 0.1, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <!-- Promo Code -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-900">Promo Code</label>
                        <div class="flex gap-2">
                            <input type="text" placeholder="Enter code" class="input-field text-sm flex-1">
                            <button class="btn-coffee px-4 py-2 text-sm">Apply</button>
                        </div>
                        <p class="text-xs text-slate-500">Get 20% off with code WELCOME20</p>
                    </div>
                    
                    <!-- Total -->
                    <div class="pt-4 border-t border-slate-200">
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-lg font-semibold text-slate-900">Total</span>
                            <span class="text-3xl font-bold text-coffee-700">Rp {{ number_format($subtotal * 1.1, 0, ',', '.') }}</span>
                        </div>
                        
                        <form action="{{ route('customer.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full btn-coffee py-3 text-lg font-semibold mb-3">
                                Proceed to Checkout
                            </button>
                        </form>
                        
                        <button class="w-full btn-ghost">Save for Later</button>
                    </div>
                    
                    <!-- Security & Info -->
                    <div class="space-y-2 pt-4">
                        <div class="flex items-center gap-2 text-xs text-slate-600">
                            <i class="fas fa-lock text-coffee-700"></i>
                            Secure checkout
                        </div>
                        <div class="flex items-center gap-2 text-xs text-slate-600">
                            <i class="fas fa-truck text-coffee-700"></i>
                            Free shipping on orders over 500k
                        </div>
                        <div class="flex items-center gap-2 text-xs text-slate-600">
                            <i class="fas fa-undo text-coffee-700"></i>
                            30-day money-back guarantee
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-slate-600 mb-4">Add items to see summary</p>
                        <a href="{{ route('customer.order') }}" class="btn-coffee">Browse Menu</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
