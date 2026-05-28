@extends('customer.layouts.main-modern')

@section('title', 'Order History')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Header -->
    <div class="mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">My Orders</h1>
        <p class="text-lg text-slate-600 max-w-2xl">Manage and track your recent orders and coffee transactions.</p>
    </div>

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

    <div class="max-w-4xl mx-auto space-y-6">
        @forelse($orders as $order)
            @php
                $statusColors = match($order->status) {
                    'pending' => 'bg-amber-50 border-amber-200 text-amber-700',
                    'completed' => 'bg-green-50 border-green-200 text-green-700',
                    'cancelled' => 'bg-red-50 border-red-200 text-red-700',
                    default => 'bg-slate-50 border-slate-200 text-slate-700'
                };
                
                $totalOrder = $order->total_amount > 0 ? $order->total_amount : $order->orderItems->sum(fn($item) => $item->harga * $item->jumlah) * 1.1; // fallback tax
            @endphp

            <div class="card p-6 hover:shadow-hover transition-all border border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <!-- Left: Info -->
                <div class="flex-grow min-w-0">
                    <div class="flex items-center gap-3 flex-wrap mb-2">
                        <span class="font-bold text-slate-900 text-lg">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold border capitalize {{ $statusColors }}">
                            {{ $order->status }}
                        </span>
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] rounded-full font-semibold capitalize">
                            {{ str_replace('_', ' ', $order->order_type) }}
                        </span>
                    </div>
                    
                    <p class="text-slate-400 text-xs flex items-center gap-1.5 mb-4">
                        <i class="far fa-calendar-alt"></i> {{ $order->created_at->format('d M Y, H:i') }}
                    </p>

                    <!-- Preview Item -->
                    <div class="p-3 bg-slate-50 rounded-xl flex items-center gap-3 border border-slate-200/50">
                        <i class="fas fa-receipt text-coffee-700 text-sm"></i>
                        <span class="text-slate-700 text-sm truncate font-medium">
                            {{ $order->orderItems->first()->product->nama ?? 'Unknown Coffee' }}
                            @if($order->orderItems->count() > 1)
                                <span class="text-slate-500 font-normal"> + {{ $order->orderItems->count() - 1 }} other items</span>
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Right: Price and Action Button -->
                <div class="flex flex-col items-start md:items-end justify-between self-stretch md:self-auto flex-shrink-0">
                    <div class="mb-4 md:mb-0 md:text-right">
                        <span class="text-xs text-slate-400 block mb-0.5">Total Amount</span>
                        <span class="text-xl font-bold text-coffee-700">Rp {{ number_format($totalOrder, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex gap-2 w-full md:w-auto">
                        <a href="{{ route('customer.order.detail', $order->id) }}" class="px-4 py-2 border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl hover:border-coffee-700 hover:text-coffee-700 transition flex-1 md:flex-initial text-center">
                            Details
                        </a>

                        @if($order->status === 'pending')
                            <a href="{{ route('customer.payment', $order->id) }}" class="btn-coffee px-4 py-2 text-sm flex items-center gap-1.5 justify-center flex-1 md:flex-initial">
                                <i class="fas fa-wallet text-xs"></i> Pay
                            </a>
                        @elseif($order->status === 'completed')
                            <a href="{{ route('customer.order') }}" class="btn-coffee px-4 py-2 text-sm flex items-center gap-1.5 justify-center flex-1 md:flex-initial">
                                <i class="fas fa-rotate-left text-xs"></i> Order Again
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-12 text-center max-w-lg mx-auto">
                <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl border border-slate-100 shadow-sm">
                    <i class="far fa-file-lines"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-900 mb-2">No Orders Yet</h2>
                <p class="text-slate-600 mb-8">You haven't ordered any coffee yet. Get started by viewing our delicious menu!</p>
                <a href="{{ route('customer.order') }}" class="btn-coffee px-6 py-3 inline-block">
                    Browse Menu
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
