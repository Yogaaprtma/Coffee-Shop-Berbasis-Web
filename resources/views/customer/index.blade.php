\@extends('customer.layouts.main')

@section('title', 'Welcome Home')

@section('content')
    <style>
        :root {
            --card-radius: 16px;
            --transition-speed: 0.3s;
        }

        .hero-section {
            background: url('{{ asset("storage/images/coffee.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed; 
            height: 75vh;
            max-height: 600px;
            border-radius: 0 0 40px 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 3rem;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 0 0 40px 40px;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 600px;
            text-align: center;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .hero-section {
                border-radius: 0 0 25px 25px;
                background-attachment: scroll;
                height: 65vh;
            }
            .hero-section::before { border-radius: 0 0 25px 25px; }
            .hero-content {
                width: 90%;
                padding: 2rem 1.5rem;
            }
        }

        .feature-box {
            transition: var(--transition-speed);
            border: 1px solid transparent;
        }
        .feature-box:hover {
            transform: translateY(-5px);
            border-color: rgba(111, 78, 55, 0.1);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
        }

        .category-card {
            border-radius: var(--card-radius);
            overflow: hidden;
            height: 180px;
            position: relative;
            cursor: pointer;
        }
        .category-card img {
            transition: transform 0.5s ease;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .category-card:hover img {
            transform: scale(1.1);
        }
        .category-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
        }

        .product-card {
            border: none;
            border-radius: var(--card-radius);
            background: #fff;
            transition: all var(--transition-speed);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .product-img-wrapper {
            height: 220px;
            overflow: hidden;
            position: relative;
            background-color: #f8f8f8;
        }
        .product-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            mix-blend-mode: multiply;
        }
        .wishlist-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: white;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: #ccc;
            transition: 0.2s;
            border: none;
            cursor: pointer;
        }
        .wishlist-btn:hover {
            color: #ff4757;
            transform: scale(1.1);
        }

        .promo-banner {
            background: linear-gradient(45deg, #6F4E37, #A67B5B);
            border-radius: 20px;
            padding: 3rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .promo-pattern {
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            opacity: 0.1;
            background-image: radial-gradient(#fff 2px, transparent 2px);
            background-size: 20px 20px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .see-all-link {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.2s;
        }
        .see-all-link:hover {
            color: var(--secondary-color);
            letter-spacing: 0.5px;
        }
    </style>

    <header class="hero-section">
        <div class="hero-content text-white">
            <span class="text-uppercase letter-spacing-2 small fw-bold mb-2 d-block text-warning">Premium Quality</span>
            <h1 class="display-5 fw-bold mb-3">Experience the Perfect Brew</h1>
            <p class="lead mb-4 fw-light opacity-90">Roasted with passion, brewed for your soul. Taste the difference in every cup.</p>
            <div class="d-flex gap-2 justify-content-center">
                <a href="{{ route('customer.order') }}" class="btn btn-light rounded-pill px-4 py-2 fw-bold shadow-sm text-primary-custom">
                    Order Now
                </a>
                <a href="#popular" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold backdrop-blur">
                    Explore
                </a>
            </div>
        </div>
    </header>

    <div class="container pb-5"> <div class="row g-3 mb-5 text-center">
            @php
                $features = [
                    ['icon' => 'fa-truck-fast', 'title' => 'Fast Delivery', 'desc' => 'Within 30 mins'],
                    ['icon' => 'fa-mug-hot', 'title' => 'Fresh Beans', 'desc' => '100% Arabica'],
                    ['icon' => 'fa-medal', 'title' => 'Best Quality', 'desc' => 'Premium roast'],
                    ['icon' => 'fa-headset', 'title' => '24/7 Support', 'desc' => 'Friendly Staff'],
                ];
            @endphp
            
            @foreach($features as $f)
            <div class="col-6 col-md-3">
                <div class="p-3 bg-white rounded-4 shadow-sm h-100 feature-box d-flex flex-column align-items-center justify-content-center">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3 text-primary-custom" style="width: 60px; height: 60px;">
                        <i class="fas {{ $f['icon'] }} fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-1">{{ $f['title'] }}</h6>
                    <p class="small text-muted mb-0">{{ $f['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mb-5">
            <div class="section-header">
                <h3 class="fw-bold m-0">Categories</h3>
            </div>
            <div class="row g-3">
                @foreach($categories as $category)
                <div class="col-6 col-md-3">
                    <a href="#" class="text-decoration-none text-white">
                        <div class="category-card shadow-sm">
                            <img src="{{ asset('storage/' . $category->gambar) }}" alt="{{ $category->nama }}">
                            <div class="category-overlay">
                                <div>
                                    <h5 class="fw-bold text-uppercase mb-0">{{ $category->nama }}</h5>
                                    <small class="opacity-75">Explore Items <i class="fas fa-arrow-right ms-1"></i></small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <div class="mb-5" id="popular">
            <div class="section-header">
                <div>
                    <h3 class="fw-bold m-0">Popular Now</h3>
                    <p class="text-muted small m-0">Best coffee choices for you</p>
                </div>
                <a href="{{ route('customer.order') }}" class="see-all-link">See All <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <div class="row row-cols-2 row-cols-md-4 g-3">
                @foreach($featuredProducts as $product)
                <div class="col">
                    <div class="product-card shadow-sm">
                        <div class="product-img-wrapper">
                            <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}">
                            <button class="wishlist-btn"><i class="fas fa-heart"></i></button>
                            <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2 rounded-pill px-2">
                                <i class="fas fa-star small me-1"></i> 4.8
                            </span>
                        </div>
                        <div class="p-3">
                            <small class="text-muted text-uppercase" style="font-size: 0.7rem;">{{ $product->category->nama ?? 'Coffee' }}</small>
                            <h6 class="fw-bold text-dark text-truncate mb-1">{{ $product->nama }}</h6>
                            <div class="d-flex justify-content-between align-items-end mt-2">
                                <span class="fw-bold text-primary-custom fs-5">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                <form action="{{ route('customer.addToCart') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-coffee rounded-3 shadow-sm py-1 px-2">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="promo-banner mb-5 shadow">
            <div class="promo-pattern"></div>
            <div class="row align-items-center position-relative z-1">
                <div class="col-md-7">
                    <span class="badge bg-warning text-dark mb-2">Limited Offer</span>
                    <h2 class="fw-bold mb-2">Get 20% Off Your First Order!</h2>
                    <p class="mb-4 opacity-90">Join the Beanie club and discover a world of premium coffee delivered to your doorstep.</p>
                    <a href="#" class="btn btn-light text-primary-custom fw-bold rounded-pill px-4">Claim Offer</a>
                </div>
                <div class="col-md-5 d-none d-md-block text-center">
                    <i class="fas fa-mug-hot" style="font-size: 8rem; opacity: 0.2; color: white;"></i>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100 border">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                        <h4 class="fw-bold m-0"><i class="fas fa-clock text-warning me-2"></i>New Arrivals</h4>
                    </div>
                    
                    @foreach($newArrivals->take(3) as $product)
                    <div class="d-flex align-items-center mb-3 p-2 rounded hover-bg-light transition-all">
                        <img src="{{ asset($product->gambar) }}" class="rounded-3 me-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0 text-dark">{{ $product->nama }}</h6>
                            <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                        </div>
                        <span class="fw-bold text-primary-custom">Rp {{ number_format($product->harga/1000, 0) }}k</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-6">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100 border">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                        <h4 class="fw-bold m-0"><i class="fas fa-fire text-danger me-2"></i>Best Selling</h4>
                    </div>

                    @foreach($bestSelling->take(3) as $index => $product)
                    <div class="d-flex align-items-center mb-3 p-2 rounded hover-bg-light transition-all">
                        <div class="me-3 position-relative">
                            <img src="{{ asset($product->gambar) }}" class="rounded-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                            <span class="position-absolute top-0 start-0 translate-middle badge rounded-circle bg-dark border border-white" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;">
                                {{ $index + 1 }}
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0 text-dark">{{ $product->nama }}</h6>
                            <small class="text-muted">{{ $product->order_items_count }} Sold</small>
                        </div>
                        <span class="fw-bold text-primary-custom">Rp {{ number_format($product->harga/1000, 0) }}k</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mb-5" id="blog">
            <div class="section-header">
                <h3 class="fw-bold m-0">Brewing Tips</h3>
                <a href="{{ route('customer.blog') }}" class="see-all-link">Read Blog</a>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden feature-box">
                        <div class="row g-0 h-100">
                            <div class="col-4">
                                <img src="{{ asset('images/blog1.jpg') }}" class="img-fluid h-100 object-fit-cover" alt="Blog">
                            </div>
                            <div class="col-8">
                                <div class="card-body h-100 d-flex flex-column justify-content-center">
                                    <small class="text-muted mb-1">Tips & Tricks</small>
                                    <h5 class="card-title fw-bold mb-2">Perfect V60 Guide</h5>
                                    <p class="card-text text-muted small mb-2 d-none d-md-block">The ultimate guide to brewing clear coffee manually.</p>
                                    <a href="#" class="text-primary-custom fw-bold text-decoration-none small">Read Article</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden feature-box">
                        <div class="row g-0 h-100">
                            <div class="col-4">
                                <img src="{{ asset('images/blog1.jpg') }}" class="img-fluid h-100 object-fit-cover" alt="Blog" style="filter: hue-rotate(45deg);">
                            </div>
                            <div class="col-8">
                                <div class="card-body h-100 d-flex flex-column justify-content-center">
                                    <small class="text-muted mb-1">Knowledge</small>
                                    <h5 class="card-title fw-bold mb-2">Arabica vs Robusta</h5>
                                    <p class="card-text text-muted small mb-2 d-none d-md-block">Understanding the difference in taste and caffeine.</p>
                                    <a href="#" class="text-primary-custom fw-bold text-decoration-none small">Read Article</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection