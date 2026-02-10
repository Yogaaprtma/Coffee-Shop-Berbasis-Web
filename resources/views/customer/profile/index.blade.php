@extends('customer.layouts.main')

@section('title', 'Akun Saya')

@section('content')
    <style>
        .profile-header-container {
            position: relative;
            margin-bottom: 110px; 
        }

        .profile-bg {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            height: 150px;
            border-radius: 0 0 30px 30px;
            width: 100%;
        }

        .profile-info-wrapper {
            position: absolute;
            top: 100%; 
            left: 50%;
            transform: translate(-50%, -50%); 
            text-align: center;
            width: 100%;
            z-index: 10;
            pointer-events: none; 
        }

        .profile-avatar {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            border: 5px solid #fff;
            background: #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--primary-color);
            margin: 0 auto 10px auto;
            pointer-events: auto;
        }

        .user-name {
            color: var(--text-dark);
            font-weight: 800;
            font-size: 1.25rem;
            margin-bottom: 2px;
            text-shadow: 0 2px 10px rgba(255,255,255,0.8);
        }
        .user-email {
            color: #666;
            font-size: 0.9rem;
            background-color: rgba(255,255,255,0.8);
            padding: 2px 10px;
            border-radius: 10px;
            display: inline-block;
        }

        @media (min-width: 992px) {
            .profile-header-container {
                margin-bottom: 140px; 
            }
            .profile-bg {
                height: 200px;
                border-radius: 20px;
                margin-top: 20px;
            }
            .profile-avatar {
                width: 140px;
                height: 140px;
                font-size: 4rem;
                border-width: 6px;
            }
            .profile-container {
                max-width: 900px;
                margin: 0 auto;
            }
            .user-name {
                font-size: 1.5rem;
            }
        }

        .menu-list {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
            border: 1px solid #f0f0f0;
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
        .menu-item:last-child { border-bottom: none; }
        .menu-item:hover {
            background-color: #fffbf7;
            color: var(--primary-color);
        }
        
        .menu-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: #666;
            transition: 0.2s;
        }
        .menu-item:hover .menu-icon {
            background: var(--primary-color);
            color: white;
        }
        
        .logout-btn {
            background: #fee2e2;
            color: #dc2626;
            display: block;
            width: 100%;
            padding: 15px;
            border-radius: 15px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            transition: 0.3s;
            border: none;
        }
        .logout-btn:hover { background: #fecaca; color: #b91c1c; }
    </style>

    <div class="container px-0 px-lg-3">
        <div class="profile-header-container">
            <div class="profile-bg shadow-sm"></div>
            <div class="profile-info-wrapper">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h5 class="user-name">{{ $user->nama }}</h5>
                <p class="user-email">{{ $user->email }}</p>
            </div>
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
                </div>

                <a href="{{ route('logout') }}" class="logout-btn mb-4">
                    <i class="fas fa-sign-out-alt me-2"></i> Keluar Akun
                </a>
            </div>
        </div>
    </div>
@endsection