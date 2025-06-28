<!-- filepath: c:\xampp\htdocs\one2one4\resources\views\auth\login.blade.php -->
@extends('layouts.public-layout')

@section('title', 'Login')

@push('styles')
<style>
    .login-section {
        min-height: calc(100vh - 200px);
        padding: 80px 0;
        background: linear-gradient(135deg, rgba(249, 249, 255, 0.9), rgba(252, 243, 243, 0.9));
    }
    
    .login-container {
        display: flex;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        background: #fff;
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .login-image {
        flex: 1;
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('{{ asset('images/blood-donation-bg.jpg') }}');
        background-size: cover;
        background-position: center;
        position: relative;
        min-height: 600px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 40px;
        color: #fff;
    }
    
    .login-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(165, 28, 28, 0.7));
        z-index: 1;
    }
    
    .login-image-content {
        position: relative;
        z-index: 2;
    }
    
    .login-image-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 16px;
    }
    
    .login-image-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 30px;
        line-height: 1.6;
    }
    
    .login-benefits {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .login-benefits-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .login-benefits-icon {
        width: 30px;
        height: 30px;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    
    .login-benefits-text {
        font-size: 1rem;
        font-weight: 500;
    }
    
    .login-form-container {
        flex: 1;
        padding: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .login-form-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .login-logo {
        margin-bottom: 20px;
    }
    
    .login-form-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }
    
    .login-form-subtitle {
        font-size: 1rem;
        color: #777;
    }
    
    .login-form-group {
        margin-bottom: 20px;
    }
    
    .login-form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }
    
    .login-form-input {
        width: 100%;
        padding: 15px 20px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }
    
    .login-form-input:focus {
        border-color: #a51c1c;
        box-shadow: 0 0 0 3px rgba(165, 28, 28, 0.1);
        background-color: #fff;
        outline: none;
    }
    
    .login-form-input.is-invalid {
        border-color: #dc3545;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    
    .login-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    
    .login-remember {
        display: flex;
        align-items: center;
    }
    
    .login-remember-checkbox {
        margin-right: 8px;
        width: 18px;
        height: 18px;
        accent-color: #a51c1c;
    }
    
    .login-remember-label {
        font-size: 0.9rem;
        color: #555;
    }
    
    .login-forgot-link {
        font-size: 0.9rem;
        color: #a51c1c;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .login-forgot-link:hover {
        color: #7a1515;
        text-decoration: underline;
    }
    
    .login-button {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #a51c1c, #d13030);
        border: none;
        border-radius: 10px;
        color: #fff;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    
    .login-button:hover {
        background: linear-gradient(135deg, #901919, #b52929);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(165, 28, 28, 0.2);
    }
    
    .login-register {
        text-align: center;
        margin-top: 10px;
    }
    
    .login-register-text {
        color: #666;
        font-size: 0.95rem;
    }
    
    .login-register-link {
        color: #a51c1c;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }
    
    .login-register-link:hover {
        color: #7a1515;
        text-decoration: underline;
    }
    
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 5px;
        font-size: 0.875em;
        color: #dc3545;
    }
    
    .or-divider {
        display: flex;
        align-items: center;
        margin: 20px 0;
        color: #777;
    }
    
    .or-divider::before,
    .or-divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background-color: #e0e0e0;
    }
    
    .or-divider::before {
        margin-right: 15px;
    }
    
    .or-divider::after {
        margin-left: 15px;
    }
    
    .social-login {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .social-login-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 1px solid #e0e0e0;
        background-color: #fff;
        color: #555;
        transition: all 0.3s ease;
    }
    
    .social-login-button:hover {
        background-color: #f5f5f5;
        transform: translateY(-2px);
    }
    
    .social-login-button.facebook {
        color: #3b5998;
    }
    
    .social-login-button.google {
        color: #db4437;
    }
    
    .social-login-button i {
        font-size: 20px;
    }
    
    .password-toggle-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #777;
        transition: color 0.3s ease;
        z-index: 10;
    }
    
    .password-toggle-icon:hover {
        color: #a51c1c;
    }
    
    .input-icon-container {
        position: relative;
    }
    
    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #777;
        z-index: 10;
    }
    
    .input-with-icon {
        padding-left: 45px;
    }
    
    @media (max-width: 992px) {
        .login-container {
            flex-direction: column;
            max-width: 500px;
        }
        
        .login-image {
            min-height: 300px;
        }
    }
    
    @media (max-width: 576px) {
        .login-form-container {
            padding: 30px 20px;
        }
        
        .login-image {
            min-height: 200px;
            padding: 30px 20px;
        }
        
        .login-image-title {
            font-size: 1.8rem;
        }
        
        .login-benefits {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<section class="login-section">
    <div class="container">
        <div class="login-container">
            <div class="login-image">
                <div class="login-image-overlay"></div>
                <div class="login-image-content">
                    <img src="{{ asset('images/loginPage/loign_page_img.png') }}" alt="Blood Donation" class="img-fluid">

                    <h1 class="login-image-title">Welcome Back</h1>
                    <p class="login-image-subtitle">Log in to continue your journey of saving lives through blood donation.</p>
                    
                    <ul class="login-benefits">
                        <li class="login-benefits-item">
                            <div class="login-benefits-icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <span class="login-benefits-text">Update your donor profile</span>
                        </li>
                        <li class="login-benefits-item">
                            <div class="login-benefits-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <span class="login-benefits-text">Track your donation history</span>
                        </li>
                        <li class="login-benefits-item">
                            <div class="login-benefits-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <span class="login-benefits-text">Receive blood request notifications</span>
                        </li>
                        <li class="login-benefits-item">
                            <div class="login-benefits-icon">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                            <span class="login-benefits-text">Connect with other donors</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="login-form-container">
                <div class="login-form-header">
                    <div class="login-logo">
                        <i class="fas fa-hand-holding-medical fa-3x" style="color: #a51c1c;"></i>
                    </div>
                    <h2 class="login-form-title">Sign in to your account</h2>
                    <p class="login-form-subtitle">Enter your credentials to access your account</p>
                </div>

                    @if(session('status'))
                    <div class="alert alert-success mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                    <div class="login-form-group">
                        <label for="email" class="login-form-label">Email Address</label>
                        <div class="input-icon-container">
                            <input id="email" type="email" class="login-form-input input-with-icon @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    <div class="login-form-group">
                        <label for="password" class="login-form-label">Password</label>
                        <div class="input-icon-container">
                            <input id="password" type="password" class="login-form-input input-with-icon @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                            <i class="fas fa-lock input-icon"></i>
                            <span class="password-toggle-icon">
                                <i class="fas fa-eye" id="togglePassword"></i>
                            </span>
                        </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    <div class="login-options">
                        <div class="login-remember">
                            <input class="login-remember-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="login-remember-label" for="remember">Remember me</label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="login-forgot-link" href="{{ route('password.request') }}">
                                Forgot your password?
                            </a>
                        @endif
                    </div>
                    
                    <button type="submit" class="login-button">
                        <i class="fas fa-sign-in-alt mr-2"></i> Log In
                            </button>
                    
                    <div class="or-divider">or</div>
                    
                    <div class="social-login">
                        <a href="#" class="social-login-button facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-login-button google">
                            <i class="fab fa-google"></i>
                        </a>
                        </div>

                    <div class="login-register">
                        <p class="login-register-text">
                                Don't have an account? 
                            <a href="{{ route('register') }}" class="login-register-link">Register now</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        
        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle the eye / eye-slash icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>
@endpush