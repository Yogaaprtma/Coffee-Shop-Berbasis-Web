@extends('admin.layouts.main')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid py-4">
        <!-- Welcome Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-light">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-coffee text-white p-3 me-3">
                                <i class="fas fa-user fs-4"></i>
                            </div>
                            <div>
                                <h4 class="mb-1">Welcome, {{ $user->nama }}!</h4>
                                <p class="text-muted mb-0">{{ date('l, F d, Y') }}</p>
                            </div>
                            <div class="ms-auto">
                                <a href="#" class="btn btn-sm btn-coffee">
                                    <i class="fas fa-store me-1"></i> View Store
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <!-- Orders -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <div class="rounded-circle bg-primary bg-opacity-25 p-3 text-center">
                                    <i class="fas fa-shopping-bag text-primary"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="text-xs fw-bold text-uppercase mb-1">Orders</div>
                                <div class="h5 mb-0 fw-bold">{{ $totalOrders }}</div>
                                <div class="text-xs text-success"><i class="fas fa-arrow-up me-1"></i>Updated</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Revenue -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <div class="rounded-circle bg-success bg-opacity-25 p-3 text-center">
                                    <i class="fas fa-dollar-sign text-success"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="text-xs fw-bold text-uppercase mb-1">Revenue</div>
                                <div class="h5 mb-0 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                                <div class="text-xs text-success"><i class="fas fa-arrow-up me-1"></i>Updated</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Customers -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <div class="rounded-circle bg-info bg-opacity-25 p-3 text-center">
                                    <i class="fas fa-users text-info"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="text-xs fw-bold text-uppercase mb-1">Customers</div>
                                <div class="h5 mb-0 fw-bold">{{ $totalCustomers }}</div>
                                <div class="text-xs text-success"><i class="fas fa-arrow-up me-1"></i>Updated</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Products -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <div class="rounded-circle bg-warning bg-opacity-25 p-3 text-center">
                                    <i class="fas fa-coffee text-warning"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="text-xs fw-bold text-uppercase mb-1">Products</div>
                                <div class="h5 mb-0 fw-bold">{{ $totalProducts }}</div>
                                <div class="text-xs text-success"><i class="fas fa-plus me-1"></i>Updated</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Main Management Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body text-center py-5">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-4 mx-auto mb-4" style="width: fit-content;">
                            <i class="fas fa-list fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Manage Categories</h5>
                        <p class="text-muted mb-4">Organize your products by creating, editing, and managing categories.</p>
                        <a href="{{ route('category.page') }}" class="btn btn-primary w-100">
                            <i class="fas fa-cog me-2"></i> Manage Categories
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body text-center py-5">
                        <div class="rounded-circle bg-success bg-opacity-10 p-4 mx-auto mb-4" style="width: fit-content;">
                            <i class="fas fa-coffee fa-2x text-success"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Manage Products</h5>
                        <p class="text-muted mb-4">Add, edit, or remove coffee products and manage inventory levels.</p>
                        <a href="{{ route('product.page') }}" class="btn btn-success w-100">
                            <i class="fas fa-tags me-2"></i> Manage Products
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body text-center py-5">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-4 mx-auto mb-4" style="width: fit-content;">
                            <i class="fas fa-shopping-cart fa-2x text-warning"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Manage Orders</h5>
                        <p class="text-muted mb-4">Track, process, and manage customer orders and shipments.</p>
                        <a href="{{ route('order.page') }}" class="btn btn-warning w-100 text-white">
                            <i class="fas fa-box me-2"></i> Manage Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection