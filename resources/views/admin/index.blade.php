@extends('admin.layouts.main')

@section('title', 'Dashboard')
@section('page-title', 'Overview')

@section('content')
    <style>
        .stat-card {
            background: white;
            border: none;
            border-radius: 16px;
            padding: 25px;
            height: 100%;
            transition: transform 0.3s;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        
        .bg-soft-primary { 
            background-color: rgba(111, 78, 55, 0.1); 
            color: #6F4E37; 
        }

        .bg-soft-success { 
            background-color: rgba(33, 150, 83, 0.1); 
            color: #219653; 
        }

        .bg-soft-warning { 
            background-color: rgba(242, 153, 74, 0.1); 
            color: #f2994a; 
        }

        .bg-soft-info { 
            background-color: rgba(47, 128, 237, 0.1); 
            color: #2f80ed; 
        }

        .action-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #f0f0f0;
            transition: 0.3s;
            text-align: center;
            padding: 30px 20px;
            height: 100%;
            text-decoration: none;
            display: block;
            color: var(--text-dark);
        }
        .action-card:hover {
            border-color: var(--primary-color);
            background-color: #fffbf7;
            color: var(--primary-color);
        }
    </style>

    <div class="container-fluid p-0">
        <div class="d-md-none mb-4">
            <div class="bg-white p-4 rounded-4 shadow-sm border-start border-5 border-primary">
                <h5 class="fw-bold">Halo, {{ $user->nama }}! 👋</h5>
                <p class="text-muted small m-0">Selamat datang kembali di panel admin.</p>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small fw-bold text-uppercase mb-1">Total Revenue</p>
                            <h4 class="fw-bold mb-0">Rp {{ number_format($totalRevenue/1000, 0) }}k</h4>
                        </div>
                        <div class="icon-box bg-soft-success">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-soft-success rounded-pill px-2 py-1 small">
                            <i class="fas fa-arrow-up me-1"></i> Income
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small fw-bold text-uppercase mb-1">Orders</p>
                            <h4 class="fw-bold mb-0">{{ $totalOrders }}</h4>
                        </div>
                        <div class="icon-box bg-soft-warning">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">Total Transactions</span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small fw-bold text-uppercase mb-1">Products</p>
                            <h4 class="fw-bold mb-0">{{ $totalProducts }}</h4>
                        </div>
                        <div class="icon-box bg-soft-primary">
                            <i class="fas fa-coffee"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">Active Menu Items</span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small fw-bold text-uppercase mb-1">Customers</p>
                            <h4 class="fw-bold mb-0">{{ $totalCustomers }}</h4>
                        </div>
                        <div class="icon-box bg-soft-info">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">Registered Users</span>
                    </div>
                </div>
            </div>
        </div>

        <h5 class="fw-bold mb-3">Quick Actions</h5>
        <div class="row g-3">
            <div class="col-6 col-md-4 col-xl-3">
                <a href="{{ route('products.create') }}" class="action-card">
                    <div class="mb-3 text-primary">
                        <i class="fas fa-plus-circle fa-2x"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Add Product</h6>
                    <small class="text-muted">Create new menu item</small>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-3">
                <a href="{{ route('category.create') }}" class="action-card">
                    <div class="mb-3 text-warning">
                        <i class="fas fa-tags fa-2x"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Add Category</h6>
                    <small class="text-muted">Create new category</small>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-3">
                <a href="{{ route('order.page') }}" class="action-card">
                    <div class="mb-3 text-success">
                        <i class="fas fa-clipboard-check fa-2x"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Check Orders</h6>
                    <small class="text-muted">Process incoming orders</small>
                </a>
            </div>
        </div>
    </div>
@endsection