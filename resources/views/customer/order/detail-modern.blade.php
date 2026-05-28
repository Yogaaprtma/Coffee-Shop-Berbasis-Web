@extends('customer.layouts.main-modern')

@section('title', $product->nama)

@section('content')
<div class="container mx-auto px-4 py-12" x-data="{
    basePrice: {{ $product->harga }},
    size: 'S',
    extras: [],
    get totalPrice() {
        let price = this.basePrice;
        if (this.size === 'M') price += 5000;
        if (this.size === 'L') price += 10000;
        if (this.extras.includes('extra_espresso')) price += 5000;
        if (this.extras.includes('caramel_syrup')) price += 3000;
        return price;
    },
    formatPrice(val) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
    }
}">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm text-slate-500" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home.customer') }}" class="hover:text-coffee-700">Home</a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                    <a href="{{ route('customer.order') }}" class="hover:text-coffee-700">Shop</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                    <span class="text-slate-400">{{ $product->nama }}</span>
                </div>
            </li>
        </ol>
    </nav>

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

    <div class="grid md:grid-cols-2 gap-12 mb-16">
        <!-- Product Image & Gallery -->
        <div>
            <div class="relative rounded-2xl overflow-hidden bg-slate-100 shadow-sm border border-slate-200/50 aspect-square">
                <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover">
                
                <!-- Wishlist Toggle -->
                <form action="{{ route('customer.wishlist.toggle') }}" method="POST" class="absolute top-4 right-4 z-10">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="w-12 h-12 rounded-full bg-white shadow-lg flex items-center justify-center transition transform hover:scale-110 active:scale-95 {{ $isWishlisted ? 'text-red-500' : 'text-slate-400 hover:text-red-500' }}">
                        <i class="fas fa-heart text-xl"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Product Ordering Details -->
        <div class="flex flex-col justify-between">
            <div>
                <span class="px-3 py-1 bg-coffee-100 text-coffee-700 text-xs font-semibold rounded-full uppercase tracking-wider mb-4 inline-block">
                    {{ $product->category->nama ?? 'Coffee' }}
                </span>
                
                <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4 leading-tight">{{ $product->nama }}</h1>
                
                <!-- Rating Summary -->
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center text-yellow-400 gap-1">
                        @php $fullStars = floor($avgRating); @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $fullStars)
                                <i class="fas fa-star text-sm"></i>
                            @else
                                <i class="far fa-star text-sm"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-slate-700 font-semibold text-sm">{{ number_format($avgRating, 1) }}</span>
                    <span class="text-slate-400">|</span>
                    <a href="#reviews-section" class="text-coffee-700 hover:underline text-sm font-semibold">{{ $totalReviews }} reviews</a>
                </div>

                <div class="mb-6 pb-6 border-b border-slate-200">
                    <span class="text-3xl font-extrabold text-coffee-700" x-text="formatPrice(totalPrice)">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                </div>

                <p class="text-slate-600 mb-8 leading-relaxed">{{ $product->deskripsi }}</p>

                <!-- Order Customization Form -->
                <form action="{{ route('customer.addToCart') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <!-- Cup Size -->
                    <div>
                        <span class="text-sm font-bold text-slate-900 block mb-3">Cup Size</span>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="flex flex-col items-center justify-center p-3 border rounded-xl cursor-pointer hover:bg-slate-50 transition" :class="size === 'S' ? 'border-coffee-700 bg-coffee-50/50 text-coffee-700 font-semibold' : 'border-slate-200'">
                                <input type="radio" name="size" value="S" class="sr-only" x-model="size" checked>
                                <span class="text-base">S</span>
                                <span class="text-xs text-slate-500">Regular</span>
                            </label>
                            <label class="flex flex-col items-center justify-center p-3 border rounded-xl cursor-pointer hover:bg-slate-50 transition" :class="size === 'M' ? 'border-coffee-700 bg-coffee-50/50 text-coffee-700 font-semibold' : 'border-slate-200'">
                                <input type="radio" name="size" value="M" class="sr-only" x-model="size">
                                <span class="text-base">M</span>
                                <span class="text-xs text-slate-500">+Rp 5k</span>
                            </label>
                            <label class="flex flex-col items-center justify-center p-3 border rounded-xl cursor-pointer hover:bg-slate-50 transition" :class="size === 'L' ? 'border-coffee-700 bg-coffee-50/50 text-coffee-700 font-semibold' : 'border-slate-200'">
                                <input type="radio" name="size" value="L" class="sr-only" x-model="size">
                                <span class="text-base">L</span>
                                <span class="text-xs text-slate-500">+Rp 10k</span>
                            </label>
                        </div>
                    </div>

                    <!-- Ice/Hot & Sugar Level in a Row -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Temperature -->
                        <div>
                            <label class="text-sm font-bold text-slate-900 block mb-2">Temperature</label>
                            <select name="temperature" class="input-field text-sm">
                                <option value="hot">Hot</option>
                                <option value="iced">Iced</option>
                            </select>
                        </div>

                        <!-- Sugar Level -->
                        <div>
                            <label class="text-sm font-bold text-slate-900 block mb-2">Sugar Level</label>
                            <select name="sugar" class="input-field text-sm">
                                <option value="normal">Normal Sugar</option>
                                <option value="less_sugar">Less Sugar</option>
                                <option value="no_sugar">No Sugar</option>
                            </select>
                        </div>
                    </div>

                    <!-- Extras -->
                    <div>
                        <span class="text-sm font-bold text-slate-900 block mb-3">Extras</span>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center justify-between p-3 border rounded-xl cursor-pointer hover:bg-slate-50 transition" :class="extras.includes('extra_espresso') ? 'border-coffee-700 bg-coffee-50/50 text-coffee-700 font-semibold' : 'border-slate-200'">
                                <span class="text-sm flex items-center gap-2">
                                    <input type="checkbox" name="extras[]" value="extra_espresso" class="sr-only" x-model="extras">
                                    Extra Espresso
                                </span>
                                <span class="text-xs text-slate-500">+5k</span>
                            </label>
                            <label class="flex items-center justify-between p-3 border rounded-xl cursor-pointer hover:bg-slate-50 transition" :class="extras.includes('caramel_syrup') ? 'border-coffee-700 bg-coffee-50/50 text-coffee-700 font-semibold' : 'border-slate-200'">
                                <span class="text-sm flex items-center gap-2">
                                    <input type="checkbox" name="extras[]" value="caramel_syrup" class="sr-only" x-model="extras">
                                    Caramel Syrup
                                </span>
                                <span class="text-xs text-slate-500">+3k</span>
                            </label>
                        </div>
                    </div>

                    <!-- Quantity & Submit -->
                    <div class="flex gap-4 pt-4 border-t border-slate-100">
                        <div class="w-32">
                            <label class="text-xs font-bold text-slate-400 block mb-2 uppercase">Quantity</label>
                            <input type="number" name="jumlah" value="1" min="1" class="input-field text-center font-bold">
                        </div>
                        <div class="flex-grow flex items-end">
                            <button type="submit" class="w-full btn-coffee py-4 text-base font-semibold flex items-center justify-center gap-3 shadow-lg">
                                <i class="fas fa-shopping-bag"></i> Add to Keranjang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
    <div class="mb-16">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">You May Also Like</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
            <div class="card-product overflow-hidden group">
                <div class="relative h-40 bg-slate-100 overflow-hidden">
                    <img src="{{ asset($related->gambar) }}" alt="{{ $related->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                    <div class="absolute top-2 left-2 bg-coffee-800/80 backdrop-blur-md text-white px-2 py-0.5 rounded text-[10px] font-semibold">
                        {{ $related->category->nama ?? 'Coffee' }}
                    </div>
                </div>
                <div class="p-3">
                    <h4 class="font-bold text-slate-900 truncate text-sm mb-1">
                        <a href="{{ route('customer.product.detail', $related->id) }}" class="hover:text-coffee-700">{{ $related->nama }}</a>
                    </h4>
                    <span class="text-sm font-bold text-coffee-700">Rp {{ number_format($related->harga, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Reviews Section -->
    <div id="reviews-section" class="border-t border-slate-200 pt-12">
        <div class="grid md:grid-cols-3 gap-12">
            <!-- Review Summary -->
            <div class="md:col-span-1">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Customer Reviews</h2>
                
                <div class="card p-6 bg-slate-50 border border-slate-200/60 shadow-sm mb-6 flex flex-col items-center">
                    <span class="text-5xl font-black text-slate-900 mb-2">{{ number_format($avgRating, 1) }}</span>
                    <div class="flex text-yellow-400 gap-1 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $fullStars)
                                <i class="fas fa-star text-base"></i>
                            @else
                                <i class="far fa-star text-base"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-slate-500">Based on {{ $totalReviews }} reviews</span>
                </div>

                <!-- Add Review Form (Only for logged-in users) -->
                @auth
                <div class="card p-6 bg-white border border-slate-200/60 shadow-sm">
                    <h4 class="font-bold text-slate-900 mb-4">Write a Review</h4>
                    <form action="{{ route('customer.product.review.store', $product->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="text-sm font-bold text-slate-900 block mb-2">Rating</label>
                            <div class="flex text-yellow-400 text-2xl gap-2 cursor-pointer" x-data="{ selected: 5 }">
                                <input type="hidden" name="rating" :value="selected">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fa-star cursor-pointer transition-colors duration-150" 
                                   :class="selected >= {{ $i }} ? 'fas text-yellow-400' : 'far text-slate-300'"
                                   @click="selected = {{ $i }}"></i>
                                @endfor
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-bold text-slate-900 block mb-2">Your Review</label>
                            <textarea name="comment" rows="4" placeholder="Share your thoughts about this coffee..." class="input-field text-sm" required></textarea>
                        </div>
                        <button type="submit" class="w-full btn-coffee py-2.5 text-sm font-semibold">
                            Submit Review
                        </button>
                    </form>
                </div>
                @else
                <div class="p-6 bg-slate-100 rounded-xl text-center">
                    <p class="text-slate-600 text-sm mb-3">Please login to write a review.</p>
                    <a href="{{ route('login.page') }}" class="btn-coffee py-2 px-4 text-xs font-semibold inline-block">Login</a>
                </div>
                @endauth
            </div>

            <!-- Reviews List -->
            <div class="md:col-span-2">
                <h3 class="text-xl font-bold text-slate-900 mb-6">Review Highlights</h3>

                @if($reviews->isEmpty())
                <div class="card p-12 text-center text-slate-500">
                    <i class="far fa-comments text-5xl mb-4 text-slate-300 block"></i>
                    <p class="font-semibold text-lg mb-1">No reviews yet</p>
                    <p class="text-sm text-slate-400">Be the first to review this delicious coffee!</p>
                </div>
                @else
                <div class="space-y-6">
                    @foreach($reviews as $review)
                    <div class="p-6 bg-white border border-slate-200/50 rounded-2xl shadow-sm space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="font-bold text-slate-900 text-base">{{ $review->user->nama ?? 'Anonymous' }}</span>
                                <div class="flex text-yellow-400 gap-0.5 text-xs mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <span class="text-xs text-slate-400 font-medium">{{ $review->created_at->format('d M Y') }}</span>
                        </div>

                        <p class="text-slate-700 text-sm leading-relaxed">{{ $review->comment }}</p>

                        <div class="flex items-center gap-4 pt-2 border-t border-slate-100">
                            @if($review->verified_purchase)
                            <span class="inline-flex items-center gap-1 text-green-600 text-xs font-semibold bg-green-50 px-2.5 py-1 rounded-full">
                                <i class="fas fa-check-circle text-[10px]"></i> Verified Purchase
                            </span>
                            @endif

                            <!-- Helpfulness (simple mock action) -->
                            <button class="flex items-center gap-1.5 text-slate-400 hover:text-coffee-700 transition text-xs font-medium">
                                <i class="far fa-thumbs-up"></i> Helpful ({{ $review->helpful_count }})
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
