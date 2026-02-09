@extends('customer.layouts.main')

@section('title', 'Menu Kami')

@section('content')
    <style>
        .filter-bar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            z-index: 99;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .search-input {
            background-color: #f1f1f1;
            border: none;
            padding-left: 45px;
            height: 45px;
        }
        .search-input:focus {
            background-color: #fff;
            box-shadow: 0 0 0 2px var(--primary-color);
        }
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        .product-card {
            border: none;
            border-radius: 16px;
            background: white;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            height: 100%;
            overflow: hidden;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .card-img-wrapper {
            height: 180px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .card-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .product-card:hover .card-img-wrapper img {
            transform: scale(1.1);
        }

        .qty-control {
            background: #f8f9fa;
            border-radius: 50px;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .qty-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: none;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: var(--primary-color);
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s;
        }
        
        .qty-btn:active { transform: scale(0.9); }
        
        .qty-input {
            width: 30px;
            text-align: center;
            border: none;
            background: transparent;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0;
        }

        .btn-add-cart {
            background-color: var(--primary-color);
            color: white;
            border: none;
            width: 100%;
            padding: 8px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: 0.3s;
        }
        
        .btn-add-cart:hover {
            background-color: var(--secondary-color);
            color: white;
        }
    </style>

    <div class="filter-bar sticky-top py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-2 d-md-none">
                <h5 class="fw-bold m-0 text-primary-custom">Our Menu</h5>
            </div>
            
            <form method="GET" action="{{ route('customer.order') }}" class="row g-2 align-items-center">
                <div class="col-8 col-md-9">
                    <div class="position-relative">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" class="form-control rounded-pill search-input" placeholder="Search coffee..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-4 col-md-3">
                    <select name="sort" class="form-select rounded-pill border-0 bg-light" style="height: 45px; cursor: pointer;" onchange="this.form.submit()">
                        <option value="">Sort</option>
                        <option value="low-high" {{ request('sort') == 'low-high' ? 'selected' : '' }}>Lowest Price</option>
                        <option value="high-low" {{ request('sort') == 'high-low' ? 'selected' : '' }}>Highest Price</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
            @foreach($products as $product)
            <div class="col">
                <div class="product-card shadow-sm h-100">
                    <div class="card-img-wrapper">
                        <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}">
                    </div>
                    
                    <div class="p-3 d-flex flex-column justify-content-between" style="height: calc(100% - 180px);">
                        <div class="mb-3">
                            <small class="text-uppercase text-muted" style="font-size: 10px; letter-spacing: 1px;">Coffee</small>
                            <h6 class="fw-bold text-dark text-truncate mb-1">{{ $product->nama }}</h6>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-bold text-primary-custom">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                <span class="badge bg-light text-dark border"><i class="fas fa-star text-warning"></i> 4.8</span>
                            </div>
                        </div>

                        <form action="{{ route('customer.addToCart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="d-flex gap-2 align-items-center">
                                <div class="qty-control flex-grow-1">
                                    <button type="button" class="qty-btn decrease"><i class="fas fa-minus" style="font-size: 0.7rem;"></i></button>
                                    <input type="number" name="jumlah" class="qty-input" min="1" value="1" readonly>
                                    <button type="button" class="qty-btn increase"><i class="fas fa-plus" style="font-size: 0.7rem;"></i></button>
                                </div>
                                <button type="submit" class="btn btn-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                    <i class="fas fa-shopping-bag text-white" style="font-size: 0.9rem;"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        document.querySelectorAll('.increase').forEach(btn => {
            btn.addEventListener('click', e => {
                const input = e.target.closest('.qty-control').querySelector('input');
                input.value = parseInt(input.value) + 1;
            });
        });
        document.querySelectorAll('.decrease').forEach(btn => {
            btn.addEventListener('click', e => {
                const input = e.target.closest('.qty-control').querySelector('input');
                if(parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
            });
        });
    </script>
@endsection