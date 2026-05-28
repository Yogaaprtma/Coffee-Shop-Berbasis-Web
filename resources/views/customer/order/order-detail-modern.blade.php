@extends('customer.layouts.main-modern')

@section('title', 'Order Details #' . str_pad($order->id, 5, '0', STR_PAD_LEFT))

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Back Navigation -->
    <div class="mb-8">
        <a href="{{ route('customer.history') }}" class="inline-flex items-center gap-2 text-coffee-700 font-semibold hover:text-coffee-800 transition">
            <i class="fas fa-arrow-left"></i> Back to History
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Order Tracking and Items -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Header Card -->
            <div class="card p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 mb-1">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
                        <p class="text-slate-500 text-sm">Placed on {{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    
                    @php
                        $badgeColors = match($order->status) {
                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                            'completed' => 'bg-green-100 text-green-700 border-green-200',
                            'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                            default => 'bg-slate-100 text-slate-700 border-slate-200'
                        };
                    @endphp
                    <span class="px-4 py-2 border rounded-full text-sm font-bold capitalize {{ $badgeColors }}">
                        {{ $order->status }}
                    </span>
                </div>

                <!-- Interactive Progress Timeline / Order Status Tracker -->
                <div class="py-6">
                    <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-6">Order Status</h3>
                    
                    <!-- Timeline container -->
                    <div class="relative flex items-center justify-between">
                        <!-- Background progress bar line -->
                        <div class="absolute left-0 right-0 h-1 bg-slate-200 top-1/2 -translate-y-1/2 z-0"></div>
                        
                        <!-- Filled progress bar line -->
                        @php
                            $progressPercent = match($order->status) {
                                'pending' => '10%',
                                'completed' => '100%',
                                'cancelled' => '100%',
                                default => '50%'
                            };
                            
                            $progressBarColor = $order->status === 'cancelled' ? 'bg-red-500' : 'bg-coffee-700';
                        @endphp
                        <div class="absolute left-0 h-1 {{ $progressBarColor }} top-1/2 -translate-y-1/2 z-0 transition-all duration-500" style="width: {{ $progressPercent }};"></div>

                        <!-- Step 1: Placed -->
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 font-semibold text-sm transition-all {{ $order->status === 'cancelled' ? 'bg-red-50 border-red-500 text-red-500' : 'bg-coffee-700 border-coffee-700 text-white shadow-md' }}">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-900 mt-2 text-center">Placed</span>
                        </div>

                        <!-- Step 2: Preparing / Brewing -->
                        @php
                            $isPreparingActive = $order->status === 'completed' || ($order->status !== 'pending' && $order->status !== 'cancelled');
                        @endphp
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 font-semibold text-sm transition-all {{ $isPreparingActive ? 'bg-coffee-700 border-coffee-700 text-white shadow-md' : 'bg-white border-slate-200 text-slate-400' }}">
                                <i class="fas fa-mug-hot"></i>
                            </div>
                            <span class="text-xs font-bold mt-2 text-center {{ $isPreparingActive ? 'text-slate-900' : 'text-slate-400' }}">Brewing</span>
                        </div>

                        <!-- Step 3: Completed / Cancelled -->
                        @php
                            $isEndActive = $order->status === 'completed' || $order->status === 'cancelled';
                            $endIcon = $order->status === 'cancelled' ? 'fa-times' : 'fa-flag-checkered';
                            $endColor = $order->status === 'cancelled' ? 'bg-red-50 border-red-500 text-red-500' : ($order->status === 'completed' ? 'bg-coffee-700 border-coffee-700 text-white' : 'bg-white border-slate-200 text-slate-400');
                        @endphp
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 font-semibold text-sm transition-all {{ $endColor }}">
                                <i class="fas {{ $endIcon }}"></i>
                            </div>
                            <span class="text-xs font-bold mt-2 text-center {{ $isEndActive ? 'text-slate-900' : 'text-slate-400' }}">
                                {{ $order->status === 'cancelled' ? 'Cancelled' : 'Ready / Done' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ordered Items List -->
            <div class="card p-6 space-y-4">
                <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-3">Items Ordered</h2>
                <div class="divide-y divide-slate-100">
                    @foreach($order->orderItems as $item)
                    <div class="py-4 flex gap-4">
                        <!-- Product Thumb -->
                        <div class="w-16 h-16 rounded-lg overflow-hidden bg-slate-100 flex-shrink-0">
                            <img src="{{ asset($item->product->gambar ?? 'images/coffee-placeholder.jpg') }}" alt="{{ $item->product->nama ?? 'Product' }}" class="w-full h-full object-cover">
                        </div>
                        
                        <!-- Item Details -->
                        <div class="flex-grow min-w-0">
                            <h4 class="font-bold text-slate-900 truncate mb-1">
                                @if($item->product)
                                <a href="{{ route('customer.product.detail', $item->product_id) }}" class="hover:text-coffee-700">{{ $item->product->nama }}</a>
                                @else
                                Product Deleted
                                @endif
                            </h4>
                            <p class="text-xs text-slate-400 mb-2">{{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                            
                            <!-- Customizations display -->
                            @if($item->options)
                            <div class="flex flex-wrap gap-1.5">
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] rounded-full font-semibold">Size: {{ $item->options['size'] ?? 'S' }}</span>
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] rounded-full font-semibold capitalize">Temp: {{ $item->options['temperature'] ?? 'hot' }}</span>
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] rounded-full font-semibold capitalize">Sugar: {{ str_replace('_', ' ', $item->options['sugar'] ?? 'normal') }}</span>
                                @if(!empty($item->options['extras']))
                                    @foreach($item->options['extras'] as $extra)
                                    <span class="px-2 py-0.5 bg-amber-50 text-amber-600 text-[10px] rounded-full font-semibold capitalize">+ {{ str_replace('_', ' ', $extra) }}</span>
                                    @endforeach
                                @endif
                            </div>
                            @endif
                        </div>

                        <!-- Subtotal -->
                        <span class="font-bold text-slate-900 text-sm whitespace-nowrap self-center">
                            Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Side: Order Summary & Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Payment and Delivery/Dining Info -->
            <div class="card p-6 space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 mb-4">Dining Details</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Order Option</span>
                            <span class="font-bold text-slate-900 capitalize">{{ str_replace('_', ' ', $order->order_type) }}</span>
                        </div>
                        @if($order->order_type === 'dine_in')
                        <div class="flex justify-between">
                            <span class="text-slate-500">Table Number</span>
                            <span class="font-bold text-coffee-700 bg-coffee-50 px-3 py-1 rounded-lg">Table #{{ $order->table_number ?? '-' }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 mb-4">Payment Summary</h3>
                    <div class="space-y-3 text-sm">
                        @php
                            $subtotal = $order->orderItems->sum(fn($i) => $i->harga * $i->jumlah);
                            $discount = $order->discount_amount;
                            $tax = ($subtotal - $discount) * 0.1;
                            $total = ($subtotal - $discount) + $tax;
                        @endphp
                        
                        <div class="flex justify-between">
                            <span class="text-slate-500">Subtotal</span>
                            <span class="text-slate-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        @if($discount > 0)
                        <div class="flex justify-between text-green-600 font-semibold">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-tag text-xs"></i> Discount
                            </span>
                            <span>- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between">
                            <span class="text-slate-500">Tax (10%)</span>
                            <span class="text-slate-900">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between text-base font-bold pt-3 border-t border-slate-100">
                            <span class="text-slate-900">Grand Total</span>
                            <span class="text-coffee-700 text-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-3">Transaction Method</h3>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Method</span>
                        <span class="font-bold text-slate-900">{{ ucfirst(str_replace('_', ' ', $order->payment->payment_method ?? '-')) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm mt-2">
                        <span class="text-slate-500">Payment Status</span>
                        <span class="font-bold {{ $order->payment ? 'text-green-600' : 'text-amber-500' }}">
                            {{ $order->payment ? 'Lunas (Paid)' : 'Pending Payment' }}
                        </span>
                    </div>
                </div>

                @if($order->status === 'pending')
                    <a href="{{ route('customer.payment', $order->id) }}" class="w-full btn-coffee py-3 flex items-center justify-center gap-2 font-semibold">
                        <i class="fas fa-wallet"></i> Pay Now
                    </a>
                @endif
            </div>

            <!-- WhatsApp Support Card -->
            <div class="card p-6 text-center">
                <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 text-xl border border-slate-200">
                    <i class="fas fa-headset"></i>
                </div>
                <h4 class="font-bold text-slate-900 mb-1">Need Assistance?</h4>
                <p class="text-slate-500 text-xs mb-4">If you have any questions or changes to your order, chat with our barista support.</p>
                
                @php
                    $phoneNumber = '6282110778946'; 
                    $waMessage = "Hello Beanie Coffee, I need assistance regarding Order #" . str_pad($order->id, 5, '0', STR_PAD_LEFT);
                    $waUrl = "https://wa.me/$phoneNumber?text=" . urlencode($waMessage);
                @endphp

                <a href="{{ $waUrl }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white py-2.5 rounded-xl text-sm font-bold transition shadow-sm">
                    <i class="fab fa-whatsapp text-base"></i> WhatsApp Barista
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
