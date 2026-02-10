@extends('customer.layouts.main')

@section('title', 'Akun Saya')

@section('content')
    <style>
        .profile-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            height: 180px;
            border-radius: 0 0 30px 30px;
            position: relative;
            margin-bottom: 60px;
        }
        
        .profile-avatar-wrapper {
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .menu-list {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid #f9f9f9;
            color: var(--text-dark);
            text-decoration: none;
            transition: 0.2s;
        }
        
        .menu-item:last-child {
            border-bottom: none;
        }
        
        .menu-item:hover {
            background-color: #f8f9fa;
            color: var(--primary-color);
        }
        
        .menu-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: #666;
        }
        
        .menu-item:hover .menu-icon {
            background: var(--bg-light);
            color: var(--primary-color);
        }
        
        .logout-btn {
            background: #fee2e2;
            color: #dc2626;
            border: none;
            width: 100%;
            padding: 15px;
            border-radius: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: 0.3s;
        }
        
        .logout-btn:hover {
            background: #fecaca;
        }

        /* Desktop View Adjustments */
        @media (min-width: 992px) {
            .profile-container {
                max-width: 800px;
                margin: 0 auto;
            }
            .profile-header {
                height: 220px;
                margin-bottom: 80px;
                border-radius: 20px;
                margin-top: 20px;
            }
            .profile-avatar {
                width: 130px;
                height: 130px;
            }
        }
    </style>

    <div class="profile-header shadow-sm">
        <div class="profile-avatar-wrapper">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <h5 class="fw-bold mb-0 text-dark">{{ $user->nama }}</h5>
            <p class="text-muted small mb-0">{{ $user->email }}</p>
        </div>
    </div>

    <div class="container profile-container pb-5">
        <div class="row g-4">
            <div class="col-lg-6">
                <h6 class="fw-bold mb-3 ps-2 text-muted text-uppercase small">Personal Info</h6>
                <div class="menu-list mb-4">
                    <div class="p-4">
                        <div class="mb-3">
                            <label class="small text-muted mb-1">Nama Lengkap</label>
                            <div class="fw-bold">{{ $user->nama }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted mb-1">Email</label>
                            <div class="fw-bold">{{ $user->email }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted mb-1">Nomor Telepon</label>
                            <div class="fw-bold">{{ $user->no_telp ?? '-' }}</div>
                        </div>
                        <div class="mb-0">
                            <label class="small text-muted mb-1">Alamat</label>
                            <div class="fw-bold text-truncate">{{ $user->alamat ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="bg-light p-3 text-center border-top">
                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-pencil-alt me-1"></i> Edit Profile
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <h6 class="fw-bold mb-3 ps-2 text-muted text-uppercase small">Menu</h6>
                <div class="menu-list mb-4">
                    <a href="{{ route('customer.history') }}" class="menu-item">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon"><i class="fas fa-receipt"></i></div>
                            <span class="fw-medium">Riwayat Pesanan</span>
                        </div>
                        <i class="fas fa-chevron-right text-muted small"></i>
                    </a>
                    <a href="{{ route('customer.cart') }}" class="menu-item">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon"><i class="fas fa-shopping-bag"></i></div>
                            <span class="fw-medium">Keranjang Belanja</span>
                        </div>
                        <div class="d-flex align-items-center">
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="badge bg-danger rounded-pill me-2">{{ count(session('cart')) }}</span>
                            @endif
                            <i class="fas fa-chevron-right text-muted small"></i>
                        </div>
                    </a>
                    <a href="#" class="menu-item">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <span class="fw-medium">Alamat Tersimpan</span>
                        </div>
                        <i class="fas fa-chevron-right text-muted small"></i>
                    </a>
                    <a href="#" class="menu-item">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon"><i class="fas fa-lock"></i></div>
                            <span class="fw-medium">Ubah Password</span>
                        </div>
                        <i class="fas fa-chevron-right text-muted small"></i>
                    </a>
                </div>

                <h6 class="fw-bold mb-3 ps-2 text-muted text-uppercase small">Lainnya</h6>
                <div class="menu-list mb-4">
                    <a href="#" class="menu-item">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon"><i class="fas fa-question-circle"></i></div>
                            <span class="fw-medium">Bantuan & Support</span>
                        </div>
                        <i class="fas fa-chevron-right text-muted small"></i>
                    </a>
                    <a href="#" class="menu-item">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon"><i class="fas fa-info-circle"></i></div>
                            <span class="fw-medium">Tentang Aplikasi</span>
                        </div>
                        <i class="fas fa-chevron-right text-muted small"></i>
                    </a>
                </div>

                <a href="{{ route('logout') }}" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Keluar Akun
                </a>
            </div>
        </div>
    </div>
@endsection