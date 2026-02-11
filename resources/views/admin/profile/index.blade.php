@extends('admin.layouts.main')

@section('title', 'Admin Profile')
@section('page-title', 'My Profile')

@section('content')
    <style>
        .profile-cover {
            background: linear-gradient(135deg, var(--primary-color) 0%, #3e2b22 100%);
            height: 140px;
            border-radius: 16px 16px 0 0;
            position: relative;
        }
        
        .profile-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
            overflow: visible;
            background: white;
        }

        .avatar-wrapper {
            position: relative;
            margin-top: -70px;
            text-align: center;
            margin-bottom: 15px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border: 5px solid #fff;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            object-fit: cover;
            background-color: #fff;
        }

        .btn-edit-photo {
            background-color: #fff;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            border-radius: 50px;
            padding: 6px 20px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .btn-edit-photo:hover {
            background-color: var(--primary-color);
            color: #fff;
        }

        .info-box-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: 12px;
            background-color: #fdfdfd;
            border: 1px solid #f0f0f0;
            transition: 0.3s;
        }

        .info-box-item:hover {
            border-color: #eee;
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        }

        .icon-box {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            background-color: rgba(111, 78, 55, 0.08);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .logout-btn-card {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fee2e2;
            border-radius: 12px;
            padding: 15px;
            width: 100%;
            font-weight: 600;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
        }
        
        .logout-btn-card:hover {
            background-color: #fee2e2;
            color: #b91c1c;
            transform: translateY(-2px);
        }
    </style>

    <div class="container-fluid p-0">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card profile-card h-100">
                    <div class="profile-cover"></div>
                    
                    <div class="card-body pt-0 text-center pb-4">
                        <div class="avatar-wrapper">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=6F4E37&color=fff&size=256" alt="Profile" class="profile-avatar">
                        </div>
                        
                        <h4 class="fw-bold mb-1">{{ $user->nama }}</h4>
                        <span class="badge bg-warning text-dark rounded-pill px-3 mb-3 border border-white">Administrator</span>
                        
                        <p class="text-muted small mb-4">
                            <i class="far fa-calendar-alt me-1"></i> Bergabung sejak {{ $user->created_at->format('M Y') }}
                        </p>

                        <button class="btn-edit-photo mb-4">
                            <i class="fas fa-camera me-1"></i> Ganti Foto
                        </button>

                        <hr class="my-0 opacity-10">

                        <div class="row mt-4">
                            <div class="col-4">
                                <h6 class="fw-bold mb-0">Active</h6>
                                <small class="text-muted" style="font-size: 0.7rem;">Status</small>
                            </div>
                            <div class="col-4 border-start border-end">
                                <h6 class="fw-bold mb-0">ID: {{ $user->id }}</h6>
                                <small class="text-muted" style="font-size: 0.7rem;">User ID</small>
                            </div>
                            <div class="col-4">
                                <h6 class="fw-bold mb-0">Indo</h6>
                                <small class="text-muted" style="font-size: 0.7rem;">Region</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card profile-card mb-4">
                    <div class="card-header bg-white border-0 py-3 px-4">
                        <h6 class="fw-bold m-0 text-dark">
                            <i class="fas fa-user-circle me-2 text-secondary"></i>Personal Information
                        </h6>
                    </div>
                    <div class="card-body px-4 pt-0 pb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-box-item">
                                    <div class="icon-box me-3">
                                        <i class="fas fa-signature"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Nama Lengkap</small>
                                        <span class="fw-bold text-dark">{{ $user->nama }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box-item">
                                    <div class="icon-box me-3">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Email Address</small>
                                        <span class="fw-bold text-dark text-break">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box-item">
                                    <div class="icon-box me-3">
                                        <i class="fas fa-phone-alt"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Nomor Telepon</small>
                                        <span class="fw-bold text-dark">{{ $user->no_telp ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box-item">
                                    <div class="icon-box me-3">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Alamat</small>
                                        <span class="fw-bold text-dark text-truncate d-block" style="max-width: 200px;">
                                            {{ $user->alamat ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button class="btn btn-link text-decoration-none text-muted small p-0">
                                <i class="fas fa-pencil-alt me-1"></i> Edit Information
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card profile-card">
                    <div class="card-header bg-white border-0 py-3 px-4">
                        <h6 class="fw-bold m-0 text-dark">
                            <i class="fas fa-cog me-2 text-secondary"></i>Pengaturan Akun
                        </h6>
                    </div>
                    <div class="card-body px-4 pt-0 pb-4">
                        <div class="list-group list-group-flush rounded-3 border-0">
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 border-bottom-0 mb-2 rounded bg-light">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-lock text-muted me-3"></i>
                                    <div>
                                        <span class="fw-semibold d-block">Ubah Password</span>
                                        <small class="text-muted">Perbarui kata sandi keamanan Anda</small>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-muted small"></i>
                            </a>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('logout') }}" class="logout-btn-card">
                                <span class="d-flex align-items-center">
                                    <i class="fas fa-sign-out-alt me-2"></i> Keluar Akun
                                </span>
                                <i class="fas fa-arrow-right small"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection