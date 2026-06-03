# 🎨 Reusable Component Snippets

Use these snippets to build additional pages with the modern design system.

---

## 1️⃣ Product Card (Compact)

```blade
<div class="card-product overflow-hidden group">
    <div class="relative h-48 overflow-hidden bg-slate-100">
        <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" 
             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
        
        <button class="absolute top-3 right-3 w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center text-slate-400 hover:text-red-500 transition">
            <i class="fas fa-heart"></i>
        </button>
        
        <div class="absolute top-3 left-3 badge-coffee">
            <i class="fas fa-star text-xs mr-1"></i> 4.8
        </div>
    </div>
    
    <div class="p-4">
        <p class="text-xs font-semibold text-slate-500 uppercase mb-1">{{ $product->category->nama }}</p>
        <h3 class="font-bold text-slate-900 truncate mb-3">{{ $product->nama }}</h3>
        
        <div class="flex justify-between items-center">
            <span class="text-lg font-bold text-coffee-700">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
            <form action="{{ route('customer.addToCart') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="w-8 h-8 rounded-full bg-coffee-700 text-white hover:bg-coffee-800 transition flex items-center justify-center shadow-md transform hover:scale-110">
                    <i class="fas fa-plus text-xs"></i>
                </button>
            </form>
        </div>
    </div>
</div>
```

---

## 2️⃣ Alert/Notification

```blade
<!-- Success -->
@if(session('success'))
<div class="fixed top-20 right-4 bg-green-50 border border-green-200 rounded-lg p-4 shadow-lg max-w-sm animate-fade-in">
    <div class="flex gap-3">
        <i class="fas fa-check-circle text-green-600 text-xl flex-shrink-0 mt-1"></i>
        <div>
            <h4 class="font-bold text-green-900">Success!</h4>
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
        <button class="text-green-400 hover:text-green-600 ml-auto">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endif

<!-- Error -->
@if($errors->any())
<div class="fixed top-20 right-4 bg-red-50 border border-red-200 rounded-lg p-4 shadow-lg max-w-sm animate-fade-in">
    <div class="flex gap-3">
        <i class="fas fa-exclamation-circle text-red-600 text-xl flex-shrink-0 mt-1"></i>
        <div>
            <h4 class="font-bold text-red-900">Error!</h4>
            <ul class="text-sm text-red-700">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif
```

---

## 3️⃣ Input Field with Label

```blade
<div class="space-y-2">
    <label for="email" class="block text-sm font-semibold text-slate-900">Email Address</label>
    <input type="email" id="email" name="email" placeholder="you@example.com"
           class="input-field @error('email') input-field-error @enderror">
    @error('email')
    <p class="text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
    @enderror
</div>
```

---

## 4️⃣ Empty State

```blade
<div class="card p-12 text-center">
    <i class="fas fa-shopping-bag text-6xl text-slate-300 mb-4"></i>
    <h3 class="text-2xl font-bold text-slate-900 mb-2">No items found</h3>
    <p class="text-slate-600 mb-8">Try adjusting your filters or search terms.</p>
    <a href="{{ route('customer.order') }}" class="btn-coffee">Continue Shopping</a>
</div>
```

---

## 5️⃣ Filter Section

```blade
<div class="card p-6 space-y-4">
    <h3 class="font-bold text-lg text-slate-900">{{ $title }}</h3>
    
    <div class="space-y-3">
        <label class="flex items-center gap-3 cursor-pointer group">
            <input type="checkbox" class="w-5 h-5 rounded border-slate-300 text-coffee-700">
            <span class="text-slate-700 group-hover:text-coffee-700 transition">{{ $option }}</span>
        </label>
    </div>
</div>
```

---

## 6️⃣ Badge Variations

```blade
<!-- Coffee Badge -->
<span class="badge-coffee">
    <i class="fas fa-star text-xs mr-1"></i> Premium
</span>

<!-- Sale Badge -->
<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-700">
    -25% Sale
</span>

<!-- Status Badge -->
<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700">
    <i class="fas fa-check-circle mr-1"></i> Delivered
</span>

<!-- Stock Badge -->
<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-700">
    Low Stock
</span>
```

---

## 7️⃣ Button Variations

```blade
<!-- Primary Button -->
<button class="btn-coffee">
    <i class="fas fa-shopping-bag mr-2"></i>
    Add to Cart
</button>

<!-- Outline Button -->
<button class="btn-coffee-outline">
    <i class="fas fa-heart mr-2"></i>
    Save for Later
</button>

<!-- Ghost Button (Secondary) -->
<button class="btn-ghost">
    Cancel
</button>

<!-- Disabled Button -->
<button class="btn-coffee opacity-50 cursor-not-allowed" disabled>
    Out of Stock
</button>

<!-- Full Width Button -->
<button class="w-full btn-coffee">
    Proceed to Checkout
</button>
```

---

## 8️⃣ Rating Display

```blade
<div class="flex items-center gap-2">
    <div class="flex gap-0.5">
        @for ($i = 0; $i < 5; $i++)
        @if ($i < $product->average_rating)
        <i class="fas fa-star text-yellow-400 text-sm"></i>
        @else
        <i class="fas fa-star text-slate-300 text-sm"></i>
        @endif
        @endfor
    </div>
    <span class="text-sm text-slate-600">({{ $product->review_count }} reviews)</span>
    <span class="text-sm font-semibold text-slate-900">{{ $product->average_rating }}/5</span>
</div>
```

---

## 9️⃣ Price Display with Discount

```blade
<div class="flex items-baseline gap-2">
    <span class="text-2xl font-bold text-coffee-700">Rp {{ number_format($product->discounted_price, 0, ',', '.') }}</span>
    <span class="text-lg text-slate-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
    <span class="text-sm font-bold text-red-600">Save Rp {{ number_format($product->original_price - $product->discounted_price, 0, ',', '.') }}</span>
</div>
```

---

## 🔟 Category Grid

```blade
<div class="grid md:grid-cols-4 gap-6">
    @foreach($categories as $category)
    <div class="group cursor-pointer relative h-48 rounded-2xl overflow-hidden shadow-card hover:shadow-hover transition-all transform hover:-translate-y-2">
        <img src="{{ asset('storage/' . $category->gambar) }}" alt="{{ $category->nama }}" 
             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
        
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
```

---

## 1️⃣1️⃣ Statistics Card

```blade
<div class="card p-6">
    <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-slate-600 uppercase">Total Orders</span>
        <i class="fas fa-shopping-bag text-2xl text-coffee-700 opacity-20"></i>
    </div>
    <h3 class="text-3xl font-bold text-slate-900 mb-1">{{ $totalOrders }}</h3>
    <p class="text-sm text-green-600"><i class="fas fa-arrow-up mr-1"></i> +12% from last month</p>
</div>
```

---

## 1️⃣2️⃣ Form Group

```blade
<div class="space-y-6">
    <div>
        <label for="fullname" class="block text-sm font-semibold text-slate-900 mb-2">Full Name</label>
        <input type="text" id="fullname" name="fullname" placeholder="John Doe" class="input-field">
    </div>
    
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-900 mb-2">Email</label>
            <input type="email" id="email" name="email" placeholder="john@example.com" class="input-field">
        </div>
        <div>
            <label for="phone" class="block text-sm font-semibold text-slate-900 mb-2">Phone</label>
            <input type="tel" id="phone" name="phone" placeholder="+62 812..." class="input-field">
        </div>
    </div>
    
    <div>
        <label for="message" class="block text-sm font-semibold text-slate-900 mb-2">Message</label>
        <textarea id="message" name="message" rows="4" placeholder="Your message..." class="input-field"></textarea>
    </div>
    
    <button type="submit" class="w-full btn-coffee">Submit</button>
</div>
```

---

## 💡 Tips & Tricks

### Add Loading State
```blade
<button class="btn-coffee" id="submit-btn" onclick="this.classList.add('opacity-50'); this.disabled = true;">
    <i class="fas fa-spinner animate-spin"></i> Loading...
</button>
```

### Combine Components
```blade
<div class="card p-6 space-y-4">
    <!-- Form -->
    <input type="text" placeholder="Search..." class="input-field">
    
    <!-- Buttons Row -->
    <div class="flex gap-3">
        <button class="flex-1 btn-coffee">Search</button>
        <button class="flex-1 btn-ghost">Reset</button>
    </div>
</div>
```

### Responsive Classes
```blade
<!-- Hidden on mobile, shown on desktop -->
<div class="hidden md:block">Desktop Only Content</div>

<!-- Full width on mobile, 2 columns on desktop -->
<div class="grid md:grid-cols-2 gap-4">
    <div>Column 1</div>
    <div>Column 2</div>
</div>

<!-- Adjust padding on mobile vs desktop -->
<div class="px-4 md:px-8">Content</div>
```

---

**All snippets use Tailwind CSS classes and follow the design system!** ✨

Last updated: May 24, 2026
