@extends('customer.layouts.main')

@section('title', 'Selesaikan Pembayaran')

@section('content')
    <style>
        .payment-title {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
        }

        .checkout-card {
            background: white;
            border-radius: 16px;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow: hidden;
            height: 100%;
        }

        .checkout-header {
            background-color: #fff;
            border-bottom: 1px dashed #eee;
            padding: 20px 25px;
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #f9f9f9;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .item-img {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            background-color: #f0f0f0;
        }
        
        .payment-method-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .method-radio {
            display: none;
        }
        
        .method-card {
            cursor: pointer;
            border: 2px solid #f0f0f0;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            background: white;
            position: relative;
        }
        
        .method-card:hover {
            border-color: #e0e0e0;
            transform: translateY(-2px);
        }
        
        .method-radio:checked + .method-card {
            border-color: var(--primary-color);
            background-color: #fffbf7;
            box-shadow: 0 4px 12px rgba(111, 78, 55, 0.15);
        }
        
        .method-radio:checked + .method-card .method-icon {
            color: var(--primary-color);
        }
        
        .method-radio:checked + .method-card::after {
            content: '\f00c';
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--primary-color);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .method-icon {
            font-size: 1.8rem;
            color: #ccc;
            margin-bottom: 8px;
            transition: 0.3s;
        }
        
        .method-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            display: block;
        }

        .total-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .btn-pay {
            background: var(--primary-color);
            color: white;
            width: 100%;
            padding: 14px;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border: none;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(111, 78, 55, 0.3);
        }
        .btn-pay:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            color: white;
        }

        @media (max-width: 768px) {
            .payment-method-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container py-4">
        <div class="mb-4">
            <a href="{{ route('customer.cart') }}" class="text-decoration-none text-muted small">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Keranjang
            </a>
        </div>

        <div class="row g-4">
            
            <div class="col-lg-7">
                <h4 class="payment-title">Rincian Pesanan</h4>
                <div class="checkout-card mb-4">
                    <div class="checkout-header d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                        <span class="badge bg-light text-dark border">{{ $order->orderItems->count() }} Items</span>
                    </div>
                    <div class="p-4">
                        @foreach($order->orderItems as $item)
                        <div class="order-item">
                            @if($item->product && $item->product->gambar)
                                <img src="{{ asset($item->product->gambar) }}" alt="{{ $item->product->nama }}" class="item-img shadow-sm">
                            @else
                                <div class="item-img d-flex align-items-center justify-content-center text-muted shadow-sm">
                                    <i class="fas fa-mug-hot"></i>
                                </div>
                            @endif
                            
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold text-dark">{{ $item->product->nama ?? 'Produk Dihapus' }}</h6>
                                <small class="text-muted">{{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</small>
                            </div>
                            <div class="fw-bold text-primary-custom">
                                Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="bg-light p-4 border-top">
                        <div class="d-flex justify-content-between mb-2 small text-muted">
                            <span>Subtotal Produk</span>
                            <span>Rp {{ number_format($order->orderItems->sum(fn($i) => $i->harga * $i->jumlah), 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small text-muted">
                            <span>Biaya Layanan</span>
                            <span>Rp 0</span>
                        </div>
                        <hr class="my-2 opacity-25">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark">Total Tagihan</span>
                            <span class="fw-bold fs-5 text-primary-custom">Rp {{ number_format($order->orderItems->sum(fn($i) => $i->harga * $i->jumlah), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <h4 class="payment-title">Metode Pembayaran</h4>
                
                <form action="{{ route('customer.payment.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="amount" value="{{ $order->orderItems->sum(fn($i) => $i->harga * $i->jumlah) }}">

                    <div class="checkout-card p-4">
                        @if(session('error'))
                            <div class="alert alert-danger rounded-3 small mb-4">
                                <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                            </div>
                        @endif

                        <p class="small text-muted mb-3">Pilih cara pembayaran yang kamu inginkan:</p>
                        
                        <div class="payment-method-grid">
                            <label class="method-label">
                                <input type="radio" name="payment_method" value="bank_transfer" class="method-radio" checked>
                                <div class="method-card">
                                    <i class="fas fa-university method-icon"></i>
                                    <span class="method-name">Transfer Bank</span>
                                </div>
                            </label>

                            <label class="method-label">
                                <input type="radio" name="payment_method" value="e_wallet" class="method-radio">
                                <div class="method-card">
                                    <i class="fas fa-wallet method-icon"></i>
                                    <span class="method-name">E-Wallet</span>
                                </div>
                            </label>

                            <label class="method-label">
                                <input type="radio" name="payment_method" value="credit_card" class="method-radio">
                                <div class="method-card">
                                    <i class="fas fa-credit-card method-icon"></i>
                                    <span class="method-name">Kartu Kredit</span>
                                </div>
                            </label>

                            <label class="method-label">
                                <input type="radio" name="payment_method" value="cash" class="method-radio">
                                <div class="method-card">
                                    <i class="fas fa-money-bill-wave method-icon"></i>
                                    <span class="method-name">Tunai / Cash</span>
                                </div>
                            </label>
                        </div>

                        <div class="total-section text-center">
                            <small class="text-muted d-block mb-1">Total yang harus dibayar</small>
                            <h2 class="fw-bold text-dark m-0">Rp {{ number_format($order->orderItems->sum(fn($i) => $i->harga * $i->jumlah), 0, ',', '.') }}</h2>
                        </div>

                        <button type="submit" class="btn-pay">
                            <i class="fas fa-lock me-2"></i> Bayar Sekarang
                        </button>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="fas fa-shield-alt text-success me-1"></i> Pembayaran aman & terenkripsi.
                            </small>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection