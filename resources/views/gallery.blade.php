@extends('layouts.public-layout')

@section('title', 'Gallery')

@push('styles')
<style>
    /* Gallery Section */
    .gallery-section {
        padding: 80px 0;
        background-color: #f8f9fa;
        background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
    }
    
    .gallery-header {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .gallery-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #161630;
        margin-bottom: 15px;
        position: relative;
        display: inline-block;
    }
    
    .gallery-header h2:after {
        content: '';
        position: absolute;
        width: 70px;
        height: 4px;
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
    }
    
    .gallery-header p {
        font-size: 1.1rem;
        color: #6c757d;
        max-width: 700px;
        margin: 0 auto;
    }

    /* Filter Buttons */
    .gallery-filter {
        margin-bottom: 40px;
        text-align: center;
        background-color: #fff;
        padding: 15px;
        border-radius: 50px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .filter-btn {
        display: inline-block;
        background: #fff;
        color: #161630;
        font-weight: 600;
        padding: 10px 20px;
        margin: 5px;
        border-radius: 25px;
        border: none;
        cursor: pointer;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .filter-btn:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        transition: all 0.3s ease;
        z-index: -1;
        border-radius: 25px;
    }

    .filter-btn:hover {
        color: #fff;
    }

    .filter-btn:hover:before {
        width: 100%;
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        color: #fff;
        box-shadow: 0 5px 15px rgba(255, 95, 109, 0.4);
        transform: translateY(-2px);
    }

    /* Gallery Grid */
    .gallery-item {
        margin-bottom: 30px;
        overflow: hidden;
        transition: all 0.5s ease;
        opacity: 1;
        transform: scale(1);
    }

    .gallery-item.hidden {
        opacity: 0;
        transform: scale(0.8);
        height: 0;
        margin: 0;
        padding: 0;
    }

    .gallery-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        background: #fff;
        height: 100%;
        transition: all 0.3s ease;
        position: relative;
        transform: translateY(0);
    }

    .gallery-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .gallery-img-container {
        position: relative;
        overflow: hidden;
        height: 250px;
    }

    .gallery-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .gallery-card:hover .gallery-img {
        transform: scale(1.1);
    }

    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(22, 22, 48, 0.2), rgba(22, 22, 48, 0.7));
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #fff;
        color: #161630;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        margin: 0 5px;
        cursor: pointer;
        transform: translateY(20px);
        opacity: 0;
    }

    .gallery-card:hover .gallery-btn {
        transform: translateY(0);
        opacity: 1;
        transition-delay: 0.1s;
    }

    .gallery-btn:hover {
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        color: #fff;
        box-shadow: 0 5px 15px rgba(255, 95, 109, 0.4);
    }

    .gallery-info {
        padding: 25px;
        position: relative;
    }

    .gallery-category {
        display: inline-block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        padding: 5px 15px;
        border-radius: 20px;
        margin-bottom: 12px;
        box-shadow: 0 3px 10px rgba(255, 95, 109, 0.2);
        position: relative;
        top: -15px;
    }

    .gallery-title {
        color: #161630;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .gallery-desc {
        color: #6c757d;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.6;
    }

    .gallery-date {
        color: #6c757d;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        padding-top: 10px;
        border-top: 1px solid rgba(0,0,0,0.05);
    }

    .gallery-date i {
        color: #ff5f6d;
        margin-right: 7px;
    }

    /* Pagination */
    .pagination-container {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }

    .page-item.active .page-link {
        background-color: #ff5f6d;
        border-color: #ff5f6d;
    }

    .page-link {
        color: #161630;
        border-radius: 5px;
        margin: 0 3px;
    }

    .page-link:hover {
        color: #ff5f6d;
    }

    /* Lightbox */
    .lightbox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1050;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }

    .lightbox.active {
        opacity: 1;
        visibility: visible;
    }

    .lightbox-content {
        max-width: 80%;
        max-height: 80%;
        position: relative;
        display: flex;
        flex-direction: column;
        transform: scale(0.9);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .lightbox.active .lightbox-content {
        transform: scale(1);
        opacity: 1;
    }

    .lightbox-img {
        max-width: 100%;
        max-height: 70vh;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .lightbox-info {
        color: #fff;
        margin-top: 20px;
        text-align: center;
        background: rgba(22, 22, 48, 0.7);
        border-radius: 8px;
        padding: 20px;
        backdrop-filter: blur(10px);
    }

    .lightbox-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #fff;
    }

    .lightbox-desc {
        font-size: 1rem;
        margin-bottom: 10px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.9);
    }

    .lightbox-date {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .lightbox-date i {
        margin-right: 5px;
        color: #ff5f6d;
    }

    .lightbox-close {
        position: absolute;
        top: -40px;
        right: 0;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: #fff;
        font-size: 24px;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-close:hover {
        color: #fff;
        background: #ff5f6d;
        transform: rotate(90deg);
    }

    .lightbox-prev,
    .lightbox-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: #fff;
        font-size: 20px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-prev {
        left: -70px;
    }

    .lightbox-next {
        right: -70px;
    }

    .lightbox-prev:hover,
    .lightbox-next:hover {
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        transform: scale(1.1);
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.5s ease forwards;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .gallery-img-container {
            height: 220px;
        }
        
        .gallery-header h2 {
            font-size: 2.2rem;
        }
    }

    @media (max-width: 768px) {
        .gallery-filter {
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 15px;
            text-align: left;
            padding: 12px;
            border-radius: 15px;
        }
        
        .filter-btn {
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .lightbox-content {
            max-width: 95%;
        }
        
        .lightbox-info {
            padding: 15px;
        }
        
        .lightbox-title {
            font-size: 1.3rem;
        }

        .lightbox-prev {
            left: 15px;
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.5);
        }

        .lightbox-next {
            right: 15px;
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.5);
        }
    }

    @media (max-width: 576px) {
        .gallery-section {
            padding: 50px 0;
        }
        
        .gallery-header h2 {
            font-size: 1.8rem;
        }
        
        .gallery-header p {
            font-size: 1rem;
        }
        
        .gallery-img-container {
            height: 200px;
        }
        
        .lightbox-title {
            font-size: 1.1rem;
        }
        
        .lightbox-desc {
            font-size: 0.9rem;
        }
    }

    /* Loading state */
    #gallery-grid.loading {
        position: relative;
        min-height: 300px;
    }
    
    #gallery-grid.loading::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7);
        z-index: 1;
    }
    
    #gallery-grid.loading::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #ff5f6d;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        z-index: 2;
    }
    
    @keyframes spin {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }
</style>
@endpush

@section('content')
<!-- Gallery Section -->
<section class="gallery-section">
    <div class="container">
        <!-- Gallery Header -->
        <div class="gallery-header">
            <h2>{{ $galleryTitle }}</h2>
            <p>{{ $galleryDescription }}</p>
        </div>
        
        <!-- Filter Buttons -->
        <div class="gallery-filter">
            @foreach($categories as $key => $name)
            <button class="filter-btn {{ $key == 'all' ? 'active' : '' }}" data-filter="{{ $key }}">{{ $name }}</button>
            @endforeach
        </div>

        <!-- Gallery Grid -->
        <div class="row" id="gallery-grid">
            @forelse($galleryItems as $index => $item)
            <div class="col-lg-4 col-md-6 gallery-item" data-category="{{ $item['category'] }}">
                <div class="gallery-card animate-fadeIn" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="gallery-img-container">
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}" class="gallery-img">
                        <div class="gallery-overlay">
                           
                            <a href="{{ route('gallery.show', $item['slug']) }}" class="gallery-btn ms-2">
                                <i class="fas fa-link"></i>
                            </a>
                        </div>
                    </div>
                    <div class="gallery-info">
                        <div class="gallery-category">{{ $categories[$item['category']] }}</div>
                        <h3 class="gallery-title">
                            <a href="{{ route('gallery.show', $item['slug']) }}" class="text-decoration-none text-dark">{{ $item['title'] }}</a>
                        </h3>
                        <p class="gallery-desc">{{ $item['description'] }}</p>
                        <div class="gallery-date">
                            <i class="far fa-calendar-alt"></i>
                            <span>{{ \Carbon\Carbon::parse($item['date'])->format('F d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <div class="alert alert-info py-4">
                    <i class="fas fa-image fa-2x mb-3"></i>
                    <h4>No gallery items found</h4>
                    <p>We're working on adding new photos. Please check back later.</p>
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="pagination-container">
            {{ $galleryItems->withQueryString()->links() }}
        </div>
    </div>
</section>

<!-- Lightbox -->
<div class="lightbox" id="lightbox">
    <div class="lightbox-content">
        <button class="lightbox-close" id="lightbox-close">
            <i class="fas fa-times"></i>
        </button>
        <img src="" alt="" class="lightbox-img" id="lightbox-img">
        <div class="lightbox-info">
            <h3 class="lightbox-title" id="lightbox-title"></h3>
            <p class="lightbox-desc" id="lightbox-desc"></p>
            <div class="lightbox-date" id="lightbox-date">
                <i class="far fa-calendar-alt"></i>
                <span id="lightbox-date-text"></span>
            </div>
        </div>
        <button class="lightbox-prev" id="lightbox-prev">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="lightbox-next" id="lightbox-next">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Gallery Filtering
        $('.filter-btn').click(function() {
            // Update active button
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            
            // Get filter value
            var filterValue = $(this).data('filter');
            
            // Show loading state
            $('#gallery-grid').addClass('loading');
            
            // Fetch filtered items via AJAX
            $.ajax({
                url: '{{ route("gallery.filter") }}/' + filterValue,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Update gallery grid with new items
                    $('#gallery-grid').html(response.html);
                    
                    // Initialize animations
                    animateItems();
                    
                    // Remove loading state
                    $('#gallery-grid').removeClass('loading');
                },
                error: function() {
                    // If AJAX fails, do client-side filtering
                    if (filterValue === 'all') {
                        $('.gallery-item').removeClass('hidden');
                    } else {
                        $('.gallery-item').each(function() {
                            if ($(this).data('category') === filterValue) {
                                $(this).removeClass('hidden');
                            } else {
                                $(this).addClass('hidden');
                            }
                        });
                    }
                    
                    // Animate items
                    animateItems();
                    
                    // Remove loading state
                    $('#gallery-grid').removeClass('loading');
                }
            });
        });
        
        // Animate items on filter
        function animateItems() {
            $('.gallery-item:not(.hidden)').each(function(index) {
                var $this = $(this);
                setTimeout(function() {
                    $this.find('.gallery-card').css({
                        'animation': 'fadeIn 0.5s ease forwards',
                        'animation-delay': index * 0.1 + 's'
                    });
                }, 50);
            });
        }
        
        // Lightbox
        var galleryItems = @json($galleryItems);
        var currentIndex = 0;
        
        // Open lightbox
        $('.gallery-btn').click(function() {
            currentIndex = $(this).data('index');
            updateLightbox();
            $('#lightbox').addClass('active');
            $('body').css('overflow', 'hidden');
        });
        
        // Close lightbox
        $('#lightbox-close').click(function() {
            $('#lightbox').removeClass('active');
            $('body').css('overflow', 'auto');
        });
        
        // Click outside to close
        $('#lightbox').click(function(e) {
            if (e.target === this) {
                $('#lightbox').removeClass('active');
                $('body').css('overflow', 'auto');
            }
        });
        
        // Previous image
        $('#lightbox-prev').click(function(e) {
            e.stopPropagation();
            currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
            updateLightbox();
        });
        
        // Next image
        $('#lightbox-next').click(function(e) {
            e.stopPropagation();
            currentIndex = (currentIndex + 1) % galleryItems.length;
            updateLightbox();
        });
        
        // Update lightbox content
        function updateLightbox() {
            var item = galleryItems[currentIndex];
            
            // Preload image and fade in
            var img = new Image();
            img.src = '{{ asset("") }}' + item.image;
            
            img.onload = function() {
                $('#lightbox-img').fadeOut(200, function() {
                    $('#lightbox-img').attr('src', '{{ asset("") }}' + item.image).fadeIn(200);
                });
                
                $('#lightbox-title').text(item.title);
                $('#lightbox-desc').text(item.description);
                
                // Format date
                var date = new Date(item.date);
                var formattedDate = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                $('#lightbox-date-text').text(formattedDate);
            };
        }
        
        // Keyboard navigation
        $(document).keydown(function(e) {
            if ($('#lightbox').hasClass('active')) {
                if (e.key === 'Escape') {
                    $('#lightbox').removeClass('active');
                    $('body').css('overflow', 'auto');
                } else if (e.key === 'ArrowLeft') {
                    currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
                    updateLightbox();
                } else if (e.key === 'ArrowRight') {
                    currentIndex = (currentIndex + 1) % galleryItems.length;
                    updateLightbox();
                }
            }
        });
        
        // Initialize animations
        animateItems();
    });
</script>
@endpush 