@extends('layouts.public-layout')

@section('title', $gallery->title . ' - Gallery')

@push('styles')
<style>
    /* Gallery Detail Section */
    .gallery-detail {
        padding: 80px 0;
        background-color: #f8f9fa;
        background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
    }
    
    .breadcrumb-container {
        margin-bottom: 30px;
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }
    
    .breadcrumb-item a {
        color: #161630;
        transition: all 0.3s ease;
    }
    
    .breadcrumb-item a:hover {
        color: #ff5f6d;
        text-decoration: none;
    }
    
    .gallery-detail-header {
        margin-bottom: 40px;
    }
    
    .gallery-detail-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #161630;
        margin-bottom: 15px;
    }
    
    .gallery-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    
    .gallery-category {
        display: inline-block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        padding: 5px 15px;
        border-radius: 20px;
        margin-right: 15px;
        box-shadow: 0 3px 10px rgba(255, 95, 109, 0.2);
    }
    
    .gallery-date {
        color: #6c757d;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
    }
    
    .gallery-date i {
        color: #ff5f6d;
        margin-right: 7px;
    }
    
    .gallery-detail-desc {
        color: #6c757d;
        line-height: 1.7;
        margin-bottom: 30px;
        font-size: 1.1rem;
    }
    
    /* Gallery Description Section */
    .gallery-description-section {
        background-color: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-top: 30px;
    }
    
    .description-title {
        color: #161630;
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 15px;
        position: relative;
        padding-bottom: 12px;
    }
    
    .description-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        border-radius: 2px;
    }
    
    /* Main Gallery Display */
    .gallery-main-image {
        margin-bottom: 20px;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        height: 500px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .gallery-main-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.5s ease;
    }
    
    /* Thumbnails */
    .gallery-thumbnails {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -5px;
    }
    
    .gallery-thumbnail {
        width: calc(20% - 10px);
        margin: 0 5px 10px;
        height: 100px;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        position: relative;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }
    
    .gallery-thumbnail:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    
    .gallery-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }
    
    .gallery-thumbnail.active {
        border: 3px solid #ff5f6d;
    }
    
    .gallery-thumbnail.active:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 95, 109, 0.2);
    }
    
    /* Navigation Arrows */
    .gallery-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.8);
        color: #161630;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10;
        opacity: 0;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .gallery-main-image:hover .gallery-nav {
        opacity: 1;
    }
    
    .gallery-nav:hover {
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        color: #fff;
    }
    
    .gallery-nav-prev {
        left: 20px;
    }
    
    .gallery-nav-next {
        right: 20px;
    }
    
    /* Related Galleries */
    .related-galleries {
        margin-top: 60px;
    }
    
    .section-heading {
        font-size: 1.8rem;
        font-weight: 700;
        color: #161630;
        margin-bottom: 25px;
        position: relative;
        display: inline-block;
    }
    
    .section-heading:after {
        content: '';
        position: absolute;
        width: 60px;
        height: 4px;
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        bottom: -10px;
        left: 0;
        border-radius: 2px;
    }
    
    .related-gallery-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        background: #fff;
        height: 100%;
        transition: all 0.3s ease;
    }
    
    .related-gallery-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .related-gallery-img-container {
        position: relative;
        overflow: hidden;
        height: 200px;
    }
    
    .related-gallery-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .related-gallery-card:hover .related-gallery-img {
        transform: scale(1.1);
    }
    
    .related-gallery-overlay {
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
    
    .related-gallery-card:hover .related-gallery-overlay {
        opacity: 1;
    }
    
    .related-gallery-btn {
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
    
    .related-gallery-card:hover .related-gallery-btn {
        transform: translateY(0);
        opacity: 1;
        transition-delay: 0.1s;
    }
    
    .related-gallery-btn:hover {
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        color: #fff;
        box-shadow: 0 5px 15px rgba(255, 95, 109, 0.4);
    }
    
    .related-gallery-info {
        padding: 20px;
    }
    
    .related-gallery-category {
        display: inline-block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        padding: 4px 12px;
        border-radius: 15px;
        margin-bottom: 10px;
    }
    
    .related-gallery-title {
        color: #161630;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .gallery-main-image {
            height: 400px;
        }
        
        .gallery-detail-title {
            font-size: 1.8rem;
        }
    }
    
    @media (max-width: 767px) {
        .gallery-detail {
            padding: 50px 0;
        }
        
        .gallery-thumbnail {
            width: calc(33.333% - 10px);
            height: 80px;
        }
        
        .gallery-main-image {
            height: 350px;
        }
        
        .gallery-nav {
            width: 40px;
            height: 40px;
            opacity: 1;
        }
    }
    
    @media (max-width: 576px) {
        .gallery-detail-title {
            font-size: 1.5rem;
        }
        
        .gallery-thumbnail {
            width: calc(50% - 10px);
            height: 70px;
        }
        
        .gallery-main-image {
            height: 300px;
        }
        
        .section-heading {
            font-size: 1.5rem;
        }
    }

    /* Fullscreen Modal */
    .gallery-fullscreen-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .gallery-fullscreen-modal.active {
        opacity: 1;
        visibility: visible;
    }
    
    .fullscreen-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
    }
    
    .fullscreen-img {
        max-width: 100%;
        max-height: 80vh;
        object-fit: contain;
        border-radius: 5px;
    }
    
    .fullscreen-close {
        position: absolute;
        top: -50px;
        right: 0;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: #fff;
        font-size: 24px;
        cursor: pointer;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .fullscreen-close:hover {
        background: #ff5f6d;
        transform: rotate(90deg);
    }
    
    .fullscreen-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .fullscreen-nav:hover {
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
    }
    
    .fullscreen-prev {
        left: -80px;
    }
    
    .fullscreen-next {
        right: -80px;
    }
    
    @media (max-width: 767px) {
        .fullscreen-nav {
            width: 40px;
            height: 40px;
        }
        
        .fullscreen-prev {
            left: 20px;
        }
        
        .fullscreen-next {
            right: 20px;
        }
    }
</style>
@endpush

@section('content')
<!-- Gallery Detail Section -->
<section class="gallery-detail">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb-container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('gallery') }}">{{ $galleryTitle }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $gallery->title }}</li>
                </ol>
            </nav>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Gallery Header -->
                <div class="gallery-detail-header">
                    <h1 class="gallery-detail-title">{{ $gallery->title }}</h1>
                    <div class="gallery-meta">
                        <div class="gallery-category">{{ $gallery->category->name }}</div>
                        <div class="gallery-date">
                            <i class="far fa-calendar-alt"></i>
                            <span>{{ $gallery->created_at->format('F d, Y') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Main Gallery Display -->
                <div class="gallery-main-image">
                    <img src="{{ asset($allImages[0]['image']) }}" alt="{{ $gallery->title }}" class="gallery-main-img" id="gallery-main-img">
                    <div class="gallery-nav gallery-nav-prev" id="gallery-nav-prev">
                        <i class="fas fa-chevron-left"></i>
                    </div>
                    <div class="gallery-nav gallery-nav-next" id="gallery-nav-next">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                
                <!-- Thumbnails -->
                <div class="gallery-thumbnails">
                    @foreach($allImages as $index => $image)
                    <div class="gallery-thumbnail {{ $index == 0 ? 'active' : '' }}" data-index="{{ $index }}">
                        <img src="{{ asset($image['image']) }}" alt="Thumbnail {{ $index + 1 }}">
                    </div>
                    @endforeach
                </div>
                
                <!-- Gallery Description -->
                <div class="gallery-description-section mt-4">
                    <h4 class="description-title">About This Gallery</h4>
                    <p class="gallery-detail-desc">{{ $gallery->description }}</p>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Related Information or Sidebar Content -->
                <div class="card mb-4">
                    <div class="card-header" style="background: linear-gradient(135deg, #ff5f6d, #ff9966); color: white;">
                        <h5 class="mb-0">Categories</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($categories as $slug => $name)
                            <li class="list-group-item d-flex justify-content-between align-items-center {{ $gallery->category->slug == $slug ? 'active' : '' }}">
                                <a href="{{ route('gallery.filter', $slug) }}" class="text-decoration-none text-dark">{{ $name }}</a>
                                @if($gallery->category->slug == $slug)
                                <span class="badge badge-primary" style="background: linear-gradient(135deg, #ff5f6d, #ff9966);">Current</span>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header" style="background: linear-gradient(135deg, #ff5f6d, #ff9966); color: white;">
                        <h5 class="mb-0">Share This Gallery</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-around">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('gallery.show', $gallery->slug)) }}" target="_blank" class="btn btn-outline-dark btn-sm" title="Share on Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('gallery.show', $gallery->slug)) }}&text={{ urlencode($gallery->title) }}" target="_blank" class="btn btn-outline-dark btn-sm" title="Share on Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($gallery->title . ' - ' . route('gallery.show', $gallery->slug)) }}" target="_blank" class="btn btn-outline-dark btn-sm" title="Share on WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="mailto:?subject={{ urlencode($gallery->title) }}&body={{ urlencode('Check out this gallery: ' . route('gallery.show', $gallery->slug)) }}" class="btn btn-outline-dark btn-sm" title="Share via Email">
                                <i class="far fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Galleries -->
        @if($relatedGalleries->isNotEmpty())
        <div class="related-galleries">
            <h2 class="section-heading">Related Galleries</h2>
            <div class="row">
                @foreach($relatedGalleries as $relatedGallery)
                <div class="col-md-4 mb-4">
                    <div class="related-gallery-card">
                        <div class="related-gallery-img-container">
                            <img src="{{ asset($relatedGallery->image) }}" alt="{{ $relatedGallery->title }}" class="related-gallery-img">
                            <div class="related-gallery-overlay">
                                <a href="{{ route('gallery.show', $relatedGallery->slug) }}" class="related-gallery-btn">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        </div>
                        <div class="related-gallery-info">
                            <div class="related-gallery-category">{{ $relatedGallery->category->name }}</div>
                            <h3 class="related-gallery-title">
                                <a href="{{ route('gallery.show', $relatedGallery->slug) }}" class="text-decoration-none text-dark">
                                    {{ $relatedGallery->title }}
                                </a>
                            </h3>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Fullscreen Modal -->
<div class="gallery-fullscreen-modal" id="fullscreen-modal">
    <div class="fullscreen-content">
        <button class="fullscreen-close" id="fullscreen-close">
            <i class="fas fa-times"></i>
        </button>
        <img src="" alt="" class="fullscreen-img" id="fullscreen-img">
        <button class="fullscreen-nav fullscreen-prev" id="fullscreen-prev">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="fullscreen-nav fullscreen-next" id="fullscreen-next">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var galleryImages = @json($allImages);
        var currentIndex = 0;
        
        // Thumbnail click
        $('.gallery-thumbnail').click(function() {
            var index = $(this).data('index');
            updateMainImage(index);
        });
        
        // Main image navigation
        $('#gallery-nav-prev').click(function() {
            navigate(-1);
        });
        
        $('#gallery-nav-next').click(function() {
            navigate(1);
        });
        
        // Update main image
        function updateMainImage(index) {
            currentIndex = index;
            
            // Update main image
            $('#gallery-main-img').fadeOut(200, function() {
                $(this).attr('src', '{{ asset("") }}' + galleryImages[index].image).fadeIn(200);
            });
            
            // Update active thumbnail
            $('.gallery-thumbnail').removeClass('active');
            $('.gallery-thumbnail[data-index="' + index + '"]').addClass('active');
        }
        
        // Navigate through images
        function navigate(step) {
            var newIndex = (currentIndex + step + galleryImages.length) % galleryImages.length;
            updateMainImage(newIndex);
        }
        
        // Fullscreen modal
        var fullscreenIndex = 0;
        
        // Open fullscreen
        $('#gallery-main-img').click(function() {
            fullscreenIndex = currentIndex;
            updateFullscreenImage();
            $('#fullscreen-modal').addClass('active');
            $('body').css('overflow', 'hidden');
        });
        
        // Close fullscreen
        $('#fullscreen-close').click(function() {
            $('#fullscreen-modal').removeClass('active');
            $('body').css('overflow', 'auto');
        });
        
        // Click outside to close
        $('#fullscreen-modal').click(function(e) {
            if (e.target === this) {
                $('#fullscreen-modal').removeClass('active');
                $('body').css('overflow', 'auto');
            }
        });
        
        // Fullscreen navigation
        $('#fullscreen-prev').click(function(e) {
            e.stopPropagation();
            fullscreenNavigate(-1);
        });
        
        $('#fullscreen-next').click(function(e) {
            e.stopPropagation();
            fullscreenNavigate(1);
        });
        
        // Update fullscreen image
        function updateFullscreenImage() {
            $('#fullscreen-img').attr('src', '{{ asset("") }}' + galleryImages[fullscreenIndex].image);
        }
        
        // Navigate fullscreen images
        function fullscreenNavigate(step) {
            fullscreenIndex = (fullscreenIndex + step + galleryImages.length) % galleryImages.length;
            updateFullscreenImage();
        }
        
        // Keyboard navigation
        $(document).keydown(function(e) {
            if ($('#fullscreen-modal').hasClass('active')) {
                if (e.key === 'Escape') {
                    $('#fullscreen-modal').removeClass('active');
                    $('body').css('overflow', 'auto');
                } else if (e.key === 'ArrowLeft') {
                    fullscreenNavigate(-1);
                } else if (e.key === 'ArrowRight') {
                    fullscreenNavigate(1);
                }
            } else {
                if (e.key === 'ArrowLeft') {
                    navigate(-1);
                } else if (e.key === 'ArrowRight') {
                    navigate(1);
                }
            }
        });
    });
</script>
@endpush 