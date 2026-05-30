@extends('customer.layouts.main-modern')

@section('title', 'Our Menu')

@section('content')

<div class="container mx-auto px-4 py-12">
    <!-- Page Header -->
    <div class="mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">Our Premium Selection</h1>
        <p class="text-lg text-slate-600 max-w-2xl">Discover our handpicked collection of premium coffee beans from around the world, roasted fresh and ready to be enjoyed.</p>
    </div>

    <div class="grid lg:grid-cols-4 gap-8">
        <!-- Sidebar Filters -->
        <div class="lg:col-span-1">
            <div class="sticky top-20 space-y-6">
                <!-- Categories Filter -->
                <div class="card p-6">
                    <h3 class="font-bold text-lg mb-4 text-slate-900">Categories</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-5 h-5 rounded border-slate-300 text-coffee-700 cursor-pointer">
                            <span class="text-slate-700 group-hover:text-coffee-700 transition">All Products</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-5 h-5 rounded border-slate-300 text-coffee-700 cursor-pointer">
                            <span class="text-slate-700 group-hover:text-coffee-700 transition">Espresso</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-5 h-5 rounded border-slate-300 text-coffee-700 cursor-pointer">
                            <span class="text-slate-700 group-hover:text-coffee-700 transition">Filter Coffee</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-5 h-5 rounded border-slate-300 text-coffee-700 cursor-pointer">
                            <span class="text-slate-700 group-hover:text-coffee-700 transition">Specialty Blends</span>
                        </label>
                    </div>
                </div>

                <!-- Price Range Filter -->
                <div class="card p-6">
                    <h3 class="font-bold text-lg mb-4 text-slate-900">Price Range</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="price" class="w-4 h-4">
                            <span class="text-slate-700 group-hover:text-coffee-700">All Prices</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="price" class="w-4 h-4">
                            <span class="text-slate-700 group-hover:text-coffee-700">Under 50k</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="price" class="w-4 h-4">
                            <span class="text-slate-700 group-hover:text-coffee-700">50k - 100k</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="price" class="w-4 h-4">
                            <span class="text-slate-700 group-hover:text-coffee-700">Above 100k</span>
                        </label>
                    </div>
                </div>

                <!-- Rating Filter -->
                <div class="card p-6">
                    <h3 class="font-bold text-lg mb-4 text-slate-900">Rating</h3>
                    <div class="space-y-3">
                        @for ($i = 5; $i >= 4; $i--)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" class="w-5 h-5 rounded">
                            <div class="flex items-center gap-1">
                                @for ($j = 1; $j <= $i; $j++)
                                <i class="fas fa-star text-yellow-400 text-sm"></i>
                                @endfor
                                <span class="text-slate-600 text-sm ml-2">& up</span>
                            </div>
                        </label>
                        @endfor
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="card p-6">
                    <h3 class="font-bold text-lg mb-4 text-slate-900">Sort By</h3>
                    <select class="input-field">
                        <option>Newest</option>
                        <option>Best Selling</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Rating</option>
                    </select>
                </div>

                <!-- Clear Filters -->
                <button class="w-full px-4 py-3 border-2 border-slate-200 text-slate-700 rounded-lg font-semibold hover:border-coffee-700 hover:text-coffee-700 transition">
                    Clear All Filters
                </button>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="lg:col-span-3">
            <!-- Search Bar -->
            <div class="mb-8">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" placeholder="Search for coffee..." class="input-field pl-12">
                </div>
            </div>

            <!-- Results Count -->
            <div class="mb-6">
                <p class="text-slate-600">Showing <span class="font-semibold text-slate-900">12</span> products</p>
            </div>

            <!-- Products Grid -->
            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($products ?? [] as $product)
                <div class="card-product overflow-hidden group">
                    <!-- Image -->
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <a href="{{ route('customer.product.detail', $product->id) }}" class="block w-full h-full">
                            <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </a>
                        
                        <!-- Wishlist Button -->
                        <form action="{{ route('customer.wishlist.toggle') }}" method="POST" class="absolute top-3 right-3 z-10">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center transition-colors transform hover:scale-110 active:scale-95 {{ Auth::check() && Auth::user()->wishlistProducts->contains($product->id) ? 'text-red-500' : 'text-slate-400 hover:text-red-500' }}" title="Add to wishlist">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                        
                        <!-- Badge -->
                        @if($product->reviews_avg_rating)
                        <div class="absolute top-3 left-3 badge-coffee">
                            <i class="fas fa-star text-xs mr-1"></i> {{ number_format($product->reviews_avg_rating, 1) }}
                        </div>
                        @endif
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-4">
                        <p class="text-xs font-semibold text-slate-500 uppercase mb-1">{{ $product->category->nama ?? 'Coffee' }}</p>
                        <h3 class="font-bold text-slate-900 truncate mb-2 group-hover:text-coffee-700">
                            <a href="{{ route('customer.product.detail', $product->id) }}">{{ $product->nama }}</a>
                        </h3>
                        
                        <!-- Rating -->
                        <div class="flex items-center gap-2 mb-3">
                            <div class="flex gap-0.5 text-yellow-400">
                                @php $ratingVal = $product->reviews_avg_rating ?: 0; @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($ratingVal))
                                        <i class="fas fa-star text-xs"></i>
                                    @else
                                        <i class="far fa-star text-xs text-slate-300"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-slate-500">({{ $product->reviews_count }} reviews)</span>
                        </div>
                        
                        <!-- Price & Button -->
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-lg font-bold text-coffee-700">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('customer.product.detail', $product->id) }}" class="w-9 h-9 rounded-full bg-coffee-700 text-white hover:bg-coffee-800 transition-all flex items-center justify-center shadow-md transform hover:scale-110 active:scale-95">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="md:col-span-2 xl:col-span-3 text-center py-12">
                    <i class="fas fa-coffee text-6xl text-slate-300 mb-4"></i>
                    <p class="text-slate-600">No products found</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="flex justify-center gap-2 mt-12">
                <button class="w-10 h-10 rounded-lg border border-slate-200 hover:border-coffee-700 text-slate-600 hover:text-coffee-700 transition flex items-center justify-center">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="w-10 h-10 rounded-lg bg-coffee-700 text-white flex items-center justify-center">1</button>
                <button class="w-10 h-10 rounded-lg border border-slate-200 hover:border-coffee-700 text-slate-600 hover:text-coffee-700 transition flex items-center justify-center">2</button>
                <button class="w-10 h-10 rounded-lg border border-slate-200 hover:border-coffee-700 text-slate-600 hover:text-coffee-700 transition flex items-center justify-center">3</button>
                <button class="w-10 h-10 rounded-lg border border-slate-200 hover:border-coffee-700 text-slate-600 hover:text-coffee-700 transition flex items-center justify-center">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
