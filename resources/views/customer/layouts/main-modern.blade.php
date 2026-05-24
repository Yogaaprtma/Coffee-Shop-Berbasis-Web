<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beanie - @yield('title', 'Coffee Shop')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-poppins bg-slate-50 text-slate-900">

    <!-- Desktop Navigation -->
    <header class="sticky top-0 z-40 hidden md:block bg-white border-b border-slate-100 shadow-sm">
        <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home.customer') }}" class="flex items-center gap-2 text-2xl font-bold">
                <i class="fas fa-mug-hot text-coffee-700"></i>
                <span class="gradient-text">Beanie</span>
            </a>
            
            <ul class="flex gap-8">
                <li><a href="{{ route('home.customer') }}" class="nav-link {{ Route::is('home.customer') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('customer.order') }}" class="nav-link {{ Route::is('customer.order') ? 'active' : '' }}">Shop</a></li>
                <li><a href="{{ route('customer.blog') }}" class="nav-link {{ Route::is('customer.blog') ? 'active' : '' }}">Blog</a></li>
            </ul>
            
            <div class="flex items-center gap-6">
                <!-- Cart Icon -->
                <a href="{{ route('customer.cart') }}" class="relative text-slate-700 hover:text-coffee-700 transition">
                    <i class="fas fa-shopping-bag text-xl"></i>
                    @if(session('cart') && count(session('cart')) > 0)
                    <span class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                        {{ count(session('cart')) }}
                    </span>
                    @endif
                </a>
                
                <!-- User Dropdown -->
                <div class="relative group">
                    <button class="flex items-center gap-2 text-slate-700 hover:text-coffee-700 transition">
                        <div class="w-8 h-8 rounded-full bg-coffee-100 flex items-center justify-center">
                            <i class="fas fa-user text-coffee-700"></i>
                        </div>
                        <span class="text-sm font-semibold hidden lg:inline">{{ Auth::user()->nama ?? 'User' }}</span>
                        <i class="fas fa-chevron-down text-xs ml-1"></i>
                    </button>
                    
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-2">
                        <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-coffee-50 hover:text-coffee-700"><i class="fas fa-user-circle mr-2"></i> Profile</a>
                        <a href="{{ route('customer.history') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-coffee-50 hover:text-coffee-700"><i class="fas fa-receipt mr-2"></i> Orders</a>
                        <hr class="my-2">
                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="hidden md:block bg-white border-t border-slate-100 mt-16 py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold mb-4 gradient-text">Beanie.</h3>
                    <p class="text-sm text-slate-600">The best coffee experience delivered to your door. Freshly roasted, premium beans.</p>
                </div>
                <div>
                    <h6 class="font-semibold mb-4 text-slate-900">Shop</h6>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><a href="#" class="hover:text-coffee-700 transition">Coffee</a></li>
                        <li><a href="#" class="hover:text-coffee-700 transition">Equipment</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="font-semibold mb-4 text-slate-900">Company</h6>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><a href="#" class="hover:text-coffee-700 transition">About Us</a></li>
                        <li><a href="#" class="hover:text-coffee-700 transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="font-semibold mb-4 text-slate-900">Newsletter</h6>
                    <div class="flex gap-2">
                        <input type="email" placeholder="Your email" class="input-field text-sm flex-1">
                        <button class="btn-coffee text-sm px-4 py-2">Subscribe</button>
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-100 pt-6 text-center text-sm text-slate-600">
                &copy; {{ date('Y') }} Beanie Coffee. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Mobile Bottom Navigation -->
    <nav class="fixed bottom-0 left-0 right-0 md:hidden bg-white border-t border-slate-100 rounded-t-3xl shadow-lg z-50" style="padding-bottom: env(safe-area-inset-bottom);">
        <div class="flex justify-around items-end h-20">
            <a href="{{ route('home.customer') }}" class="bottom-nav-item {{ Route::is('home.customer') ? 'active' : '' }}">
                <i class="fas fa-home text-2xl"></i>
                <span>Home</span>
            </a>
            <a href="{{ route('customer.order') }}" class="bottom-nav-item {{ Route::is('customer.order') ? 'active' : '' }}">
                <i class="fas fa-mug-hot text-2xl"></i>
                <span>Menu</span>
            </a>
            <a href="{{ route('customer.cart') }}" class="bottom-nav-item {{ Route::is('customer.cart') ? 'active' : '' }} relative">
                <i class="fas fa-shopping-bag text-2xl"></i>
                @if(session('cart') && count(session('cart')) > 0)
                <span class="absolute -top-2 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">{{ count(session('cart')) }}</span>
                @endif
                <span>Cart</span>
            </a>
            <a href="{{ route('customer.history') }}" class="bottom-nav-item {{ Route::is('customer.history') || Route::is('customer.order.detail') ? 'active' : '' }}">
                <i class="fas fa-receipt text-2xl"></i>
                <span>Orders</span>
            </a>
            <a href="{{ route('customer.profile') }}" class="bottom-nav-item {{ Route::is('customer.profile') ? 'active' : '' }}">
                <i class="fas fa-user text-2xl"></i>
                <span>Profile</span>
            </a>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
