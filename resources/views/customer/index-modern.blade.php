@extends('customer.layouts.main-modern')

@section('title', 'Welcome Home')

@section('content')

<!-- Hero Section with Gradient -->
<section class="relative overflow-hidden bg-gradient-to-br from-coffee-700 via-coffee-600 to-coffee-800 pt-12 pb-32 md:pt-20 md:pb-40">
    <!-- Decorative elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-accent-400 rounded-full blur-3xl opacity-10 -mr-48"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent-300 rounded-full blur-3xl opacity-10 -ml-48"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 mb-6 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-white text-sm font-semibold border border-white/30">
                <i class="fas fa-star text-yellow-300"></i>
                <span>Premium Quality Coffee</span>
            </div>
            
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                Experience the Perfect Brew
            </h1>
            
            <p class="text-lg text-white/90 mb-8 leading-relaxed">
                Roasted with passion, brewed for your soul. Taste the difference in every cup. Our premium selection of arabica beans is handpicked and freshly roasted.
            </p>
            
            <div class="flex gap-4 flex-wrap">
                <a href="{{ route('customer.order') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-coffee-700 rounded-full font-semibold hover:bg-slate-50 transition-all transform hover:scale-105 shadow-lg">
                    <i class="fas fa-shopping-bag"></i>
                    Order Now
                </a>
                <a href="#explore" class="inline-flex items-center gap-2 px-8 py-4 border-2 border-white text-white rounded-full font-semibold hover:bg-white/10 transition-all">
                    Explore Menu
                    <i class="fas fa-arrow-down"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Grid -->
<section class="container mx-auto px-4 -mt-20 relative z-20 mb-16">
    <div class="grid md:grid-cols-4 gap-4">
        @php
            $features = [
                ['icon' => 'fa-truck-fast', 'title' => 'Fast Delivery', 'desc' => 'Within 30 mins'],
                ['icon' => 'fa-mug-hot', 'title' => 'Fresh Beans', 'desc' => '100% Arabica'],
                ['icon' => 'fa-medal', 'title' => 'Best Quality', 'desc' => 'Premium roast'],
                ['icon' => 'fa-headset', 'title' => '24/7 Support', 'desc' => 'Friendly Staff'],
            ];
        @endphp
        
        @foreach($features as $f)
        <div class="card p-6 text-center hover:shadow-hover transform hover:-translate-y-1 transition-all">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-coffee-100 to-accent-100 flex items-center justify-center mx-auto mb-4">
                <i class="fas {{ $f['icon'] }} text-coffee-700 text-2xl"></i>
            </div>
            <h3 class="font-bold text-slate-900 mb-2">{{ $f['title'] }}</h3>
            <p class="text-sm text-slate-600">{{ $f['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

<!-- Categories Section -->
<section class="container mx-auto px-4 py-16">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900 mb-2">Categories</h2>
        <p class="text-slate-600">Explore our finest selection</p>
    </div>
    
    <div class="grid md:grid-cols-4 gap-6">
        @foreach($categories as $category)
        <div class="group cursor-pointer relative h-48 rounded-2xl overflow-hidden shadow-card hover:shadow-hover transition-all transform hover:-translate-y-2">
            <img src="{{ asset('storage/' . $category->gambar) }}" alt="{{ $category->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                <div class="text-white">
                    <h4 class="text-xl font-bold mb-2">{{ $category->nama }}</h4>
                    <div class="flex items-center gap-2 text-sm opacity-90">
                        Explore <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Popular Products -->
<section id="explore" class="container mx-auto px-4 py-16">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-900 mb-2">Popular Now</h2>
            <p class="text-slate-600">Best coffee choices for you</p>
        </div>
        <a href="{{ route('customer.order') }}" class="text-coffee-700 font-semibold hover:text-coffee-800 flex items-center gap-2">
            See All <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    
    <div class="grid md:grid-cols-4 gap-6">
        @foreach($featuredProducts as $product)
        <div class="card-product overflow-hidden group">
            <!-- Image Container -->
            <div class="relative h-48 overflow-hidden bg-slate-100">
                <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                
                <!-- Wishlist Button -->
                <button class="absolute top-3 right-3 w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center text-slate-400 hover:text-red-500 transition-colors transform hover:scale-110" title="Add to wishlist">
                    <i class="fas fa-heart"></i>
                </button>
                
                <!-- Rating Badge -->
                <div class="absolute top-3 left-3 badge-coffee">
                    <i class="fas fa-star text-xs mr-1"></i> 4.8
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="p-4">
                <p class="text-xs font-semibold text-slate-500 uppercase mb-1">{{ $product->category->nama ?? 'Coffee' }}</p>
                <h3 class="font-bold text-slate-900 truncate mb-3">{{ $product->nama }}</h3>
                
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold text-coffee-700">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    <form action="{{ route('customer.addToCart') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="w-8 h-8 rounded-full bg-coffee-700 text-white hover:bg-coffee-800 transition-all flex items-center justify-center shadow-md transform hover:scale-110">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Promo Banner -->
<section class="container mx-auto px-4 py-16">
    <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-coffee-600 to-coffee-800 p-8 md:p-16 text-white">
        <!-- Decorative pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative z-10 grid md:grid-cols-2 gap-8 items-center">
            <div>
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-400/20 rounded-full text-yellow-200 text-sm font-semibold mb-4 backdrop-blur">
                    <i class="fas fa-gift"></i> Limited Offer
                </span>
                <h2 class="text-4xl font-bold mb-4">Get 20% Off Your First Order!</h2>
                <p class="text-white/90 mb-6 text-lg">Join the Beanie club and discover a world of premium coffee delivered to your doorstep.</p>
                <button class="inline-flex items-center gap-2 px-8 py-3 bg-white text-coffee-700 rounded-full font-semibold hover:bg-slate-100 transition-all transform hover:scale-105">
                    Claim Offer
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
            <div class="hidden md:flex justify-center">
                <i class="fas fa-mug-hot text-9xl opacity-20"></i>
            </div>
        </div>
    </div>
</section>

<!-- New Arrivals & Best Selling -->
<section class="container mx-auto px-4 py-16">
    <div class="grid md:grid-cols-2 gap-8">
        <!-- New Arrivals -->
        <div class="card p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <i class="fas fa-sparkles text-2xl text-amber-500"></i>
                <h3 class="text-2xl font-bold text-slate-900">New Arrivals</h3>
            </div>
            
            <div class="space-y-4">
                @foreach($newArrivals->take(3) as $product)
                <div class="flex gap-4 p-3 rounded-lg hover:bg-slate-50 transition-all cursor-pointer group">
                    <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="w-16 h-16 rounded-lg object-cover shadow-sm">
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-slate-900 truncate group-hover:text-coffee-700">{{ $product->nama }}</h4>
                        <p class="text-xs text-slate-500">{{ $product->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="font-bold text-coffee-700 whitespace-nowrap">Rp {{ number_format($product->harga/1000, 0) }}k</span>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Best Selling -->
        <div class="card p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <i class="fas fa-fire text-2xl text-red-500"></i>
                <h3 class="text-2xl font-bold text-slate-900">Best Selling</h3>
            </div>
            
            <div class="space-y-4">
                @foreach($bestSelling->take(3) as $index => $product)
                <div class="flex gap-4 p-3 rounded-lg hover:bg-slate-50 transition-all cursor-pointer group">
                    <div class="relative">
                        <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="w-16 h-16 rounded-lg object-cover shadow-sm">
                        <span class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-slate-900 text-white text-xs font-bold flex items-center justify-center shadow-md">
                            {{ $index + 1 }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-slate-900 truncate group-hover:text-coffee-700">{{ $product->nama }}</h4>
                        <p class="text-xs text-slate-500">{{ $product->order_items_count ?? 0 }} Sold</p>
                    </div>
                    <span class="font-bold text-coffee-700 whitespace-nowrap">Rp {{ number_format($product->harga/1000, 0) }}k</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Blog/Tips Section -->
<section class="container mx-auto px-4 py-16">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-900 mb-2">Brewing Tips</h2>
            <p class="text-slate-600">Learn from coffee experts</p>
        </div>
        <a href="{{ route('customer.blog') }}" class="text-coffee-700 font-semibold hover:text-coffee-800 flex items-center gap-2">
            Read Blog <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    
    <div class="grid md:grid-cols-2 gap-6">
        <div class="card overflow-hidden group cursor-pointer">
            <div class="flex h-48">
                <div class="w-1/3 overflow-hidden">
                    <img src="{{ asset('images/blog1.jpg') }}" alt="Blog" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="w-2/3 p-6 flex flex-col justify-center">
                    <p class="text-xs font-semibold text-slate-500 uppercase mb-2">Tips & Tricks</p>
                    <h3 class="font-bold text-slate-900 mb-3 group-hover:text-coffee-700">Perfect V60 Guide</h3>
                    <p class="text-sm text-slate-600 hidden md:block mb-4">The ultimate guide to brewing clear coffee manually.</p>
                    <a href="#" class="text-coffee-700 font-semibold text-sm hover:text-coffee-800">Read Article →</a>
                </div>
            </div>
        </div>
        
        <div class="card overflow-hidden group cursor-pointer">
            <div class="flex h-48">
                <div class="w-1/3 overflow-hidden">
                    <img src="{{ asset('images/blog1.jpg') }}" alt="Blog" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300 filter hue-rotate-45">
                </div>
                <div class="w-2/3 p-6 flex flex-col justify-center">
                    <p class="text-xs font-semibold text-slate-500 uppercase mb-2">Knowledge</p>
                    <h3 class="font-bold text-slate-900 mb-3 group-hover:text-coffee-700">Arabica vs Robusta</h3>
                    <p class="text-sm text-slate-600 hidden md:block mb-4">Understanding the difference in taste and caffeine.</p>
                    <a href="#" class="text-coffee-700 font-semibold text-sm hover:text-coffee-800">Read Article →</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
