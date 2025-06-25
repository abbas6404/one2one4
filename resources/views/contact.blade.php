@extends('layouts.public-layout')

@section('title', 'Contact Us')

@push('styles')
<style>
    /* Home Page Contact Style */
    .homepage-contact-section {
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
    
    .subtitle-accent {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 10px;
        text-transform: uppercase;
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
        z-index: 1;
    }
    
    .form-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 25px;
        color: #f5f5f5;
    }
    
    .form-floating {
        margin-bottom: 15px;
    }
    
    .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 10px;
        height: 58px;
    }
    
    .form-control:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
        color: white;
        box-shadow: 0 0 0 0.25rem rgba(165, 28, 28, 0.25);
    }
    
    .form-floating label {
        color: rgba(255, 255, 255, 0.7);
        padding-left: 15px;
    }
    
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: rgba(255, 255, 255, 0.9);
        padding-left: 10px;
    }
    
    .form-floating textarea.form-control {
        height: 150px !important;
    }
    
    .btn-send-message {
        background: linear-gradient(to right, #a51c1c, #ff6b6b);
        color: white;
        padding: 12px 25px;
        border-radius: 30px;
        font-weight: 600;
        border: none;
        position: relative;
        overflow: hidden;
        z-index: 1;
        transition: all 0.3s ease;
    }
    
    .btn-send-message:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        color: white;
    }
    
    .btn-send-message:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 0%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.5s ease;
        z-index: -1;
    }
    
    .btn-send-message:hover:before {
        width: 100%;
    }
    
    .contact-info-item {
        display: flex;
        margin-bottom: 20px;
    }
    
    /* Map section */
    .map-section {
        padding: 50px 0;
        background: #111;
    }
    
    .map-container {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        height: 400px;
    }
    
    iframe.contact-map {
        width: 100%;
        height: 100%;
        border: none;
    }
    
    @media (max-width: 768px) {
        .contact-form-wrapper {
            padding: 30px 20px;
        }
        
        .contact-info-panel {
            padding: 30px 20px;
        }
        
        .map-container {
            height: 300px;
        }
    }
</style>
@endpush

@section('content')
<!-- Contact Section -->
<section class="homepage-contact-section">
    <div class="contact-bg-overlay"></div>
    <div class="container position-relative">
        <div class="section-header text-center mb-5">
            <div class="subtitle-accent contact-accent">Get in Touch</div>
            <h2 class="contact-title">{{ $data['title'] }}</h2>
            <div class="contact-title-accent"></div>
            <p class="contact-subtitle">{{ $data['subtitle'] }}</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @include('partials.contact-form', [
                    'info_title' => $data['info_title'],
                    'info_tagline' => $data['info_tagline'],
                    'address' => $data['address'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'form_title' => $data['form_title'],
                    'button_text' => 'Send Message'
                ])
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container">
        <div class="map-container">
            {!! $data['map_iframe'] ?? '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3644.762087871815!2d90.41284827590268!3d24.004176978985377!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755db0026ea08cf%3A0x8c6e6c9fd3dfd772!2sAiO%20Innovation%20Limited!5e0!3m2!1sen!2sbd!4v1745849964158!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>' !!}
        </div>
    </div>
</section>
@endsection 