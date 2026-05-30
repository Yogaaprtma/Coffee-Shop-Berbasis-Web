@extends('customer.layouts.main-modern')

@section('title', 'Shopping Cart')

@section('content')

<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-slate-900 mb-8">Shopping Cart</h1>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-green-500 text-lg"></i>
            <span class="text-green-800 font-medium">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
            <span class="text-red-800 font-medium">{{ session('error') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            @if(session('cart') && count(session('cart')) > 0)
                <div class="space-y-4">
                    @foreach(session('cart') as $key => $item)
                    <div class="card p-6 flex flex-col sm:flex-row gap-6 hover:shadow-hover transition-all">
                        <!-- Product Image -->
                        <div class="flex-shrink-0 w-24 h-24 rounded-lg overflow-hidden bg-slate-100 mx-auto sm:mx-0">
                            <img src="{{ asset($item['gambar'] ?? 'images/coffee-placeholder.jpg') }}" alt="{{ $item['nama'] }}" class="w-full h-full object-cover">
                        </div>
                        
                        <!-- Product Details -->
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg text-slate-900 mb-1">
                                @if(isset($item['product_id']))
                                <a href="{{ route('customer.product.detail', $item['product_id']) }}" class="hover:text-coffee-700">{{ $item['nama'] }}</a>
                                @else
                                {{ $item['nama'] }}
                                @endif
                            </h3>
                            
                            <!-- Customizations Display -->
                            @if(isset($item['options']))
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="px-2 py-0.5 bg-coffee-50 text-coffee-700 text-xs rounded-full font-semibold">Size: {{ $item['options']['size'] }}</span>
                                <span class="px-2 py-0.5 bg-coffee-50 text-coffee-700 text-xs rounded-full font-semibold capitalize">Temp: {{ $item['options']['temperature'] }}</span>
                                <span class="px-2 py-0.5 bg-coffee-50 text-coffee-700 text-xs rounded-full font-semibold capitalize">Sugar: {{ str_replace('_', ' ', $item['options']['sugar']) }}</span>
                                @if(!empty($item['options']['extras']))
                                    @foreach($item['options']['extras'] as $extra)
                                    <span class="px-2 py-0.5 bg-amber-50 text-amber-700 text-xs rounded-full font-semibold capitalize">+ {{ str_replace('_', ' ', $extra) }}</span>
                                    @endforeach
                                @endif
                            </div>
                            @endif
                            
                            <!-- Quantity Control -->
                            <div class="flex items-center gap-3 bg-slate-100 rounded-lg w-fit p-1">
                                <form action="{{ route('customer.cart.update') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $key }}">
                                    <input type="hidden" name="quantity" value="{{ max(1, $item['jumlah'] - 1) }}">
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center text-slate-600 hover:text-coffee-700 transition" {{ $item['jumlah'] <= 1 ? 'disabled' : '' }}>
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                </form>
                                
                                <span class="w-8 text-center font-semibold text-sm">{{ $item['jumlah'] }}</span>
                                
                                <form action="{{ route('customer.cart.update') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $key }}">
                                    <input type="hidden" name="quantity" value="{{ $item['jumlah'] + 1 }}">
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center text-slate-600 hover:text-coffee-700 transition">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Price & Remove -->
                        <div class="flex flex-row sm:flex-col items-end justify-between sm:justify-between flex-shrink-0 mt-4 sm:mt-0">
                            <div class="text-left sm:text-right">
                                <p class="text-xl font-bold text-coffee-700">Rp {{ number_format($item['total'], 0, ',', '.') }}</p>
                                <p class="text-xs text-slate-400">Rp {{ number_format($item['harga'], 0, ',', '.') }} each</p>
                            </div>
                            
                            <form action="{{ route('customer.cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $key }}">
                                <button type="submit" class="text-red-500 hover:text-red-700 transition font-semibold text-sm flex items-center gap-1">
                                    <i class="fas fa-trash-alt text-xs"></i> Remove
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
                    <a href="{{ route('customer.order') }}" class="btn-coffee px-6 py-3 inline-block">Start Shopping</a>
                </div>
            @endif
        </div>

        <!-- Cart Summary -->
        <div class="lg:col-span-1">
            <div class="card p-6 sticky top-24 space-y-6">
                <h2 class="text-2xl font-bold text-slate-900">Order Summary</h2>
                
                @if(session('cart') && count(session('cart')) > 0)
                    <!-- Subtotal -->
                    <div class="space-y-3 pb-4 border-b border-slate-200">
                        @php
                            $subtotal = 0;
                            foreach(session('cart') as $item) {
                                $subtotal += $item['total'];
                            }
                            
                            $promo = session('promo');
                            $discount = 0;
                            if($promo) {
                                if($promo['discount_type'] === 'percentage') {
                                    $discount = $subtotal * ($promo['discount_value'] / 100);
                                    if($promo['max_discount']) {
                                        $discount = min($discount, $promo['max_discount']);
                                    }
                                } else {
                                    $discount = $promo['discount_value'];
                                }
                            }
                            $tax = ($subtotal - $discount) * 0.1;
                            $total = ($subtotal - $discount) + $tax;
                        @endphp
                        
                        <div class="flex justify-between text-slate-600 text-sm">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        @if($promo)
                        <div class="flex justify-between text-green-600 text-sm font-medium">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-tag"></i> Promo ({{ $promo['code'] }})
                            </span>
                            <span>- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between text-slate-600 text-sm">
                            <span>Tax (10%)</span>
                            <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <!-- Promo Code Form -->
                    <div class="pb-4 border-b border-slate-200">
                        @if($promo)
                            <div class="flex items-center justify-between bg-green-50 border border-green-200 p-3 rounded-lg">
                                <div class="text-xs text-green-800">
                                    <p class="font-bold">Code: {{ $promo['code'] }}</p>
                                    <p>Discount applied!</p>
                                </div>
                                <form action="{{ route('customer.promo.remove') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('customer.promo.apply') }}" method="POST" class="space-y-2">
                                @csrf
                                <label class="text-sm font-semibold text-slate-900">Promo Code</label>
                                <div class="flex gap-2">
                                    <input type="text" name="code" placeholder="Enter code (e.g. KOPIHEMAT)" class="input-field text-sm flex-1" required>
                                    <button type="submit" class="btn-coffee px-4 py-2 text-sm">Apply</button>
                                </div>
                                <p class="text-xs text-slate-500">Try code <strong class="text-coffee-700">KOPIHEMAT</strong> or <strong class="text-coffee-700">COFFEEFIRST</strong></p>
                            </form>
                        @endif
                    </div>
                    
                    <!-- Dining & Checkout Details Form -->
                    <form action="{{ route('customer.checkout') }}" method="POST" class="space-y-4">
                        @csrf
                        <div x-data="{ orderType: 'dine_in' }">
                            <label class="text-sm font-semibold text-slate-900 block mb-2">Dining Option</label>
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <label class="flex items-center justify-center gap-2 p-3 rounded-xl border border-slate-200 cursor-pointer transition hover:bg-slate-50" :class="orderType === 'dine_in' ? 'border-coffee-700 bg-coffee-50/50 text-coffee-700 font-semibold' : ''">
                                    <input type="radio" name="order_type" value="dine_in" class="sr-only" x-model="orderType" required>
                                    <i class="fas fa-chair text-sm"></i> Dine In
                                </label>
                                <label class="flex items-center justify-center gap-2 p-3 rounded-xl border border-slate-200 cursor-pointer transition hover:bg-slate-50" :class="orderType === 'takeaway' ? 'border-coffee-700 bg-coffee-50/50 text-coffee-700 font-semibold' : ''">
                                    <input type="radio" name="order_type" value="takeaway" class="sr-only" x-model="orderType">
                                    <i class="fas fa-shopping-bag text-sm"></i> Takeaway
                                </label>
                            </div>
                            
                            <!-- Table Number Input (Only if Dine In) -->
                            <div x-show="orderType === 'dine_in'" class="space-y-2 mb-4">
                                <label class="text-sm font-semibold text-slate-900 block">Table Number</label>
                                <input type="number" name="table_number" placeholder="Enter your table number (e.g. 5)" class="input-field text-sm" :required="orderType === 'dine_in'">
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="pt-4 border-t border-slate-200">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-lg font-semibold text-slate-900">Total</span>
                                <span class="text-3xl font-bold text-coffee-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            
                            <button type="submit" class="w-full btn-coffee py-3 text-lg font-semibold flex items-center justify-center gap-2 shadow-lg">
                                <i class="fas fa-receipt"></i> Place Order
                            </button>
                        </div>
                    </form>
                    
                    <!-- Security & Info -->
                    <div class="space-y-2 pt-4">
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <i class="fas fa-lock text-coffee-700"></i>
                            Secure checkout and fresh brewing guaranteed
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-slate-600 mb-4">Add items to see summary</p>
                        <a href="{{ route('customer.order') }}" class="btn-coffee py-2 px-4 inline-block text-sm">Browse Menu</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
