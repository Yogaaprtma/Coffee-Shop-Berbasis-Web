@extends('admin.layouts.main')

@section('title', 'Manage Categories')
@section('page-title', 'Categories')

@section('content')
    <style>
        .page-header-container {
            margin-bottom: 1.5rem;
        }

        .search-group {
            position: relative;
            width: 100%;
            max-width: 300px;
        }

        .search-input {
            border-radius: 50px;
            padding-left: 45px;
            padding-right: 20px;
            border: 1px solid #eee;
            background-color: white;
            height: 45px;
            font-size: 0.9rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }
        .search-input:focus {
            background-color: white;
            border-color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(111, 78, 55, 0.1);
            outline: none;
        }
        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 1rem;
        }

        .btn-add-new {
            background: var(--primary-color);
            color: white;
            border-radius: 50px;
            padding: 0 25px; 
            height: 45px;    
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 10px rgba(111, 78, 55, 0.2);
            transition: all 0.3s;
            border: none;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            width: 100%;
        }
        
        .btn-add-new:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(111, 78, 55, 0.3);
            color: white;
        }

        @media (min-width: 768px) {
            .btn-add-new {
                width: auto;
            }
        }

        .table-card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
            overflow: hidden;
        }
        .table thead th {
            background-color: #f9fafb;
            color: #6b7280;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px;
            border-bottom: 1px solid #f0f0f0;
        }
        .table tbody td {
            padding: 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
            font-size: 0.9rem;
        }
        .img-thumb-box {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            overflow: hidden;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .img-thumb-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mobile-card {
            background: white;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 16px;
            border: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            transition: transform 0.2s;
        }
        .mobile-card:active {
            transform: scale(0.98);
        }
        .mobile-img {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            flex-shrink: 0;
            object-fit: cover;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
            border: none;
            margin: 0 2px;
            text-decoration: none;
        }
        .btn-light-edit { 
            background: #fff7ed; 
            color: #ea580c; 
        }

        .btn-light-edit:hover { 
            background: #ffedd5; 
            color: #c2410c; 
        }
        
        .btn-light-delete { 
            background: #fef2f2; 
            color: #dc2626; 
        }

        .btn-light-delete:hover { 
            background: #fee2e2; 
            color: #b91c1c; 
        }
    </style>

    <div class="container-fluid p-0">
        <div class="row align-items-center mb-4 g-3 page-header-container">
            <div class="col-12 col-md-auto me-auto">
                <div class="search-group">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="form-control search-input" placeholder="Search categories..." id="searchCategory">
                </div>
            </div>

            <div class="col-12 col-md-auto">
                <a href="{{ route('category.create') }}" class="btn-add-new">
                    <i class="fas fa-plus me-2"></i> New Category
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2 fs-5"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card table-card d-none d-md-block">
            <div class="card-body p-0">
                <table class="table mb-0 w-100">
                    <thead>
                        <tr>
                            <th width="60" class="text-center">No</th>
                            <th width="80">Image</th>
                            <th width="25%">Category Name</th>
                            <th>Description</th>
                            <th width="120" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>
                            <td>
                                <div class="img-thumb-box">
                                    @if($category->gambar)
                                        <img src="{{ asset('storage/'.$category->gambar) }}" alt="{{ $category->nama }}">
                                    @else
                                        <i class="fas fa-image text-muted"></i>
                                    @endif
                                </div>
                            </td>
                            <td><span class="fw-bold text-dark">{{ $category->nama }}</span></td>
                            <td class="text-muted small">{{ Str::limit($category->deskripsi, 60) }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('category.edit', $category->id) }}" class="action-btn btn-light-edit" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-pencil-alt small"></i>
                                    </a>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="action-btn btn-light-delete delete-btn" data-bs-toggle="tooltip" title="Delete">
                                            <i class="fas fa-trash-alt small"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="bg-light rounded-circle p-4 mb-3">
                                        <i class="fas fa-folder-open text-muted fs-2"></i>
                                    </div>
                                    <h6 class="text-muted fw-bold">No categories found</h6>
                                    <p class="text-muted small mb-0">Get started by creating a new category.</p>
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
            <div class="mobile-card">
                @if($category->gambar)
                    <img src="{{ asset('storage/'.$category->gambar) }}" class="mobile-img shadow-sm" alt="{{ $category->nama }}">
                @else
                    <div class="mobile-img bg-light d-flex align-items-center justify-content-center text-muted">
                        <i class="fas fa-image"></i>
                    </div>
                @endif

                <div class="flex-grow-1" style="min-width: 0;">
                    <h6 class="fw-bold text-dark mb-1 text-truncate">{{ $category->nama }}</h6>
                    <p class="text-muted small mb-0 text-truncate">{{ $category->deskripsi }}</p>
                </div>

                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('category.edit', $category->id) }}" class="action-btn btn-light-edit">
                        <i class="fas fa-pencil-alt small"></i>
                    </a>
                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="action-btn btn-light-delete delete-btn">
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
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-body text-center p-4">
                    <div class="mb-3 mx-auto bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-trash-alt text-danger fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Delete Category?</h5>
                    <p class="text-muted small mb-4">This action cannot be undone.</p>
                    <div class="d-flex gap-2 justify-content-center w-100">
                        <button type="button" class="btn btn-light rounded-pill w-50 fw-bold" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="confirmDeleteBtn" class="btn btn-danger rounded-pill w-50 fw-bold">Delete</button>
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
                const items = document.querySelectorAll('.mobile-card');
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