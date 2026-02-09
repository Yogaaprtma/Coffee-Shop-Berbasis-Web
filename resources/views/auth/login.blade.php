<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | Modern App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-bottom: 80px; /* Space for mobile nav */
        }

        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .card-header-custom {
            background: transparent;
            border-bottom: none;
            padding-top: 2rem;
            padding-bottom: 1rem;
        }

        .btn-primary-custom {
            background: #764ba2;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            background: #5a3682;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(118, 75, 162, 0.4);
        }

        .form-floating > .form-control:focus, .form-floating > .form-control:not(:placeholder-shown) {
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }
        
        .form-control:focus {
            box-shadow: none;
            border-color: #764ba2;
        }

        /* Mobile Bottom Nav Styles */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            display: none; /* Hidden on desktop */
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .nav-item-custom {
            flex: 1;
            text-align: center;
            padding: 15px 0;
            color: #ccc;
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.3s;
        }

        .nav-item-custom i {
            display: block;
            font-size: 1.2rem;
            margin-bottom: 4px;
        }

        .nav-item-custom.active {
            color: #764ba2;
            font-weight: 600;
        }

        /* Show nav only on mobile */
        @media (max-width: 768px) {
            .mobile-bottom-nav {
                display: flex;
            }
            body {
                align-items: flex-start;
                padding-top: 40px;
            }
        }
        
        .password-toggle {
            cursor: pointer;
            z-index: 10;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card card-custom bg-white p-4">
                    <div class="card-header-custom text-center">
                        <h2 class="fw-bold text-dark">Welcome Back!</h2>
                        <p class="text-muted small">Silakan login untuk melanjutkan</p>
                    </div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control rounded-4" id="email" placeholder="name@example.com" required>
                                <label for="email">Email Address</label>
                                @error('email')
                                    <div class="text-danger small mt-1 ps-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="position-relative mb-4">
                                <div class="form-floating">
                                    <input type="password" name="password" class="form-control rounded-4" id="password" placeholder="Password" required>
                                    <label for="password">Password</label>
                                </div>
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3 password-toggle text-muted" onclick="togglePasswordVisibility()">
                                    <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                </span>
                                @error('password')
                                    <div class="text-danger small mt-1 ps-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 mb-4">
                                <button type="submit" class="btn btn-primary-custom text-white shadow-sm">
                                    LOG IN
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="text-muted small">Belum punya akun? <a href="{{ route('register.page') }}" class="text-decoration-none fw-bold" style="color: #764ba2;">Daftar Sekarang</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mobile-bottom-nav d-md-none">
        <a href="{{ route('login.page') }}" class="nav-item-custom active">
            <i class="fas fa-sign-in-alt"></i>
            Login
        </a>
        <a href="{{ route('register.page') }}" class="nav-item-custom">
            <i class="fas fa-user-plus"></i>
            Register
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordIcon.classList.remove('fa-eye');
                togglePasswordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                togglePasswordIcon.classList.remove('fa-eye-slash');
                togglePasswordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>