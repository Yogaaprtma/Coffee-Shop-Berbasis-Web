<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beanie - @yield('title', 'Coffee Shop')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #6F4E37; /* Coffee Brown */
            --secondary-color: #A67B5B; /* Latte */
            --accent-color: #ECB176;
            --bg-light: #F9F5F0;
            --text-dark: #2C2C2C;
            --radius: 12px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            padding-bottom: 80px; /* Space for mobile nav */
        }

        /* Desktop Navbar */
        .navbar-custom {
            background-color: #fff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            padding: 15px 0;
        }
        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            transition: 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
        }

        /* Mobile Bottom Nav */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.1);
            z-index: 1000;
            display: flex;
            justify-content: space-around;
            padding: 12px 0;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .nav-item-mobile {
            text-align: center;
            color: #999;
            text-decoration: none;
            font-size: 0.75rem;
            flex: 1;
        }

        .nav-item-mobile i {
            display: block;
            font-size: 1.4rem;
            margin-bottom: 4px;
            transition: 0.3s;
        }

        .nav-item-mobile.active {
            color: var(--primary-color);
            font-weight: 600;
        }
        .nav-item-mobile.active i {
            transform: translateY(-3px);
        }

        /* Footer */
        footer {
            background-color: #fff;
            margin-top: 3rem;
        }

        /* Utilities */
        .text-primary-custom { color: var(--primary-color); }
        .bg-primary-custom { background-color: var(--primary-color); }
        .btn-coffee {
            background-color: var(--primary-color);
            color: white;
            border-radius: 50px;
            padding: 8px 24px;
            transition: 0.3s;
        }
        .btn-coffee:hover {
            background-color: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
        }

        @media (min-width: 768px) {
            .mobile-bottom-nav { display: none; }
            body { padding-bottom: 0; }
        }
        @media (max-width: 767px) {
            .desktop-nav { display: none; }
        }
    </style>
</head>
<body>

    <header class="desktop-nav sticky-top">
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand fw-bold fs-4" href="{{ route('home.customer') }}">
                    <i class="fas fa-mug-hot text-primary-custom me-2"></i>Beanie.
                </a>
                
                <div class="d-flex align-items-center gap-3">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex flex-row gap-4">
                        <li class="nav-item"><a class="nav-link active" href="{{ route('home.customer') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('customer.order') }}">Shop</a></li>
                        <li class="nav-item"><a class="nav-link" href="#blog">Blog</a></li>
                    </ul>
                    
                    <div class="border-start ps-3 d-flex align-items-center gap-3">
                        <a href="{{ route('customer.cart') }}" class="position-relative text-dark">
                            <i class="fas fa-shopping-bag fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                0
                            </span>
                        </a>
                        <a href="{{ route('logout') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    @yield('content')

    <footer class="py-5 d-none d-md-block">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4 class="fw-bold">Beanie.</h4>
                    <p class="text-muted small">The best coffee experience delivered to your door. Freshly roasted, premium beans.</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="fw-bold">Shop</h6>
                    <ul class="list-unstyled small text-muted">
                        <li><a href="#" class="text-decoration-none text-muted">Coffee</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Equipment</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="fw-bold">Company</h6>
                    <ul class="list-unstyled small text-muted">
                        <li><a href="#" class="text-decoration-none text-muted">About Us</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold">Newsletter</h6>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Your email">
                        <button class="btn btn-coffee" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4 pt-3 border-top small text-muted">
                &copy; {{ date('Y') }} Beanie Coffee. All rights reserved.
            </div>
        </div>
    </footer>

    <div class="mobile-bottom-nav">
        <a href="{{ route('home.customer') }}" class="nav-item-mobile {{ Route::is('home.customer') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            Home
        </a>
        <a href="{{ route('customer.order') }}" class="nav-item-mobile {{ Route::is('customer.order') ? 'active' : '' }}">
            <i class="fas fa-mug-hot"></i>
            Menu
        </a>
        <a href="{{ route('customer.cart') }}" class="nav-item-mobile {{ Route::is('customer.cart') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i>
            Cart
        </a>
        <a href="{{ route('customer.history') }}" class="nav-item-mobile {{ Route::is('customer.history') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i>
            Orders
        </a>
        <a href="#" class="nav-item-mobile"> <i class="fas fa-user"></i>
            Akun
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>