@extends('admin.layouts.main')

@section('title', 'User Orders')
@section('page-title', 'Orders')

@section('content')
    <style>
        .page-header-container {
            margin-bottom: 1.5rem;
        }

        .search-group {
            position: relative;
            width: 100%;
            max-width: 300px;
        }

        .search-input {
            border-radius: 50px;
            padding-left: 45px;
            padding-right: 20px;
            border: 1px solid #eee;
            background-color: white;
            height: 45px;
            font-size: 0.9rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            background-color: white;
            border-color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(111, 78, 55, 0.1);
            outline: none;
        }

        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 1rem;
        }

        .table-card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
            overflow: hidden;
        }

        .table thead th {
            background-color: #f9fafb;
            color: #6b7280;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px;
            border-bottom: 1px solid #f0f0f0;
        }

        .table tbody td {
            padding: 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
            font-size: 0.9rem;
        }

        .mobile-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 16px;
            border: 1px solid #f3f4f6;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            transition: transform 0.2s;
            position: relative;
            overflow: hidden;
        }

        .mobile-card:active {
            transform: scale(0.99);
        }
        
        .border-status-pending { 
            border-left: 5px solid #ffc107; 
        }

        .border-status-completed { 
            border-left: 5px solid #198754; 
        }

        .border-status-cancelled { 
            border-left: 5px solid #dc3545; 
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending { 
            background-color: #fff3cd; 
            color: #856404; 
        }

        .status-completed { 
            background-color: #d1e7dd; 
            color: #0f5132; 
        }

        .status-cancelled { 
            background-color: #f8d7da; 
            color: #842029; 
        }

        .price-text {
            color: var(--primary-color);
            font-weight: 700;
        }
        
        .item-list-small {
            font-size: 0.85rem;
            color: #666;
            line-height: 1.4;
        }
    </style>

    <div class="container-fluid p-0">
        <div class="row align-items-center mb-4 g-3 page-header-container">
            <div class="col-12 col-md-auto me-auto">
                <div class="search-group">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="form-control search-input" placeholder="Search orders..." id="searchOrder">
                </div>
            </div>
            
            <div class="col-12 col-md-auto d-none d-md-block">
                <div class="text-muted small">
                    Total Orders: <span class="fw-bold text-dark">{{ count($orders) }}</span>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2 fs-5"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card table-card d-none d-md-block">
            <div class="card-body p-0">
                <table class="table mb-0 w-100">
                    <thead>
                        <tr>
                            <th width="80" class="text-center">ID</th>
                            <th>Customer</th>
                            <th width="30%">Items</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="text-center fw-bold text-muted">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                        <i class="fas fa-user text-muted small"></i>
                                    </div>
                                    <span class="fw-medium text-dark">{{ $order->user->nama }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="item-list-small">
                                    @foreach($order->orderItems as $item)
                                        <div>
                                            <span class="fw-bold">{{ $item->jumlah }}x</span> {{ $item->product->nama }}
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center text-muted small">
                                {{ $order->created_at->format('d M Y') }}
                                <br>
                                <span style="font-size: 0.7rem">{{ $order->created_at->format('H:i') }}</span>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusClass = match($order->status) {
                                        'pending' => 'status-pending',
                                        'completed' => 'status-completed',
                                        'cancelled' => 'status-cancelled',
                                        default => 'bg-light'
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="text-end price-text">
                                Rp {{ number_format($order->orderItems->sum(fn($i) => $i->harga * $i->jumlah), 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="bg-light rounded-circle p-4 mb-3">
                                        <i class="fas fa-shopping-bag text-muted fs-2"></i>
                                    </div>
                                    <h6 class="text-muted fw-bold">No orders found</h6>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-md-none order-list">
            @forelse($orders as $order)
                @php
                    $borderClass = match($order->status) {
                        'pending' => 'border-status-pending',
                        'completed' => 'border-status-completed',
                        'cancelled' => 'border-status-cancelled',
                        default => ''
                    };
                    
                    $statusBadge = match($order->status) {
                        'pending' => 'status-pending',
                        'completed' => 'status-completed',
                        'cancelled' => 'status-cancelled',
                        default => 'bg-light'
                    };
                @endphp

                <div class="mobile-card {{ $borderClass }}">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-dark">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-muted small" style="font-size: 0.75rem;">
                                <i class="far fa-clock me-1"></i> {{ $order->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                        <span class="status-badge {{ $statusBadge }}">{{ ucfirst($order->status) }}</span>
                    </div>

                    <div class="bg-light rounded p-3 mb-3">
                        <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                            <i class="fas fa-user-circle me-2 text-muted"></i>
                            <span class="fw-medium text-dark small">{{ $order->user->nama }}</span>
                        </div>
                        <div class="item-list-small">
                            @foreach($order->orderItems as $item)
                                <div class="d-flex justify-content-between mb-1">
                                    <span>{{ $item->product->nama }}</span>
                                    <span class="fw-bold">x{{ $item->jumlah }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Total Payment</span>
                        <span class="price-text fs-5">
                            Rp {{ number_format($order->orderItems->sum(fn($i) => $i->harga * $i->jumlah), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x mb-3 text-muted opacity-25"></i>
                    <p class="text-muted small">No orders available</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchOrder');
            
            searchInput.addEventListener('keyup', function() {
                const value = this.value.toLowerCase();
                
                // Filter Desktop Table
                const rows = document.querySelectorAll('table tbody tr');
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(value) ? '' : 'none';
                });

                // Filter Mobile Cards
                const cards = document.querySelectorAll('.mobile-card');
                cards.forEach(card => {
                    const text = card.innerText.toLowerCase();
                    card.style.display = text.includes(value) ? 'block' : 'none';
                });
            });
        });
    </script>
@endsection