@extends('customer.layouts.main')

@section('title', 'Shopping Cart')

@section('content')
<style>
    .cart-item-card {
        background: white;
        border-radius: 16px;
        transition: 0.3s;
        border: 1px solid transparent;
    }
    .cart-item-card:hover {
        border-color: var(--primary-color);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .img-box {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        overflow: hidden;
        background-color: #f8f9fa;
    }
    .img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .summary-card {
        background: white;
        border-radius: 20px;
        position: sticky;
        top: 100px;
    }
    
    /* Style untuk tombol quantity */
    .qty-btn-sm {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 1px solid #ddd;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        color: var(--primary-color);
        transition: 0.2s;
        cursor: pointer;
    }
    .qty-btn-sm:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
</style>

<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <h3 class="fw-bold m-0 me-2">Your Cart</h3>
        <span class="badge bg-primary-custom rounded-pill">{{ count($cart) }} Items</span>
    </div>

    @if(session('error'))
        <div class="alert alert-danger rounded-4 mb-4">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success rounded-4 mb-4">{{ session('success') }}</div>
    @endif

    @if(count($cart) > 0)
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="d-flex flex-column gap-3">
                @foreach($cart as $id => $item)
                <div class="cart-item-card p-3 shadow-sm d-flex align-items-center gap-3">
                    <div class="img-box flex-shrink-0">
                        @if(isset($item['gambar']))
                             <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama'] }}">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                <i class="fas fa-mug-hot fa-2x"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{{ $item['nama'] }}</h6>
                                
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <form action="{{ route('customer.cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <input type="hidden" name="quantity" value="{{ $item['jumlah'] - 1 }}">
                                        <button type="submit" class="qty-btn-sm" {{ $item['jumlah'] <= 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </form>

                                    <span class="fw-bold text-dark" style="font-size: 0.9rem; min-width: 20px; text-align: center;">{{ $item['jumlah'] }}</span>

                                    <form action="{{ route('customer.cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <input type="hidden" name="quantity" value="{{ $item['jumlah'] + 1 }}">
                                        <button type="submit" class="qty-btn-sm">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-primary-custom d-block">Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                                <small class="text-muted" style="font-size: 0.75rem;">@ Rp {{ number_format($item['harga'], 0, ',', '.') }}</small>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-2">
                            <form action="{{ route('customer.cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none small">
                                    <i class="fas fa-trash-alt me-1"></i> Remove
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-4">
            <div class="summary-card p-4 shadow-sm">
                <h5 class="fw-bold mb-4">Order Summary</h5>
                
                <div class="d-flex justify-content-between mb-2 text-muted small">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format(collect($cart)->sum('total'), 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2 text-muted small">
                    <span>Service Fee</span>
                    <span>Rp 0</span>
                </div>
                <div class="d-flex justify-content-between mb-4 text-muted small">
                    <span>Discount</span>
                    <span class="text-success">- Rp 0</span>
                </div>
                
                <div class="border-top border-dashed py-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5 text-primary-custom">Rp {{ number_format(collect($cart)->sum('total'), 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <form action="{{ route('customer.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-coffee w-100 py-3 fw-bold shadow-sm rounded-pill">
                        Checkout Now <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="{{ route('customer.order') }}" class="text-muted small text-decoration-none">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="d-flex flex-column align-items-center justify-content-center py-5 text-center">
            <div class="bg-white p-5 rounded-circle shadow-sm mb-4" style="width: 200px; height: 200px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-shopping-basket fa-5x text-muted opacity-25"></i>
            </div>
            <h3 class="fw-bold text-dark">Your cart is empty</h3>
            <p class="text-muted mb-4" style="max-width: 400px;">Looks like you haven't added any coffee to your cart yet.</p>
            <a href="{{ route('customer.order') }}" class="btn btn-coffee rounded-pill px-5 py-3 fw-bold">
                Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection