@extends('layouts.public-layout')

@section('title', 'About Us')

<x-seo-meta 
    title="About Us | One2One4 Blood Donation"
    description="Learn about One2One4, Bangladesh's largest blood donation network operating in every upazila. Our mission is to connect blood donors with recipients to save lives across Bangladesh."
    keywords="blood donation organization, Bangladesh blood donation, One2One4 history, blood donation mission, upazila blood donation network, blood donor community"
    image="{{ asset('images/about-history.jpg') }}"
    type="organization"
/>

@push('styles')
<style>
    /* Hero Section */
    .about-hero {
        background: linear-gradient(rgba(22, 22, 48, 0.8), rgba(22, 22, 48, 0.8)), url('{{ asset('images/blood-cells-bg.jpg') }}');
        background-size: cover;
        background-position: center;
        padding: 100px 0;
        text-align: center;
        color: #fff;
        position: relative;
    }

    .about-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .about-hero p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto;
    }

    /* Mission Section */
    .mission-section {
        padding: 80px 0;
        background-color: #f8f9fa;
    }

    .mission-card {
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        height: 100%;
        transition: transform 0.3s ease;
        padding: 2rem;
    }

    .mission-card:hover {
        transform: translateY(-10px);
    }

    .mission-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .mission-icon i {
        font-size: 2rem;
        color: #fff;
    }

    .mission-card h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #161630;
    }

    .mission-card p {
        color: #6c757d;
        line-height: 1.7;
    }

    /* History Section */
    .history-section {
        padding: 80px 0;
        background-color: #fff;
    }

    .history-img {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .history-img img {
        width: 100%;
        height: auto;
        transition: transform 0.5s ease;
    }

    .history-img:hover img {
        transform: scale(1.05);
    }

    .history-content h2 {
        color: #161630;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .history-content p {
        color: #6c757d;
        line-height: 1.8;
        margin-bottom: 1.5rem;
    }

    .history-milestone {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 10px;
        margin-top: 2rem;
    }

    .milestone-year {
        font-size: 1.2rem;
        font-weight: 700;
        color: #ff5f6d;
        margin-bottom: 0.5rem;
    }

    /* Team Section */
    .team-section {
        padding: 80px 0;
        background-color: #f8f9fa;
    }

    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title h2 {
        color: #161630;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .section-title p {
        color: #6c757d;
        max-width: 700px;
        margin: 0 auto;
    }

    .team-card {
        border-radius: 15px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }

    .team-card:hover {
        transform: translateY(-10px);
    }

    .team-img {
        position: relative;
        overflow: hidden;
    }

    .team-img img {
        width: 100%;
        height: auto;
        transition: transform 0.5s ease;
    }

    .team-card:hover .team-img img {
        transform: scale(1.1);
    }

    .team-social {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(22, 22, 48, 0.7);
        padding: 15px;
        display: flex;
        justify-content: center;
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }

    .team-card:hover .team-social {
        transform: translateY(0);
    }

    .team-social a {
        color: #fff;
        margin: 0 10px;
        font-size: 1.2rem;
        transition: color 0.3s ease;
    }

    .team-social a:hover {
        color: #ff5f6d;
    }

    .team-info {
        padding: 20px;
        text-align: center;
    }

    .team-info h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #161630;
    }

    .team-info p {
        color: #ff5f6d;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .team-bio {
        color: #6c757d;
        line-height: 1.7;
    }

    /* CTA Section */
    .cta-section {
        padding: 80px 0;
        background: url('{{ asset('images/blood-donation-bg.jpg') }}');
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(22, 22, 48, 0.8);
    }

    .cta-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: #fff;
    }

    .cta-content h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .cta-content p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto 2rem auto;
    }

    .btn-donate {
        padding: 12px 30px;
        font-size: 1.1rem;
        font-weight: 600;
        text-transform: uppercase;
        border-radius: 30px;
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        border: none;
        color: #fff;
        transition: all 0.3s ease;
    }

    .btn-donate:hover {
        background: linear-gradient(135deg, #ff9966, #ff5f6d);
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(255, 95, 109, 0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .about-hero h1 {
            font-size: 2.2rem;
        }
        
        .history-content h2, .section-title h2, .cta-content h2 {
            font-size: 2rem;
        }
        
        .mission-section, .history-section, .team-section, .cta-section {
            padding: 50px 0;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="about-hero">
    <div class="container">
        <h1>{{ $aboutTitle }}</h1>
        <p>{{ $aboutDescription }}</p>
    </div>
</section>

<!-- Mission Section -->
<section class="mission-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3>{{ $missionTitle }}</h3>
                    <p>{{ $missionContent }}</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>{{ $visionTitle }}</h3>
                    <p>{{ $visionContent }}</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3>{{ $valuesTitle }}</h3>
                    <p>{{ $valuesContent }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- History Section -->
<section class="history-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="history-img">
                    <img src="{{ file_exists(public_path('images/about-history.jpg')) ? asset('images/about-history.jpg') : 'https://via.placeholder.com/800x600?text=Our+History' }}" alt="Our History">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="history-content">
                    <h2>{{ $journeyTitle }}</h2>
                    <p>{{ $journeyContent }}</p>
                    
                    @foreach($milestones as $milestone)
                    <div class="history-milestone">
                        <div class="milestone-year">{{ $milestone['year'] }}</div>
                        <p>{{ $milestone['description'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section">
    <div class="container">
        <div class="section-title">
            <h2>{{ $teamTitle }}</h2>
            <p>{{ $teamDescription }}</p>
        </div>
        
        <div class="row">
            @foreach($teamMembers as $member)
            <div class="col-md-4 mb-4">
                <div class="team-card">
                    <div class="team-img">
                        <img src="{{ file_exists(public_path($member['image'])) ? asset($member['image']) : 'https://via.placeholder.com/400x500?text=' . urlencode($member['name']) }}" alt="{{ $member['name'] }}">
                        <div class="team-social">
                            <a href="{{ $member['social']['facebook'] }}"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ $member['social']['twitter'] }}"><i class="fab fa-twitter"></i></a>
                            <a href="{{ $member['social']['linkedin'] }}"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <h3>{{ $member['name'] }}</h3>
                        <p>{{ $member['position'] }}</p>
                        <div class="team-bio">
                            <p>{{ $member['bio'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section" style="background: url('{{ file_exists(public_path('images/blood-donation-bg.jpg')) ? asset('images/blood-donation-bg.jpg') : asset('images/blood-cells-bg.jpg') }}');">
    <div class="container">
        <div class="cta-content">
            <h2>{{ $ctaTitle }}</h2>
            <p>{{ $ctaDescription }}</p>
            <a href="{{ route('register') }}" class="btn btn-donate">{{ $ctaButton }}</a>
        </div>
    </div>
</section>
@endsection 