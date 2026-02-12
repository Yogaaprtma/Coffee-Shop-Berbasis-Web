@extends('admin.layouts.main')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
    <style>
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }

        .form-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
            overflow: hidden;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            background-color: #fcfcfc;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            background-color: #fff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(111, 78, 55, 0.1);
        }

        .upload-area {
            border: 2px dashed #e0e0e0;
            border-radius: 16px;
            background-color: #fcfcfc;
            text-align: center;
            padding: 40px 20px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }
        
        .upload-area:hover, .upload-area.dragover {
            background-color: #fffbf7;
            border-color: var(--primary-color);
        }
        
        .upload-icon {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 15px;
            transition: 0.3s;
        }
        
        .upload-area:hover .upload-icon {
            color: var(--primary-color);
            transform: scale(1.1);
        }

        .preview-container {
            position: relative;
            display: inline-block;
            margin-top: 20px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .preview-img {
            max-width: 100%;
            max-height: 250px;
            object-fit: cover;
            display: block;
        }

        .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255,255,255,0.9);
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #dc3545;
            transition: 0.2s;
        }
        .remove-btn:hover { 
            background: #fff; 
            transform: scale(1.1); 
        }

        .btn-action {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: 0.3s;
        }
        
        .btn-save {
            background: var(--primary-color);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(111, 78, 55, 0.2);
        }

        .btn-save:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn-cancel {
            background: #f1f3f5;
            color: #6c757d;
            border: none;
        }
        
        .btn-cancel:hover {
            background: #e9ecef;
            color: #495057;
        }

        .btn-back {
            width: 100%;
        }

        @media (min-width: 768px) {
            .btn-back {
                width: auto;
            }
        }
    </style>

    <div class="container-fluid p-0">
        <div class="row align-items-center mb-4 g-3">
            <div class="col-12 col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('home.admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('category.page') }}">Kategori</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Kategori</li>
                    </ol>
                </nav>
                <p class="text-muted small m-0">Perbarui informasi kategori produk ini.</p>
            </div>
            
            <div class="col-12 col-md-4 text-md-end">
                <a href="{{ route('category.page') }}" class="btn btn-sm btn-light rounded-pill px-4 py-2 shadow-sm border btn-back">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card form-card">
                    <div class="card-body p-4 p-md-5">
                        
                        <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data" id="editCategoryForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label for="nama" class="form-label fw-bold small text-uppercase text-muted">Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                    id="nama" name="nama" value="{{ old('nama', $category->nama) }}" required placeholder="Contoh: Kopi Signature">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-bold small text-uppercase text-muted">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                    id="deskripsi" name="deskripsi" rows="4" required placeholder="Jelaskan singkat tentang kategori ini...">{{ old('deskripsi', $category->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">Gambar Kategori</label>
                                
                                <div class="upload-area" id="uploadArea">
                                    <input type="file" name="gambar" id="gambarInput" accept="image/*" class="d-none" onchange="previewImage(this)">
                                    
                                    <div id="uploadPlaceholder" style="{{ $category->gambar ? 'display:none;' : '' }}">
                                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                        <h6 class="fw-bold mb-1">Klik untuk Ganti Gambar</h6>
                                        <p class="text-muted small mb-0">Biarkan kosong jika tidak ingin mengubah gambar</p>
                                    </div>

                                    <div id="previewContainer" class="preview-container" style="{{ $category->gambar ? 'display:inline-block;' : 'display:none;' }}">
                                        <img id="imagePreview" 
                                            src="{{ $category->gambar ? asset('storage/'.$category->gambar) : '#' }}" 
                                            alt="Pratinjau" class="preview-img">
                                        
                                        <button type="button" class="remove-btn shadow-sm" onclick="triggerUpload()">
                                            <i class="fas fa-pencil-alt text-dark" style="font-size: 0.8rem;"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('gambar')
                                    <div class="text-danger small mt-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-3 pt-3 border-top mt-5">
                                <button type="button" class="btn btn-action btn-cancel" onclick="window.history.back()">Batal</button>
                                <button type="submit" class="btn btn-action btn-save">
                                    <i class="fas fa-save me-2"></i> Perbarui
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Klik Area Upload untuk Memicu Input File
        document.getElementById('uploadArea').addEventListener('click', function(e) {
            // Jangan trigger jika yang diklik adalah tombol edit/hapus
            if(e.target.closest('.remove-btn')) return; 
            
            // Jika belum ada gambar (placeholder aktif), trigger input
            if(document.getElementById('uploadPlaceholder').style.display !== 'none') {
                document.getElementById('gambarInput').click();
            }
        });

        // Fungsi khusus untuk tombol pensil (Ganti Gambar)
        function triggerUpload() {
            document.getElementById('gambarInput').click();
        }

        // Logika Pratinjau Gambar
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('uploadPlaceholder').style.display = 'none';
                    document.getElementById('previewContainer').style.display = 'inline-block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Efek Drag and Drop
        const uploadArea = document.getElementById('uploadArea');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() { uploadArea.classList.add('dragover'); }
        function unhighlight() { uploadArea.classList.remove('dragover'); }

        uploadArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            document.getElementById('gambarInput').files = files;
            previewImage(document.getElementById('gambarInput'));
        }
    </script>
@endsection