@forelse($galleryItems as $index => $item)
<div class="col-lg-4 col-md-6 gallery-item" data-category="{{ $item['category'] }}">
    <div class="gallery-card animate-fadeIn" style="animation-delay: {{ $loop->index * 0.1 }}s">
        <div class="gallery-img-container">
            <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}" class="gallery-img">
            <div class="gallery-overlay">
                <div class="gallery-btn" data-index="{{ $loop->index + (($galleryItems->currentPage() - 1) * $galleryItems->perPage()) }}">
                    <i class="fas fa-search-plus"></i>
                </div>
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