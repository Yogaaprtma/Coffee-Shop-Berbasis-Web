@extends('admin.layouts.main')

@section('title', 'Manage Categories')
@section('page-title', 'Categories')

@section('content')
    <style>
        .table-card {
            border-radius: 16px;
            border: none;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
        }
        
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #eee;
            color: #6c757d;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            padding: 15px;
        }
        
        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .category-img-box {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            overflow: hidden;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #eee;
        }
        
        .category-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mobile-category-item {
            background: white;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.01);
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
            border: none;
        }
        
        .btn-edit { 
            background: #fff3cd; 
            color: #856404; 
        }

        .btn-edit:hover { 
            background: #ffe69c; 
        }
        
        .btn-delete { 
            background: #f8d7da; 
            color: #721c24; 
        }

        .btn-delete:hover { 
            background: #f1b0b7; 
        }

        .search-input {
            border-radius: 50px;
            padding-left: 40px;
            border: 1px solid #eee;
            background-color: white;
            height: 45px;
        }
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
    </style>

    <div class="container-fluid p-0">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
            <div class="position-relative w-100 w-md-auto" style="max-width: 400px;">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="form-control search-input" placeholder="Search categories..." id="searchCategory">
            </div>
            <a href="{{ route('category.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold w-100 w-md-auto">
                <i class="fas fa-plus me-2"></i> Add New Category
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card table-card d-none d-md-block">
            <div class="card-body p-0">
                <table class="table mb-0 w-100">
                    <thead>
                        <tr>
                            <th width="80" class="text-center">#</th>
                            <th width="120">Image</th>
                            <th width="25%">Category Name</th>
                            <th>Description</th>
                            <th width="150" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>
                            <td>
                                <div class="category-img-box">
                                    @if($category->gambar)
                                        <img src="{{ asset('storage/'.$category->gambar) }}" alt="{{ $category->nama }}">
                                    @else
                                        <i class="fas fa-image text-muted fs-4"></i>
                                    @endif
                                </div>
                            </td>
                            <td><span class="fw-bold text-dark">{{ $category->nama }}</span></td>
                            <td><small class="text-muted">{{ Str::limit($category->deskripsi, 50) }}</small></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('category.edit', $category->id) }}" class="action-btn btn-edit" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-pencil-alt small"></i>
                                    </a>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="action-btn btn-delete delete-btn" data-bs-toggle="tooltip" title="Delete">
                                            <i class="fas fa-trash-alt small"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                    <p>No categories found. Create one now!</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-md-none category-list">
            @forelse($categories as $category)
            <div class="mobile-category-item">
                <div class="category-img-box flex-shrink-0" style="width: 50px; height: 50px;">
                    @if($category->gambar)
                        <img src="{{ asset('storage/'.$category->gambar) }}" alt="{{ $category->nama }}">
                    @else
                        <i class="fas fa-image text-muted"></i>
                    @endif
                </div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1 text-dark">{{ $category->nama }}</h6>
                    <p class="text-muted small mb-0 text-truncate" style="max-width: 180px;">{{ $category->deskripsi }}</p>
                </div>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('category.edit', $category->id) }}" class="action-btn btn-edit">
                        <i class="fas fa-pencil-alt small"></i>
                    </a>
                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="action-btn btn-delete delete-btn">
                            <i class="fas fa-trash-alt small"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x mb-3 text-muted opacity-25"></i>
                <p class="text-muted small">No categories available</p>
            </div>
            @endforelse
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-body text-center p-4">
                    <div class="mb-3 text-danger bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-exclamation-triangle fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Are you sure?</h5>
                    <p class="text-muted small mb-4">This category will be permanently deleted.</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="confirmDeleteBtn" class="btn btn-danger rounded-pill px-3">Yes, Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Search Logic
            const searchInput = document.getElementById('searchCategory');
            
            searchInput.addEventListener('keyup', function() {
                const value = this.value.toLowerCase();
                
                // Filter Desktop Table
                const rows = document.querySelectorAll('table tbody tr');
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(value) ? '' : 'none';
                });

                // Filter Mobile List
                const items = document.querySelectorAll('.mobile-category-item');
                items.forEach(item => {
                    const text = item.innerText.toLowerCase();
                    item.style.display = text.includes(value) ? 'flex' : 'none';
                });
            });

            // Delete Logic
            let deleteForm = null;
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            const modalEl = document.getElementById('deleteConfirmModal');
            const modal = new bootstrap.Modal(modalEl);

            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    deleteForm = this.closest('form');
                    modal.show();
                });
            });

            confirmBtn.addEventListener('click', function() {
                if (deleteForm) deleteForm.submit();
                modal.hide();
            });
        });
    </script>
@endsection





{{-- @extends('admin.layouts.main')

@section('title', 'Kelola Kategori')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="m-0">
                <i class="fas fa-tags me-2 text-secondary"></i>
                Kelola Kategori
            </h2>
            <p class="text-muted mt-2">Mengelola kategori produk Beanie Coffee Shop</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('home.admin') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
            <a href="{{ route('category.create') }}" class="btn btn-coffee">
                <i class="fas fa-plus-circle me-2"></i>Tambah Kategori
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="m-0 text-secondary">Daftar Kategori</h5>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari kategori..." id="searchCategory">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="60">No</th>
                            <th width="100">Gambar</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                @if($category->gambar)
                                    <img src="{{ asset('storage/'.$category->gambar) }}" class="img-thumbnail rounded" width="70" height="70" alt="{{ $category->nama }}">
                                @else
                                    <div class="bg-light rounded text-center p-3" style="width: 70px; height: 70px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-medium">{{ $category->nama }}</td>
                            <td>
                                <div class="text-muted text-truncate" style="max-width: 350px;">
                                    {{ $category->deskripsi }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit Kategori">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-bs-toggle="tooltip" title="Hapus Kategori">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if(count($categories) == 0)
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="py-5">
                                    <i class="fas fa-folder-open text-muted mb-3" style="font-size: 3rem;"></i>
                                    <p class="text-muted">Belum ada kategori yang tersedia</p>
                                    <a href="{{ route('category.create') }}" class="btn btn-sm btn-coffee mt-2">
                                        <i class="fas fa-plus-circle me-2"></i>Tambah Kategori Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <p class="text-muted mb-0">Menampilkan {{ count($categories) }} kategori</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center">Apakah Anda yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Search functionality
        $("#searchCategory").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        
        // Delete confirmation
        let deleteForm = null;
        
        $(".delete-btn").on("click", function(e) {
            e.preventDefault();
            deleteForm = $(this).closest('form');
            $("#deleteConfirmModal").modal('show');
        });
        
        $("#confirmDeleteBtn").on("click", function() {
            if (deleteForm) {
                deleteForm.submit();
            }
            $("#deleteConfirmModal").modal('hide');
        });
    });
</script>
@endsection --}}