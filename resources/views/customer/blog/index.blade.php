@extends('customer.layouts.main')

@section('title', 'Our Blog')

@section('content')
<style>
    .blog-header {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset("storage/images/coffee.jpg") }}');
        background-size: cover;
        background-position: center;
        height: 300px;
        border-radius: 0 0 30px 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        margin-bottom: 3rem;
    }
    
    .blog-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        transition: 0.3s;
        height: 100%;
        background: white;
    }
    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .blog-img-wrapper {
        height: 200px;
        overflow: hidden;
        position: relative;
    }
    .blog-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.5s;
    }
    .blog-card:hover .blog-img-wrapper img {
        transform: scale(1.1);
    }
    
    .blog-category {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255,255,255,0.9);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--primary-color);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .read-more-btn {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
        font-size: 0.9rem;
        transition: 0.2s;
    }
    .read-more-btn:hover {
        color: var(--secondary-color);
        letter-spacing: 0.5px;
    }

    /* Styles untuk Pagination JS */
    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }
    .pagination .page-link {
        color: var(--text-dark);
        border: none;
        margin: 0 5px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50% !important;
        font-weight: 600;
        cursor: pointer;
    }
    .pagination .page-link:hover {
        background-color: #f0f0f0;
    }
</style>

<div class="blog-header shadow-sm">
    <div class="container">
        <span class="text-uppercase letter-spacing-2 small fw-bold mb-2 d-block text-warning">Stories & News</span>
        <h1 class="display-5 fw-bold">The Coffee Journal</h1>
        <p class="lead opacity-75">Discover the art, science, and culture of coffee.</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="blog-container">
                @foreach($blogs as $blog)
                <div class="col blog-item">
                    <div class="blog-card shadow-sm">
                        <div class="blog-img-wrapper">
                            <img src="{{ asset($blog['image']) }}" alt="{{ $blog['title'] }}">
                            <span class="blog-category">{{ $blog['category'] }}</span>
                        </div>
                        <div class="p-4 d-flex flex-column h-100">
                            <div class="text-muted small mb-2">
                                <i class="far fa-calendar-alt me-1"></i> {{ $blog['date'] }}
                            </div>
                            <h5 class="fw-bold text-dark mb-3">{{ $blog['title'] }}</h5>
                            <p class="text-muted small mb-4 flex-grow-1">{{ $blog['excerpt'] }}</p>
                            
                            <a href="#" class="read-more-btn">
                                Read Article <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="d-flex justify-content-center mt-5" id="pagination-wrapper" style="display: none;">
                <nav>
                    <ul class="pagination" id="pagination-list">
                        </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemsPerPage = 6;
        const blogContainer = document.getElementById('blog-container');
        const blogItems = document.querySelectorAll('.blog-item');
        const paginationWrapper = document.getElementById('pagination-wrapper');
        const paginationList = document.getElementById('pagination-list');
        const totalPages = Math.ceil(blogItems.length / itemsPerPage);

        function showPage(page) {
            blogItems.forEach((item, index) => {
                item.style.display = 'none';
                if (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) {
                    item.style.display = 'block';
                }
            });
            updatePagination(page);
        }

        function updatePagination(currentPage) {
            paginationList.innerHTML = '';

            const prevLi = document.createElement('li');
            prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
            prevLi.innerHTML = `<a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>`;
            prevLi.onclick = (e) => { e.preventDefault(); if(currentPage > 1) showPage(currentPage - 1); };
            paginationList.appendChild(prevLi);

            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.onclick = (e) => { e.preventDefault(); showPage(i); };
                paginationList.appendChild(li);
            }

            const nextLi = document.createElement('li');
            nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
            nextLi.innerHTML = `<a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>`;
            nextLi.onclick = (e) => { e.preventDefault(); if(currentPage < totalPages) showPage(currentPage + 1); };
            paginationList.appendChild(nextLi);
        }

        if (blogItems.length > itemsPerPage) {
            paginationWrapper.style.display = 'flex';
            showPage(1);
        } else {
            blogItems.forEach(item => item.style.display = 'block');
        }
    });
</script>
@endsection