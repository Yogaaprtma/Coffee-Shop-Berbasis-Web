@extends('customer.layouts.main-modern')

@section('title', 'My Wishlist')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Page Header -->
    <div class="mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">My Wishlist</h1>
        <p class="text-lg text-slate-600 max-w-2xl">Your favorite coffee selections, saved here for quick ordering.</p>
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

    @if($wishlistItems->isEmpty())
    <div class="card p-12 text-center max-w-lg mx-auto">
        <div class="w-20 h-20 bg-coffee-50 text-coffee-700 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
            <i class="fas fa-heart-broken"></i>
        </div>
        <h2 class="text-2xl font-bold text-slate-900 mb-2">Wishlist is Empty</h2>
        <p class="text-slate-600 mb-8">You haven't saved any items to your wishlist yet. Explore our premium coffee collection and save your favorites!</p>
        <a href="{{ route('customer.order') }}" class="btn-coffee px-6 py-3 inline-block">
            Explore Menu
        </a>
    </div>
    @else
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($wishlistItems as $item)
        @php $product = $item->product; @endphp
        @if($product)
        <div class="card-product overflow-hidden group">
            <!-- Image -->
            <div class="relative h-48 overflow-hidden bg-slate-100">
                <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                
                <!-- Remove Wishlist Button -->
                <form action="{{ route('customer.wishlist.toggle') }}" method="POST" class="absolute top-3 right-3 z-10">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center text-red-500 hover:text-slate-400 transition-colors transform hover:scale-110 active:scale-95 animate-pulse-subtle" title="Remove from wishlist">
                        <i class="fas fa-heart text-lg"></i>
                    </button>
                </form>
                
                <!-- Category Badge -->
                <div class="absolute top-3 left-3 bg-coffee-800/80 backdrop-blur-md text-white px-3 py-1 rounded-full text-xs font-semibold">
                    {{ $product->category->nama ?? 'Coffee' }}
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="p-4 flex flex-col justify-between flex-grow">
                <div>
                    <h3 class="font-bold text-slate-900 truncate mb-2 group-hover:text-coffee-700 text-lg">
                        <a href="{{ route('customer.product.detail', $product->id) }}">{{ $product->nama }}</a>
                    </h3>
                    <p class="text-sm text-slate-500 line-clamp-2 mb-4">{{ $product->deskripsi }}</p>
                </div>
                
                <!-- Price & Add to Cart -->
                <div class="flex justify-between items-center mt-auto">
                    <span class="text-lg font-bold text-coffee-700">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    
                    <form action="{{ route('customer.addToCart') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="jumlah" value="1">
                        <button type="submit" class="btn-coffee py-2 px-4 text-sm flex items-center gap-2">
                            <i class="fas fa-shopping-bag text-xs"></i> Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    @endif
</div>
@endsection
