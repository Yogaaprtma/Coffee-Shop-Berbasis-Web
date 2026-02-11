<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Admin Dashboard') | Beanie Admin</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <style>
            :root {
                --primary-color: #6F4E37;
                --secondary-color: #A67B5B;
                --bg-light: #F5F7FA;
                --sidebar-width: 260px;
                --text-dark: #2C3E50;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background-color: var(--bg-light);
                color: var(--text-dark);
                padding-bottom: 90px;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: var(--sidebar-width);
                background: white;
                box-shadow: 2px 0 20px rgba(0,0,0,0.05);
                z-index: 1000;
                display: none;
                flex-direction: column;
                padding: 20px;
            }

            .sidebar-brand {
                font-size: 1.5rem;
                font-weight: 800;
                color: var(--primary-color);
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 40px;
                padding-left: 10px;
            }

            .nav-link-custom {
                display: flex;
                align-items: center;
                padding: 12px 15px;
                color: #7f8c8d;
                text-decoration: none;
                border-radius: 12px;
                margin-bottom: 8px;
                transition: all 0.3s;
                font-weight: 500;
            }

            .nav-link-custom i {
                width: 25px;
                font-size: 1.2rem;
                margin-right: 10px;
            }

            .nav-link-custom:hover, .nav-link-custom.active {
                background-color: var(--primary-color);
                color: white;
                box-shadow: 0 5px 15px rgba(111, 78, 55, 0.3);
            }

            .main-content {
                width: 100%;
                padding: 20px;
            }

            @media (min-width: 768px) {
                .sidebar {
                    display: flex;
                }
                .main-content {
                    margin-left: var(--sidebar-width);
                    width: calc(100% - var(--sidebar-width));
                    padding: 30px 40px;
                }
                body {
                    padding-bottom: 0;
                }
                .mobile-bottom-nav {
                    display: none !important;
                }
                .mobile-header {
                    display: none !important;
                }
            }

            .mobile-header {
                background: white;
                padding: 15px 20px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                display: flex;
                justify-content: space-between;
                align-items: center;
                position: sticky;
                top: 0;
                z-index: 99;
            }

            .mobile-bottom-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
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
                color: #bdc3c7;
                text-decoration: none;
                font-size: 0.7rem;
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 5px 0;
            }

            .nav-item-mobile i {
                font-size: 1.3rem;
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

            .user-menu {
                cursor: pointer;
            }
        </style>
    </head>

    <body>
        <aside class="sidebar">
            <a href="{{ route('home.admin') }}" class="sidebar-brand">
                <i class="fas fa-mug-hot"></i> Beanie.Admin
            </a>
            
            <nav class="nav flex-column flex-grow-1">
                <a href="{{ route('home.admin') }}" class="nav-link-custom {{ Route::is('home.admin') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
                
                <p class="text-uppercase text-muted small fw-bold mt-4 mb-2 ps-3" style="font-size: 0.75rem;">Master Data</p>
                <a href="{{ route('category.page') }}" class="nav-link-custom {{ Route::is('category.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Categories
                </a>
                <a href="{{ route('product.page') }}" class="nav-link-custom {{ Route::is('products.*') || Route::is('product.page') ? 'active' : '' }}">
                    <i class="fas fa-coffee"></i> Products
                </a>
                
                <p class="text-uppercase text-muted small fw-bold mt-4 mb-2 ps-3" style="font-size: 0.75rem;">Transaction</p>
                <a href="{{ route('order.page') }}" class="nav-link-custom {{ Route::is('order.page') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i> Orders
                </a>

                <p class="text-uppercase text-muted small fw-bold mt-4 mb-2 ps-3" style="font-size: 0.75rem;">Account</p>
                <a href="{{ route('admin.profile') }}" class="nav-link-custom {{ Route::is('admin.profile') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i> My Profile
                </a>
            </nav>

            <div class="mt-auto pt-4 border-top">
                <a href="{{ route('logout') }}" class="nav-link-custom text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </aside>

        <header class="mobile-header d-md-none">
            <h5 class="fw-bold m-0 text-dark">
                <i class="fas fa-mug-hot text-primary-custom me-2"></i>Admin
            </h5>
            <div class="dropdown">
                <a href="#" class="text-dark" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama ?? 'A' }}&background=6F4E37&color=fff" class="rounded-circle" width="35" height="35" alt="Profile">
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4">
                    <li><h6 class="dropdown-header">Hi, {{ Auth::user()->nama ?? 'Admin' }}</h6></li>
                    <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </div>
        </header>

        <main class="main-content">
            <div class="d-none d-md-flex justify-content-between align-items-center mb-5">
                <div>
                    <h4 class="fw-bold m-0">@yield('page-title', 'Dashboard')</h4>
                    <p class="text-muted small m-0">{{ date('l, d F Y') }}</p>
                </div>
                <div class="dropdown">
                    <div class="d-flex align-items-center user-menu bg-white py-2 px-3 rounded-pill shadow-sm" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama ?? 'A' }}&background=6F4E37&color=fff" class="rounded-circle me-2" width="35" height="35" alt="Admin">
                        <div class="d-flex flex-column me-2 text-start">
                            <span class="fw-bold small lh-1">{{ Auth::user()->nama ?? 'Admin' }}</span>
                            <span class="text-muted" style="font-size: 0.7rem;">Administrator</span>
                        </div>
                        <i class="fas fa-chevron-down small text-muted"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2">
                        <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>

            @yield('content')
        </main>

        <div class="mobile-bottom-nav d-md-none">
            <a href="{{ route('home.admin') }}" class="nav-item-mobile {{ Route::is('home.admin') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                Home
            </a>
            <a href="{{ route('product.page') }}" class="nav-item-mobile {{ Route::is('product.page') || Route::is('products.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                Produk
            </a>
            <a href="{{ route('order.page') }}" class="nav-item-mobile {{ Route::is('order.page') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i>
                Order
            </a>
            <a href="{{ route('category.page') }}" class="nav-item-mobile {{ Route::is('category.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i>
                Kategori
            </a>
            <a href="{{ route('admin.profile') }}" class="nav-item-mobile {{ Route::is('admin.profile') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i>
                Profil
            </a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </body>
</html>