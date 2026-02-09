@extends('customer.layouts.main')

@section('title', 'Riwayat Pesanan')

@section('content')
    <style>
        .history-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #f0f0f0;
            border-left: 6px solid #ccc;
            transition: 0.3s;
        }
        .history-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }
        
        .border-pending { 
            border-left-color: #ffc107; 
        }

        .border-completed { 
            border-left-color: #198754; 
        }

        .border-cancelled { 
            border-left-color: #dc3545; 
        }
        
        .badge-pending { 
            background: #fff3cd; 
            color: #856404; 
        }

        .badge-completed { 
            background: #d1e7dd; 
            color: #0f5132; 
        }

        .badge-cancelled { 
            background: #f8d7da; 
            color: #842029; 
            }
    </style>

    <div class="container py-4">
        <h3 class="fw-bold mb-4">My Orders</h3>

        @forelse($orders as $order)
            @php
                $statusBorder = match($order->status) {
                    'pending' => 'border-pending',
                    'completed' => 'border-completed',
                    'cancelled' => 'border-cancelled',
                    default => ''
                };
                
                $statusBadge = match($order->status) {
                    'pending' => 'badge-pending',
                    'completed' => 'badge-completed',
                    'cancelled' => 'badge-cancelled',
                    default => 'bg-light text-dark'
                };
                
                $totalOrder = $order->orderItems->sum(fn($item) => $item->harga * $item->jumlah);
            @endphp

            <div class="history-card p-4 mb-4 shadow-sm {{ $statusBorder }}">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
                    <div class="mb-2 mb-md-0">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold text-dark">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span class="badge rounded-pill {{ $statusBadge }} px-3">{{ ucfirst($order->status) }}</span>
                        </div>
                        <small class="text-muted"><i class="far fa-clock me-1"></i> {{ $order->created_at->format('d M Y, H:i') }}</small>
                    </div>
                    <div class="text-md-end">
                        <small class="text-muted d-block">Total Amount</small>
                        <span class="fw-bold fs-5 text-primary-custom">Rp {{ number_format($totalOrder, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="bg-light p-3 rounded-3 mb-3">
                    <div class="d-flex align-items-center text-muted small">
                        <i class="fas fa-receipt me-2"></i>
                        <span class="text-truncate">
                            {{ $order->orderItems->first()->product->nama ?? 'Unknown Product' }}
                            @if($order->orderItems->count() > 1)
                                <span class="fw-bold text-dark">+ {{ $order->orderItems->count() - 1 }} items lainnya</span>
                            @endif
                        </span>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    @if($order->status == 'pending')
                        <a href="{{ route('customer.payment', $order->id) }}" class="btn btn-dark rounded-pill px-4 btn-sm">
                            Pay Now <i class="fas fa-chevron-right ms-1"></i>
                        </a>
                    @else
                        <button class="btn btn-outline-secondary rounded-pill px-4 btn-sm" disabled>View Details</button>
                        @if($order->status == 'completed')
                        <a href="{{ route('customer.order') }}" class="btn btn-coffee rounded-pill px-4 btn-sm">Buy Again</a>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-file-invoice fa-4x text-muted opacity-25"></i>
                </div>
                <h5 class="fw-bold text-muted">No orders yet</h5>
                <p class="text-muted small mb-4">You haven't placed any orders yet.</p>
                <a href="{{ route('customer.order') }}" class="btn btn-outline-dark rounded-pill px-4">Browse Menu</a>
            </div>
        @endforelse
    </div>
@endsection