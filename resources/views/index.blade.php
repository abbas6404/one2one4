@extends('layouts.public-layout')

@section('content')
<!-- Hero Section with Slider -->
<!-- Hero Section with Slider - All slider images are stored in public/images/slides directory -->
<section class="custom-hero-section">
    <div class="hero-background"></div>
    <div class="container position-relative">
        <div class="swiper custom-hero-swiper">
        <div class="slider-preloader">
            <div class="spinner-grow text-light" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
            <div class="swiper-wrapper">
                @foreach($hero_slides as $slide)
                <div class="swiper-slide">
                    <div class="slide-img-bg" style="background-image: url('{{ asset('images/slides/' . basename($slide['image'])) }}')"></div>
                    <div class="slide-overlay"></div>
                    <div class="slide-content">
                        <div class="slide-text-box">
                            <h2 class="slide-title">{{ $slide['title'] }}</h2>
                            <p class="slide-subtitle">{{ $slide['subtitle'] }}</p>
                            @if(isset($slide['button_text']) && !empty($slide['button_text']))
                            <div class="slide-buttons mt-4">
                                <a href="{{ $slide['button_url'] ?? '#' }}" class="btn btn-primary slide-btn">
                                    {{ $slide['button_text'] }}
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>

<!-- Enhanced Search Section with Blood Color Theme and Hierarchical Location Filters -->
<section class="search-section">
      <div class="container">
        <div class="search-box">
            <h3 class="search-title text-center mb-4">Find Blood Donors</h3>
            <form action="{{ route('donors.search') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <div class="search-input-group blood-filter">
                            <label class="filter-label"><i class="fas fa-tint me-2"></i>Blood Group</label>
                            <select class="form-select blood-select" name="blood_group">
                                <option value="">Select Blood Group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                         </select>
                     </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="search-input-group location-filter">
                            <label class="filter-label"><i class="fas fa-map-marker-alt me-2"></i>Division</label>
                            <select class="form-select location-select" name="division_id" id="division_id">
                                <option value="">Select Division</option>
                                @foreach($divisions ?? [] as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                         </select>
                     </div>
                 </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="search-input-group location-filter">
                            <label class="filter-label"><i class="fas fa-map me-2"></i>District</label>
                            <select class="form-select location-select" name="district_id" id="district_id" disabled>
                                <option value="">Select District</option>
                            </select>
             </div>
             </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="search-input-group location-filter">
                            <label class="filter-label"><i class="fas fa-street-view me-2"></i>Upazila</label>
                            <select class="form-select location-select" name="upazila_id" id="upazila_id" disabled>
                                <option value="">Select Upazila</option>
                            </select>
         </div>
     </div>
                    <div class="col-md-6">
                        <div class="search-input-group">
                            <label class="filter-label"><i class="fas fa-venus-mars me-2"></i>Gender</label>
                            <select class="form-select" name="gender">
                                <option value="">All Genders</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                 </div>
                             </div>
                    <div class="col-md-6">
                        <div class="search-input-group">
                            <label class="filter-label"><i class="fas fa-search me-2"></i>Keywords</label>
                            <input type="text" class="form-control" name="keyword" placeholder="Search by name, email, or phone...">
                             </div>
                             </div>
                    <div class="col-12 mt-4">
                        <div class="search-button-wrapper">
                            <button type="submit" class="btn custom-search-btn pulse-btn">
                                <i class="fas fa-search me-2"></i> Find Blood Donors
                            </button>
                         </div>
                         </div>
                     </div>
            </form>
                 </div>
             </div>
</section>

<!-- Donor Summary Section -->
<section class="donor-summary-section py-5">
    <div class="donor-summary-bg"></div>
    <div class="container position-relative">
        <div class="section-header">
            <h2 class="section-title-enhanced">LIVE DONOR SUMMARY</h2>
            <div class="title-accent"></div>
     </div>
     
            <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="donor-stats-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
               </div>
                    <div class="stats-content">
                        <div class="stats-number counter" data-count="{{ $total_donor }}">0</div>
                        <h4 class="stats-title">Total Donors</h4>
            </div>
                    <div class="card-wave"></div>
         </div>
                                    </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="donor-stats-card active-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-icon">
                        <i class="fas fa-hand-holding-medical"></i>
                                    </div>
                    <div class="stats-content">
                        <div class="stats-number counter" data-count="{{ $available_donor }}">0</div>
                        <h4 class="stats-title">Available Donors</h4>
                                 </div>
                    <div class="card-wave"></div>
                              </div>
                           </div>
            <div class="col-md-4">
                <div class="donor-stats-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-icon">
                        <i class="fas fa-tint"></i>
                        </div>
                    <div class="stats-content">
                        <div class="stats-number counter" data-count="{{ $total_donation }}">0</div>
                        <h4 class="stats-title">Total Donations</h4>
                     </div>
                    <div class="card-wave"></div>
                  </div>
               </div>
                                    </div>
        
        <div class="donation-message-enhanced" data-aos="zoom-in" data-aos-delay="400">
            <div class="message-content">
                <i class="fas fa-heartbeat pulse-icon"></i>
                <p>Blood donation saves lives! <strong>Join us and be a hero today.</strong></p>
                <a href="{{ route('register') }}" class="btn btn-donate mt-3">
                    <i class="fas fa-heart me-2"></i> Become a Donor
            </a>
         </div>
      </div>
        
        @if(isset($blood_groups) && count($blood_groups) > 0)
        <div class="blood-distribution-section mt-5" data-aos="fade-up" data-aos-delay="300">
            <h3 class="distribution-title">Blood Group Distribution</h3>
            <div class="blood-type-bars">
                @foreach($blood_groups as $group)
                <div class="blood-type-bar-container">
                    <div class="blood-type-label">{{ $group->blood_category }}</div>
                    <div class="blood-type-bar-wrapper">
                        <div class="blood-type-bar" style="width: {{ min(($group->total / max($total_donor, 1)) * 100, 100) }}%">
                            <span class="blood-type-value">{{ $group->total }}</span>
           </div>
       </div>
   </div>
                @endforeach
                                   </div>
                               </div>
        @endif
                           </div>
</section>

<!-- Enhanced Testimonials Section with Modern Design -->
<section class="testimonials-enhanced">
    <div class="testimonials-bg-overlay"></div>
    <div class="blood-cells-float"></div>
    <div class="container position-relative">
        <div class="section-header text-center mb-5">
            <div class="subtitle-accent">Testimonials</div>
            <h2 class="testimonial-section-title">{{ $websiteContent['site.testimonials.title'] ?? 'WHAT OUR HEROES AND SURVIVORS SAY' }}</h2>
            <div class="title-accent-bar"></div>
                                   </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="testimonial-container position-relative">
                    <div class="quote-icon">
                        <i class="fas fa-quote-left"></i>
                               </div>
                    
                    <div class="swiper testimonial-swiper">
                        <div class="swiper-wrapper">
                            @foreach($testimonials as $testimonial)
                            <div class="swiper-slide">
                                <div class="testimonial-card-enhanced">
                                    <div class="testimonial-header">
                                        <div class="author-image">
                                            <img src="{{ asset($testimonial->avatar) }}" alt="{{ $testimonial->name }}">
                                            <div class="blood-type-badge">{{ $testimonial->blood_group }}</div>
                           </div>
                                        <div class="author-details">
                                            <h4 class="author-name">{{ $testimonial->name }}</h4>
                                            <div class="author-meta">
                                                <span class="author-type">{{ $testimonial->type }}</span>
                                                <span class="location-badge"><i class="fas fa-map-marker-alt"></i> {{ $testimonial->location }}</span>
                                   </div>
                               </div>
                           </div>
                                    <div class="testimonial-content">
                                        <p class="testimonial-text">"{{ $testimonial->content }}"</p>
                                   </div>
                                    <div class="card-wave-bottom"></div>
                               </div>
                           </div>
                            @endforeach
                                   </div>
                               </div>
                    
                    <div class="testimonial-controls">
                        <div class="swiper-button-prev custom-nav-btn"></div>
                        <div class="swiper-pagination custom-pagination"></div>
                        <div class="swiper-button-next custom-nav-btn"></div>
                           </div>
                                   </div>
                               </div>
                           </div>
        
        <div class="testimonial-cta text-center mt-5">
            <a href="{{ route('register') }}" class="btn btn-share-story">
                <i class="fas fa-pencil-alt me-2"></i> Share Your Story
            </a>
                       </div>
                   </div>
</section>

<!-- Sponsors Section -->
<section class="sponsors-section py-5">
    <div class="sponsors-bg"></div>
    <div class="container position-relative">
        <div class="section-header text-center mb-5">
            <div class="subtitle-accent sponsor-accent">Our Partners</div>
            <h2 class="sponsors-title">{{ $websiteContent['site.sponsors.title'] ?? 'OUR ESTEEMED SPONSORS' }}</h2>
            <div class="sponsors-title-accent"></div>
            <p class="sponsors-subtitle">{{ $websiteContent['site.sponsors.subtitle'] ?? 'Organizations supporting our mission to save lives through blood donation' }}</p>
               </div>
        
        <div class="sponsors-container">
            <div class="swiper sponsors-swiper">
                <div class="swiper-wrapper">
                    @foreach($sponsors as $sponsor)
                    <div class="swiper-slide">
                        <div class="sponsor-item">
                            <a href="{{ $sponsor->url }}" target="_blank" class="sponsor-link">
                                <div class="sponsor-image">
                                    <img src="{{ asset($sponsor->logo) }}" alt="{{ $sponsor->name }}" class="img-fluid">
           </div>
                                <h5 class="sponsor-name">{{ $sponsor->name }}</h5>
                            </a>
                                   </div>
                               </div>
                    @endforeach
                           </div>
                <div class="swiper-pagination sponsors-pagination"></div>
                                   </div>
            <div class="swiper-button-prev sponsors-nav-prev"></div>
            <div class="swiper-button-next sponsors-nav-next"></div>
                               </div>
        
        <div class="sponsor-cta text-center mt-5">
            <a href="{{ $websiteContent['site.sponsors.cta.url'] ?? '#' }}" class="btn btn-become-sponsor">
                <i class="fas fa-handshake me-2"></i> {{ $websiteContent['site.sponsors.cta.text'] ?? 'Become a Sponsor' }}
            </a>
                           </div>
                                   </div>
</section>

<!-- Contact Section -->
<section class="contact-section py-5">
    <div class="contact-bg-overlay"></div>
    <div class="container position-relative">
        <div class="section-header text-center mb-5">
            <div class="subtitle-accent contact-accent">Get in Touch</div>
            <h2 class="contact-title">{{ $contact['title'] }}</h2>
            <div class="contact-title-accent"></div>
            <p class="contact-subtitle">{{ $contact['subtitle'] }}</p>
                               </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @include('partials.contact-form', [
                    'info_title' => $contact['info_title'],
                    'info_tagline' => $contact['info_tagline'],
                    'form_title' => $contact['form_title'],
                    'button_text' => $contact['button_text']
                ])
                           </div>
                                   </div>
                               </div>
</section>

<!-- Add CSS for this page only -->
<style>
/* Custom Hero Section */
.custom-hero-section {
    position: relative;
    height: 600px;
    overflow: hidden;
    padding: 30px 0;
    background-color: #a51c1c;
}

.slider-preloader {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 10;
    transition: opacity 0.5s ease, visibility 0.5s ease;
}

.custom-hero-swiper[style*="opacity: 1"] .slider-preloader {
    opacity: 0;
    visibility: hidden;
}

.custom-hero-section::before {
    content: '';
    position: absolute;
    top: -50px;
    left: -50px;
    width: calc(100% + 100px);
    height: calc(100% + 100px);
    background: radial-gradient(circle at center, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 60%);
    pointer-events: none;
    animation: pulse-glow 8s infinite alternate ease-in-out;
    z-index: 0;
}

@keyframes pulse-glow {
    0% {
        opacity: 0.5;
        transform: scale(0.98);
    }
    100% {
        opacity: 1;
        transform: scale(1.02);
    }
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('{{ asset('images/blood-cells-bg.png') }}');
    background-size: cover;
    background-position: center;
    background-color: #a51c1c;
    z-index: 0;
    animation: subtle-move 60s infinite alternate linear;
    filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.3)) blur(3px);
}

.hero-background::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at center, rgb(255 255 255) 0%, rgb(255 255 255 / 46%) 70%);
    pointer-events: none;
}

@keyframes subtle-move {
    0% {
        background-position: center;
    }
    100% {
        background-position: center 10%;
    }
}

.custom-hero-swiper {
    height: 540px;
    z-index: 1;
    border-radius: 15px;
    overflow: hidden;
    opacity: 0;
    transition: opacity 0.5s ease;
}

.custom-hero-swiper .swiper-slide {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    border-radius: 15px;
}

.slide-img-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    transform: scale(1.05);
    transition: transform 7s ease, filter 1s ease;
    opacity: 0.9;
    filter: blur(2px);
}

.swiper-slide-active .slide-img-bg {
    transform: scale(1);
    filter: blur(0);
}

.swiper-slide-prev .slide-img-bg,
.swiper-slide-next .slide-img-bg {
    filter: blur(3px);
}

.slide-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    z-index: 1;
    border-radius: 15px;
}

.slide-content {
    position: relative;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2;
}

.slide-text-box {
    background-color: rgba(255, 255, 255, 0.85);
    padding: 40px 50px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 0 30px rgba(255, 255, 255, 0.3), 0 5px 25px rgba(0, 0, 0, 0.15);
    max-width: 550px;
    width: 90%;
    border: 1px solid rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(10px);
    animation: slide-glow 4s infinite alternate ease-in-out;
    transition: transform 0.8s ease, opacity 0.8s ease;
}

@keyframes slide-glow {
    0% {
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.2), 0 5px 25px rgba(0, 0, 0, 0.15);
    }
    100% {
        box-shadow: 0 0 35px rgba(255, 255, 255, 0.4), 0 5px 25px rgba(0, 0, 0, 0.15);
    }
}

.slide-title {
    color: #b22222;
    font-size: 38px;
    font-weight: 700;
    margin-bottom: 15px;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.slide-subtitle {
    color: #555;
    font-size: 20px;
    line-height: 1.5;
    margin-bottom: 0;
}

.slide-buttons {
    display: flex;
    justify-content: center;
}

.slide-btn {
    background: linear-gradient(45deg, #a51c1c, #ff6b6b);
    color: white;
    font-weight: 600;
    padding: 12px 30px;
    border-radius: 30px;
    border: none;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 14px;
    box-shadow: 0 5px 15px rgba(165, 28, 28, 0.3);
}

.slide-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(165, 28, 28, 0.4);
    background: linear-gradient(45deg, #8b0000, #e93535);
    color: white;
}

.custom-hero-swiper .swiper-button-prev,
.custom-hero-swiper .swiper-button-next {
    background-color: rgba(255, 255, 255, 0.9);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    color: #666;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1), 0 0 15px rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.custom-hero-swiper .swiper-button-prev:after,
.custom-hero-swiper .swiper-button-next:after {
    font-size: 20px;
}

.custom-hero-swiper .swiper-pagination {
    bottom: 25px;
}

.custom-hero-swiper .swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    opacity: 0.7;
    background: white;
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
}

.custom-hero-swiper .swiper-pagination-bullet-active {
    background-color: #b22222;
    opacity: 1;
}

.custom-hero-swiper .swiper-button-prev:hover,
.custom-hero-swiper .swiper-button-next:hover {
    background-color: #fff;
    transform: scale(1.05);
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1), 0 0 20px rgba(255, 255, 255, 0.5);
}

/* Enhanced search section styling */
.search-section {
    padding: 60px 0;
    background-image: linear-gradient(#a51c1c, rgba(255, 245, 245, 0.9)), url('{{ asset('images/blood-cells-bg.jpg') }}');
    
    background-size: cover;
    background-position: center;
    position: relative;
}

.search-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('{{ asset('images/blood-cells-bg.jpg') }}');
    background-size: cover;
    background-position: center;
    filter: blur(5px);
    z-index: -1;
    opacity: 0.2;
}

.search-box {
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 15px 35px rgba(178, 34, 34, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(178, 34, 34, 0.1);
}

.search-title {
    color: #a51c1c;
    font-weight: 700;
    position: relative;
    padding-bottom: 15px;
    font-size: 28px;
}

.search-title:after {
    content: '';
    position: absolute;
    width: 80px;
    height: 4px;
    background: linear-gradient(to right, #a51c1c, #ff6b6b);
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 2px;
}

.filter-label {
    color: #a51c1c;
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
    font-size: 15px;
}

.search-input-group {
    margin-bottom: 5px;
}

.blood-select, 
.location-select {
    border-width: 2px;
    border-color: rgba(178, 34, 34, 0.3);
    font-weight: 500;
    color: #333;
    height: 50px;
}

.blood-select:focus, 
.location-select:focus {
    box-shadow: 0 0 0 3px rgba(178, 34, 34, 0.2);
    border-color: rgba(178, 34, 34, 0.6);
}

.form-select, .form-control {
    border-width: 1px;
    border-color: rgba(178, 34, 34, 0.2);
    font-weight: 500;
    color: #333;
    height: 50px;
    padding: 10px 15px;
}

.form-select:focus, .form-control:focus {
    box-shadow: 0 0 0 3px rgba(178, 34, 34, 0.15);
    border-color: rgba(178, 34, 34, 0.4);
}

.custom-search-btn {
    background: linear-gradient(45deg, #a51c1c, #e93535);
    color: white;
    font-weight: 600;
    padding: 15px 35px;
    border-radius: 30px;
    border: none;
    transition: all 0.3s ease;
    font-size: 18px;
    width: 100%;
    max-width: 300px;
    box-shadow: 0 8px 20px rgba(178, 34, 34, 0.25);
    position: relative;
    overflow: hidden;
}

.custom-search-btn:hover {
    background: linear-gradient(45deg, #8b0000, #c82333);
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(178, 34, 34, 0.35);
}

.pulse-btn {
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(178, 34, 34, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(178, 34, 34, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(178, 34, 34, 0);
    }
}

.search-button-wrapper {
    display: flex;
    justify-content: center;
}

/* Media Queries */
@media (max-width: 992px) {
    .search-input-group {
        min-width: 150px;
    }
}

@media (max-width: 768px) {
    .custom-hero-section {
        height: 550px;
    }
    
    .custom-hero-swiper {
        height: 490px;
    }
    
    .slide-text-box {
        padding: 25px 30px;
    }
    
    .slide-title {
        font-size: 28px;
    }
    
    .slide-subtitle {
        font-size: 16px;
    }
    
    .search-box {
        padding: 20px;
    }
    
    .search-input-group {
        flex-basis: 100%;
    }
}

@media (max-width: 576px) {
    .custom-hero-section {
        height: 480px;
    }
    
    .custom-hero-swiper {
        height: 420px;
    }
    
    .slide-text-box {
        padding: 20px 25px;
    }
    
    .slide-title {
        font-size: 24px;
    }
    
    .slide-subtitle {
        font-size: 15px;
    }
    
    .custom-search-btn {
        width: 100%;
    }
}

/* Donor Summary Section */
.section-title {
    text-align: center;
    margin-bottom: 30px;
    font-weight: 700;
    position: relative;
    color: #333;
}

.donor-summary-card {
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    color: white;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.donor-summary-card.total {
    background-color: #f44336;
}

.donor-summary-card.available {
    background-color: #4caf50;
}

.donor-summary-card.donations {
    background-color: #2196f3;
}

.donor-summary-card h3 {
    margin: 0;
    font-weight: 700;
}

.donation-message {
    background-color: #f44336;
    color: white;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    margin-top: 20px;
    font-size: 1.1rem;
}

/* Enhanced Donor Summary Section Styling */
.donor-summary-section {
    position: relative;
    padding: 80px 0;
    background-color: #f9f9f9;
    overflow: hidden;
}

.donor-summary-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('{{ asset('images/blood-cells-bg.png') }}');
    background-size: cover;
    background-position: center;
    opacity: 0.03;
    z-index: 0;
}

.section-header {
    text-align: center;
    margin-bottom: 50px;
    position: relative;
    z-index: 1;
}

.section-title-enhanced {
    font-size: 2.5rem;
    font-weight: 800;
    color: #222;
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    display: inline-block;
}

.title-accent {
    height: 5px;
    width: 80px;
    background: linear-gradient(to right, #a51c1c, #ff6b6b);
    margin: 0 auto;
    border-radius: 5px;
    position: relative;
}

.title-accent:before {
    content: '';
    position: absolute;
    width: 15px;
    height: 15px;
    background-color: #a51c1c;
    border-radius: 50%;
    top: -5px;
    left: -5px;
}

.title-accent:after {
    content: '';
    position: absolute;
    width: 15px;
    height: 15px;
    background-color: #ff6b6b;
    border-radius: 50%;
    top: -5px;
    right: -5px;
}

.donor-stats-card {
    position: relative;
    background: white;
    border-radius: 15px;
    padding: 30px 20px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    overflow: hidden;
    z-index: 1;
    height: 100%;
    min-height: 230px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    border-bottom: 5px solid #a51c1c;
}

.donor-stats-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(165, 28, 28, 0.2);
}

.donor-stats-card.active-card {
    background: linear-gradient(135deg, #a51c1c, #ff6b6b);
    color: white;
}

.card-icon {
    font-size: 40px;
    color: #a51c1c;
    margin-bottom: 15px;
    position: relative;
    z-index: 1;
}

.active-card .card-icon {
    color: white;
}

.stats-number {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 10px;
    color: #333;
    line-height: 1.1;
    background: linear-gradient(45deg, #a51c1c, #ff6b6b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.active-card .stats-number {
    background: white;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.stats-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #555;
    margin: 0;
}

.active-card .stats-title {
    color: white;
}

.card-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 20px;
    background: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="%23a51c1c" class="shape-fill"></path><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="%23a51c1c" class="shape-fill"></path><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="%23a51c1c" class="shape-fill"></path></svg>');
    background-size: cover;
    background-position: center;
    z-index: 0;
    opacity: 0.1;
}

.active-card .card-wave {
    opacity: 0.3;
}

.donation-message-enhanced {
    position: relative;
    background: linear-gradient(45deg, #a51c1c, #ff6b6b);
    color: white;
    padding: 20px 30px;
    border-radius: 15px;
    margin-top: 40px;
    box-shadow: 0 10px 30px rgba(165, 28, 28, 0.2);
    overflow: hidden;
    z-index: 1;
}

.donation-message-enhanced:before {
    content: "";
    position: absolute;
    top: -80px;
    right: -80px;
    width: 200px;
    height: 200px;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    z-index: -1;
}

.donation-message-enhanced:after {
    content: "";
    position: absolute;
    bottom: -60px;
    left: -60px;
    width: 180px;
    height: 180px;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    z-index: -1;
}

.message-content {
    position: relative;
    text-align: center;
    font-size: 1.3rem;
    line-height: 1.5;
    padding: 20px;
    z-index: 1;
}

.pulse-icon {
    font-size: 2.5rem;
    color: white;
    margin-bottom: 15px;
    display: block;
    animation: pulse-beat 1.5s infinite;
}

@keyframes pulse-beat {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

.btn-donate {
    background-color: white;
    color: #a51c1c;
    font-weight: 600;
    padding: 12px 25px;
    border-radius: 30px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.9rem;
}

.btn-donate:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    background-color: #f8f8f8;
    color: #a51c1c;
}

.blood-distribution-section {
    background-color: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

.distribution-title {
    text-align: center;
    font-size: 1.6rem;
    margin-bottom: 30px;
    color: #333;
    font-weight: 700;
}

.blood-type-bars {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.blood-type-bar-container {
    display: flex;
    align-items: center;
}

.blood-type-label {
    width: 60px;
    font-weight: 700;
    color: #a51c1c;
    font-size: 1.1rem;
    text-align: center;
}

.blood-type-bar-wrapper {
    flex: 1;
    background-color: #f5f5f5;
    height: 25px;
    border-radius: 15px;
    overflow: hidden;
    position: relative;
}

.blood-type-bar {
    height: 100%;
    background: linear-gradient(to right, #a51c1c, #ff6b6b);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding-right: 15px;
    color: white;
    font-weight: 600;
    transition: width 1.5s ease-in-out;
}

.blood-type-value {
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .section-title-enhanced {
        font-size: 2rem;
    }
    
    .stats-number {
        font-size: 3rem;
    }
    
    .stats-title {
        font-size: 1.1rem;
    }
    
    .message-content {
        font-size: 1.1rem;
    }
}

/* Enhanced Testimonials Section Styling */
.testimonials-enhanced {
    padding: 100px 0;
    position: relative;
    background-color: #15151e;
    color: #fff;
    overflow: hidden;
}

.testimonials-bg-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('{{ asset('images/testimonial-bg.jpg') }}') center/cover no-repeat;
    opacity: 0.15;
    filter: blur(2px);
    z-index: 0;
}

.blood-cells-float {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('{{ asset('images/blood-cells-bg.png') }}') center/cover no-repeat;
    opacity: 0.05;
    animation: floatBg 60s infinite alternate linear;
    z-index: 0;
}

@keyframes floatBg {
    0% {
        transform: translateY(0) scale(1);
    }
    100% {
        transform: translateY(-5%) scale(1.05);
    }
}

.subtitle-accent {
    display: inline-block;
    padding: 5px 15px;
    background: rgba(165, 28, 28, 0.2);
    color: #ff6b6b;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 15px;
    border: 1px solid rgba(165, 28, 28, 0.3);
}

.testimonial-section-title {
    font-size: 2.6rem;
    font-weight: 800;
    margin-bottom: 15px;
    color: white;
    position: relative;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.title-accent-bar {
    width: 100px;
    height: 4px;
    background: linear-gradient(to right, #a51c1c, #ff6b6b);
    margin: 0 auto;
    position: relative;
    border-radius: 2px;
}

.title-accent-bar:before, 
.title-accent-bar:after {
    content: '';
    position: absolute;
    top: 50%;
    width: 40px;
    height: 1px;
    background-color: rgba(255, 255, 255, 0.2);
}

.title-accent-bar:before {
    left: -60px;
}

.title-accent-bar:after {
    right: -60px;
}

.testimonial-container {
    padding: 20px 0;
    position: relative;
    z-index: 1;
}

.quote-icon {
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 60px;
    color: rgba(165, 28, 28, 0.2);
    z-index: -1;
}

.testimonial-card-enhanced {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    padding: 30px 25px;
    margin: 15px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}

.testimonial-card-enhanced:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(165, 28, 28, 0.3);
}

.testimonial-card-enhanced:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(to right, #a51c1c, #ff6b6b);
}

.testimonial-header {
    display: flex;
    align-items: center;
    margin-bottom: 25px;
    position: relative;
}

.author-image {
    position: relative;
    width: 75px;
    height: 75px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 20px;
    border: 3px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.author-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.testimonial-card-enhanced:hover .author-image img {
    transform: scale(1.1);
}

.blood-type-badge {
    position: absolute;
    bottom: -5px;
    right: -5px;
    width: 30px;
    height: 30px;
    background: #a51c1c;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    border: 2px solid white;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.author-details {
    flex: 1;
}

.author-name {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 5px;
    color: #fff;
}

.author-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    font-size: 13px;
}

.author-type {
    background: rgba(165, 28, 28, 0.2);
    color: #ff8c8c;
    padding: 3px 10px;
    border-radius: 12px;
    font-weight: 600;
}

.location-badge {
    color: rgba(255, 255, 255, 0.7);
    font-size: 12px;
}

.testimonial-text {
    font-size: 17px;
    line-height: 1.8;
    font-style: italic;
    color: rgba(255, 255, 255, 0.9);
    position: relative;
    z-index: 1;
}

.testimonial-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 30px;
}

.custom-nav-btn {
    width: 50px !important;
    height: 50px !important;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white !important;
    transition: all 0.3s ease;
}

.custom-nav-btn:after {
    font-size: 18px !important;
}

.custom-nav-btn:hover {
    background: rgba(165, 28, 28, 0.8);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.custom-pagination {
    position: static !important;
    width: auto !important;
    margin: 0 20px;
}

.custom-pagination .swiper-pagination-bullet {
    width: 10px;
    height: 10px;
    margin: 0 5px;
    background: rgba(255, 255, 255, 0.3);
    opacity: 1;
}

.custom-pagination .swiper-pagination-bullet-active {
    width: 30px;
    border-radius: 5px;
    background: linear-gradient(to right, #a51c1c, #ff6b6b);
}

.card-wave-bottom {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 15px;
    background: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="%23a51c1c" class="shape-fill"></path><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="%23a51c1c" class="shape-fill"></path><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="%23a51c1c" class="shape-fill"></path></svg>');
    background-size: cover;
    background-position: center;
}

.btn-share-story {
    background: linear-gradient(45deg, #a51c1c, #ff6b6b);
    color: white;
    font-weight: 600;
    padding: 12px 30px;
    border-radius: 30px;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 10px 20px rgba(165, 28, 28, 0.3);
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.btn-share-story:before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, #ff6b6b, #a51c1c);
    transition: left 0.6s ease;
    z-index: -1;
}

.btn-share-story:hover {
    color: white;
    transform: translateY(-5px);
    box-shadow: 0 15px 25px rgba(165, 28, 28, 0.4);
}

.btn-share-story:hover:before {
    left: 0;
}

@media (max-width: 768px) {
    .testimonial-section-title {
        font-size: 2rem;
    }
    
    .testimonial-card-enhanced {
        padding: 25px 20px 20px;
    }
    
    .testimonial-header {
        flex-direction: column;
        text-align: center;
    }
    
    .author-image {
        margin-right: 0;
        margin-bottom: 15px;
    }
    
    .author-meta {
        justify-content: center;
    }
    
    .testimonial-text {
        font-size: 15px;
    }
}

/* Enhanced Sponsors Section */
.sponsors-section {
    position: relative;
    padding: 80px 0;
    background-color: #f8f9fa;
    overflow: hidden;
}

.sponsors-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(165, 28, 28, 0.03) 0%, rgba(255, 255, 255, 0) 50%, rgba(165, 28, 28, 0.03) 100%);
    z-index: 0;
}

.sponsors-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #333;
    margin-bottom: 15px;
    position: relative;
    display: inline-block;
}

.sponsors-subtitle {
    font-size: 1.1rem;
    color: #666;
    max-width: 700px;
    margin: 15px auto 0;
}

.sponsor-accent {
    background: rgba(165, 28, 28, 0.1);
    color: #a51c1c;
}

.sponsors-title-accent {
    width: 100px;
    height: 3px;
    background: linear-gradient(to right, #a51c1c, #ff6b6b);
    margin: 10px auto;
    position: relative;
    border-radius: 2px;
}

.sponsors-container {
    position: relative;
    padding: 20px 50px;
    margin-top: 50px;
}

.sponsor-item {
    background-color: white;
    border-radius: 15px;
    padding: 30px 20px;
    transition: all 0.3s ease;
    height: 100%;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    text-align: center;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.sponsor-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(165, 28, 28, 0.1);
    border-color: rgba(165, 28, 28, 0.2);
}

.sponsor-item:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(to right, #a51c1c, #ff6b6b);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.sponsor-item:hover:before {
    opacity: 1;
}

.sponsor-link {
    display: block;
    text-decoration: none;
    color: inherit;
}

.sponsor-image {
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    padding: 10px;
    transition: all 0.3s ease;
}

.sponsor-image img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    filter: grayscale(100%);
    opacity: 0.8;
    transition: all 0.5s ease;
}

.sponsor-item:hover .sponsor-image img {
    filter: grayscale(0%);
    opacity: 1;
    transform: scale(1.05);
}

.sponsor-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #444;
    margin-top: 15px;
    transition: color 0.3s ease;
}

.sponsor-item:hover .sponsor-name {
    color: #a51c1c;
}

.sponsors-swiper {
    padding-bottom: 50px;
}

.sponsors-nav-prev,
.sponsors-nav-next {
    width: 40px !important;
    height: 40px !important;
    background-color: white;
    border-radius: 50%;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    color: #a51c1c !important;
    transition: all 0.3s ease;
    top: 50%;
    transform: translateY(-50%);
}

.sponsors-nav-prev:after,
.sponsors-nav-next:after {
    font-size: 18px !important;
}

.sponsors-nav-prev:hover,
.sponsors-nav-next:hover {
    background-color: #a51c1c;
    color: white !important;
}

.sponsors-pagination {
    position: absolute;
    bottom: 0 !important;
}

.sponsors-pagination .swiper-pagination-bullet {
    width: 10px;
    height: 10px;
    background: rgba(165, 28, 28, 0.3);
    opacity: 1;
}

.sponsors-pagination .swiper-pagination-bullet-active {
    width: 25px;
    border-radius: 5px;
    background: #a51c1c;
}

.btn-become-sponsor {
    background: linear-gradient(45deg, #a51c1c, #ff6b6b);
    color: white;
    font-weight: 600;
    padding: 12px 30px;
    border-radius: 30px;
    transition: all 0.3s ease;
    box-shadow: 0 8px 20px rgba(165, 28, 28, 0.2);
}

.btn-become-sponsor:hover {
    background: linear-gradient(45deg, #8b0000, #e93535);
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(165, 28, 28, 0.3);
    color: white;
}

@media (max-width: 992px) {
    .sponsors-title {
        font-size: 2rem;
    }
    
    .sponsor-image {
        height: 100px;
    }
}

@media (max-width: 768px) {
    .sponsors-container {
        padding: 20px 30px;
    }
    
    .sponsors-nav-prev {
        left: 0;
    }
    
    .sponsors-nav-next {
        right: 0;
    }
}

@media (max-width: 576px) {
    .sponsors-title {
        font-size: 1.8rem;
    }
    
    .sponsor-image {
        height: 80px;
    }
    
    .sponsors-container {
        padding: 20px 10px;
    }
}

/* Enhanced Contact Section Styling */
.contact-section {
    position: relative;
    padding: 100px 0;
    background: rgb(15, 15, 25);
    overflow: hidden;
    color: #fff;
}

.contact-bg-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('{{ asset('images/blood-cells-dark.png') }}') center/cover no-repeat;
    opacity: 0.08;
    animation: floatContactBg 60s infinite alternate linear;
    z-index: 0;
}

@keyframes floatContactBg {
    0% {
        transform: scale(1) rotate(0deg);
    }
    100% {
        transform: scale(1.1) rotate(5deg);
    }
}

.contact-accent {
    background: rgba(165, 28, 28, 0.2);
    color: #ff6b6b;
}

.contact-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 15px;
    position: relative;
    display: inline-block;
}

.contact-subtitle {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.7);
    max-width: 700px;
    margin: 15px auto 0;
}

.contact-title-accent {
    width: 100px;
    height: 3px;
    background: linear-gradient(to right, #a51c1c, #ff6b6b);
    margin: 10px auto;
    position: relative;
    border-radius: 2px;
}

.contact-card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.contact-info-panel {
    background: linear-gradient(145deg, #a51c1c, #8b0000);
    color: white;
    padding: 40px 30px;
    height: 100%;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.contact-blood-cells {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('{{ asset('images/blood-cells-bg.png') }}') center/cover no-repeat;
    opacity: 0.1;
    z-index: 0;
}

.contact-logo {
    width: 80px;
    height: 80px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.contact-logo i {
    font-size: 35px;
    color: #a51c1c;
}

.contact-info-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 10px;
    position: relative;
    z-index: 1;
}

.contact-tagline {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1rem;
    margin-bottom: 30px;
    position: relative;
    z-index: 1;
}

.contact-info-list {
    margin-bottom: 30px;
    position: relative;
    z-index: 1;
}

.contact-info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
}

.icon-box {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
}

.icon-box i {
    font-size: 18px;
    color: white;
}

.info-content h5 {
    font-size: 1rem;
    margin-bottom: 5px;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 600;
}

.info-content p {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
    margin: 0;
}

.social-links {
    display: flex;
    gap: 10px;
    margin-top: auto;
    position: relative;
    z-index: 1;
}

.social-link {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.social-link:hover {
    background: white;
    color: #a51c1c;
    transform: translateY(-3px);
}

.contact-form-wrapper {
    padding: 40px;
    position: relative;
}

.form-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 25px;
    color: #fff;
    text-align: center;
}

.form-floating {
    margin-bottom: 20px;
}

.form-floating .form-control {
    background: rgba(255, 255, 255, 0.07);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    height: calc(3.5rem + 2px);
    padding: 1rem 0.75rem;
    color: white;
    font-size: 1rem;
}

.form-floating textarea.form-control {
    height: 150px;
    resize: none;
}

.form-floating > label {
    padding: 1rem 0.75rem;
    color: rgba(255, 255, 255, 0.6);
}

.form-floating .form-control:focus {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.3);
    box-shadow: 0 0 0 0.25rem rgba(165, 28, 28, 0.25);
}

.form-floating .form-control:not(:placeholder-shown) ~ label,
.form-floating .form-control:focus ~ label {
    opacity: 0.8;
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
}

.btn-send-message {
    background: linear-gradient(45deg, #a51c1c, #ff6b6b);
    color: white;
    font-weight: 600;
    padding: 15px 35px;
    border-radius: 30px;
    transition: all 0.3s ease;
    border: none;
    width: 100%;
    font-size: 1.1rem;
    box-shadow: 0 10px 25px rgba(165, 28, 28, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-send-message:before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, #ff6b6b, #a51c1c);
    transition: all 0.6s ease;
    z-index: -1;
}

.btn-send-message:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(165, 28, 28, 0.4);
    color: white;
}

.btn-send-message:hover:before {
    left: 0;
}

.btn-send-message i,
.btn-send-message span {
    position: relative;
    z-index: 1;
}

@media (max-width: 991px) {
    .contact-section {
        padding: 80px 0;
    }
    
    .contact-title {
        font-size: 2.2rem;
    }
}

@media (max-width: 767px) {
    .contact-info-panel {
        padding: 30px 20px;
        border-radius: 15px 15px 0 0;
    }
    
    .contact-form-wrapper {
        padding: 30px 20px;
    }
    
    .form-title {
        font-size: 1.5rem;
        margin-bottom: 20px;
    }
    
    .contact-logo {
        width: 70px;
        height: 70px;
    }
    
    .contact-logo i {
        font-size: 30px;
    }
    
    .contact-info-title {
        font-size: 1.5rem;
    }
}

@media (max-width: 575px) {
    .contact-section {
        padding: 60px 0;
    }
    
    .contact-title {
        font-size: 1.8rem;
    }
    
    .contact-subtitle {
        font-size: 1rem;
    }
    
    .btn-send-message {
        padding: 12px 25px;
        font-size: 1rem;
    }
}

.contact-form-wrapper .is-invalid {
    border-color: #dc3545;
    background-image: none;
}

.contact-form-wrapper .invalid-feedback {
    color: #ff6b6b;
    font-size: 0.85rem;
    margin-top: 5px;
    font-weight: 500;
}

.alert-success {
    background-color: rgba(40, 167, 69, 0.15);
    border-color: rgba(40, 167, 69, 0.5);
    color: #fff;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
    position: relative;
}

.alert-success .btn-close {
    color: white;
    opacity: 0.8;
}

.alert-success .btn-close:hover {
    opacity: 1;
}

/* Testimonial cards for 2-column display */
.testimonial-card-enhanced {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    padding: 30px 25px;
    margin: 15px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}

.testimonial-card-enhanced:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(165, 28, 28, 0.3);
}

/* Fix for Swiper container to properly handle 2 slides */
.testimonial-swiper {
    padding-bottom: 50px;
    overflow: hidden;
    width: 100%;
}

.testimonial-swiper .swiper-wrapper {
    display: flex;
    align-items: stretch;
}

.testimonial-swiper .swiper-slide {
    height: auto;
    display: flex;
}

/* Responsive Testimonial Card Heights */
@media (max-width: 768px) {
    .testimonial-card-enhanced {
        padding: 20px;
        margin: 10px;
    }
    
    .testimonial-text {
        font-size: 14px;
    }
}
</style>

<!-- Add JS for the Sliders -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fix image paths if needed
    document.querySelectorAll('.slide-img-bg').forEach(slide => {
        const bgImage = slide.style.backgroundImage;
        if (bgImage && bgImage.includes('images/images/slides')) {
            // Fix double path if it exists
            const fixedPath = bgImage.replace('images/images/slides', 'images/slides');
            slide.style.backgroundImage = fixedPath;
        }
    });
    
    // Initialize Custom Hero Swiper
    const heroSwiper = new Swiper('.custom-hero-swiper', {
        loop: true,
        autoplay: {
            delay: 6000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.custom-hero-swiper .swiper-pagination',
            clickable: true,
            dynamicBullets: true,
        },
        navigation: {
            nextEl: '.custom-hero-swiper .swiper-button-next',
            prevEl: '.custom-hero-swiper .swiper-button-prev',
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        speed: 1200,
        grabCursor: true,
        watchSlidesProgress: true,
        mousewheelControl: true,
        keyboardControl: true,
        preloadImages: true,
        lazy: {
            loadPrevNext: true,
            loadPrevNextAmount: 2,
        },
        on: {
            init: function() {
                document.querySelector('.custom-hero-swiper').style.opacity = 1;
            },
            slideChangeTransitionStart: function() {
                const activeSlide = this.slides[this.activeIndex];
                const textBox = activeSlide.querySelector('.slide-text-box');
                if (textBox) {
                    textBox.style.transform = 'translateY(20px)';
                    textBox.style.opacity = '0';
                    setTimeout(() => {
                        textBox.style.transition = 'all 0.8s ease';
                        textBox.style.transform = 'translateY(0)';
                        textBox.style.opacity = '1';
                    }, 200);
                }
            }
        }
    });
    
    // Initialize Sponsors Swiper
    const sponsorsSwiper = new Swiper('.sponsors-swiper', {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.sponsors-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.sponsors-nav-next',
            prevEl: '.sponsors-nav-prev',
        },
        breakpoints: {
            576: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            992: {
                slidesPerView: 4,
                spaceBetween: 40,
            },
            1200: {
                slidesPerView: 5,
                spaceBetween: 40,
            }
        }
    });

    // Initialize the counter animation for donor statistics
    const counterElements = document.querySelectorAll('.counter');
    
    // Function to animate counter
    const animateCounter = (element) => {
        const target = parseInt(element.getAttribute('data-count'));
        const duration = 2000; // 2 seconds
        const step = Math.max(1, Math.floor(target / 100));
        let current = 0;
        const startTime = Date.now();
        
        const updateCounter = () => {
            const elapsedTime = Date.now() - startTime;
            const progress = Math.min(elapsedTime / duration, 1);
            
            // Using easeOutQuart easing function for smoother counting at the end
            const easeOut = 1 - Math.pow(1 - progress, 4);
            current = Math.floor(target * easeOut);
            
            element.textContent = current.toLocaleString();
            
            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target.toLocaleString();
            }
        };
        
        updateCounter();
    };
    
    // Create Intersection Observer to start animation when element is in view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });
    
    // Observe all counter elements
    counterElements.forEach(counter => {
        observer.observe(counter);
    });
    
    // Animate blood type bars when they come into view
    const bloodTypeBars = document.querySelectorAll('.blood-type-bar');
    const observerBars = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.width = entry.target.style.width;
                observerBars.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });
    
    // Initially set width to 0 then animate
    bloodTypeBars.forEach(bar => {
        const finalWidth = bar.style.width;
        bar.style.width = "0%";
        
        // Force reflow
        void bar.offsetWidth;
        
        // Set back to final width to trigger animation
        setTimeout(() => {
            bar.style.width = finalWidth;
        }, 100);
        
        observerBars.observe(bar);
    });
});
</script>

<!-- Testimonial Swiper Script - This is the only slider initialization script for testimonials -->
 <script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize testimonial swiper with 2 slides per view
    const testimonialSwiper = new Swiper('.testimonial-swiper', {
        slidesPerView: 2,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.custom-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.custom-nav-btn.swiper-button-next',
            prevEl: '.custom-nav-btn.swiper-button-prev',
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30
            }
        }
    });
    });
 </script>

@endsection


@push('scripts')
<!-- Add AJAX script for location dropdowns -->
<script>
    $(document).ready(function() {
        // When division changes
        $('#division_id').change(function() {
            let divisionId = $(this).val();
            if (divisionId) {
                // Enable district dropdown
                $('#district_id').prop('disabled', false);
                
                // Fetch districts via AJAX
                $.ajax({
                    url: '/get-districts/' + divisionId,
                    type: 'GET',
                    success: function(data) {
                        $('#district_id').empty().append('<option value="">Select District</option>');
                        $.each(data, function(key, value) {
                            $('#district_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                // Disable and reset district and upazila dropdowns
                $('#district_id').prop('disabled', true).empty().append('<option value="">Select District</option>');
                $('#upazila_id').prop('disabled', true).empty().append('<option value="">Select Upazila</option>');
            }
        });
        
        // When district changes
        $('#district_id').change(function() {
            let districtId = $(this).val();
            if (districtId) {
                // Enable upazila dropdown
                $('#upazila_id').prop('disabled', false);
                
                // Fetch upazilas via AJAX
                $.ajax({
                    url: '/get-upazilas/' + districtId,
                    type: 'GET',
                    success: function(data) {
                        $('#upazila_id').empty().append('<option value="">Select Upazila</option>');
                        $.each(data, function(key, value) {
                            $('#upazila_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                // Disable and reset upazila dropdown
                $('#upazila_id').prop('disabled', true).empty().append('<option value="">Select Upazila</option>');
            }
         });
    });
</script>
@endpush

