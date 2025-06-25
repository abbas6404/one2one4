@extends('backend.auth.auth_master')

@section('auth_title')
    Admin Login | Blood Donation Management System
@endsection

@section('styles')
<!-- Add Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .login-area {
        min-height: 100vh;
        display: flex;
        background-color: #fdf2f3;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-container {
        display: flex;
        width: 1000px;
        margin: auto;
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }

    .login-banner {
        flex: 1;
        background: #e84c3d;
        padding: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: white;
    }

    .banner-content h1 {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .banner-content p {
        font-size: 16px;
        opacity: 0.9;
        line-height: 1.6;
        margin-bottom: 40px;
    }

    .banner-features {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .banner-features li {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        font-size: 16px;
        color: rgba(255, 255, 255, 0.9);
    }

    .banner-features li i {
        width: 24px;
        height: 24px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 12px;
    }

    .login-form-container {
        flex: 1;
        padding: 60px;
        background: white;
        display: flex;
        flex-direction: column;
    }

    .login-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .blood-drop-icon {
        width: 48px;
        height: 48px;
        margin-bottom: 24px;
        display: inline-block;
    }

    .blood-drop-icon svg {
        width: 100%;
        height: 100%;
        fill: #e84c3d;
    }

    .login-header h2 {
        font-size: 32px;
        color: #2d3748;
        margin-bottom: 12px;
        font-weight: 600;
    }

    .login-header p {
        color: #718096;
        font-size: 16px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #64748b;
        font-weight: 500;
        font-size: 14px;
    }

    .input-wrapper {
        position: relative;
        transition: all 0.3s ease;
    }

    .input-wrapper input {
        width: 100%;
        height: 45px;
        padding: 0 44px 0 16px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 14px;
        color: #1e293b;
        transition: all 0.3s ease;
        background-color: #fff;
    }

    .input-wrapper input::placeholder {
        color: #94a3b8;
        font-size: 14px;
    }

    .input-wrapper input:hover {
        border-color: #cbd5e1;
    }

    .input-wrapper input:focus {
        border-color: #e84c3d;
        box-shadow: 0 0 0 4px rgba(232, 76, 61, 0.1);
        outline: none;
    }

    .input-wrapper .icon {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .input-wrapper input:focus + .icon {
        color: #e84c3d;
    }

    .input-wrapper .icon svg {
        width: 18px;
        height: 18px;
        stroke: currentColor;
        stroke-width: 2;
        fill: none;
    }

    .remember-forgot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 16px 0 24px;
    }

    .custom-checkbox {
        display: flex;
        align-items: center;
    }

    .custom-checkbox input[type="checkbox"] {
        width: 16px;
        height: 16px;
        margin-right: 8px;
        border-radius: 4px;
        border: 2px solid #e2e8f0;
        accent-color: #e84c3d;
        cursor: pointer;
    }

    .custom-checkbox label {
        color: #64748b;
        font-size: 14px;
        cursor: pointer;
        user-select: none;
    }

    .forgot-link {
        color: #e84c3d;
        font-size: 14px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .forgot-link:hover {
        text-decoration: underline;
    }

    .submit-btn {
        width: 100%;
        height: 48px;
        background: #e84c3d;
        border: none;
        border-radius: 8px;
        color: white;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .submit-btn:hover {
        background: #d44637;
    }

    .text-danger {
        color: #e84c3d;
        font-size: 13px;
        margin-top: 6px;
    }

    @media (max-width: 1024px) {
        .login-container {
            width: 90%;
            margin: 20px;
        }
    }

    @media (max-width: 768px) {
        .login-banner {
            display: none;
        }
        
        .login-form-container {
            padding: 40px;
        }
    }
</style>
@endsection

@section('auth-content')
     <div class="login-area">
    <div class="login-container">
        <div class="login-banner">
            <div class="banner-content">
                <h1>Blood Donation Management System</h1>
                <p>Streamline blood donation processes, manage donors, and save lives through efficient blood bank management.</p>
                
                <ul class="banner-features">
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Manage Blood Donations</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Track Donor Information</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Handle Blood Requests</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Generate Reports</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="login-form-container">
            <div class="login-header">
                <div class="blood-drop-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 20.9998C15.866 20.9998 19 17.8658 19 13.9998C19 10.9998 15.6667 6.99984 12 2.99984C8.33333 6.99984 5 10.9998 5 13.9998C5 17.8658 8.13401 20.9998 12 20.9998Z"/>
                    </svg>
                </div>
                <h2>Welcome Back</h2>
                <p>Please sign in to your admin account</p>
            </div>

            <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="Enter your email address"
                        >
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6M22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6M22 6L12 13L2 6" />
                            </svg>
                        </span>
                    </div>
                            @error('email')
                        <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                <div class="form-group">
                            <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Enter your password"
                        >
                        <span class="icon toggle-password">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="eye-icon">
                                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" />
                                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" />
                            </svg>
                        </span>
                    </div>
                            @error('password')
                        <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                <div class="remember-forgot">
                    <div class="custom-checkbox">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember" 
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label for="remember">Remember Me</label>
                    </div>
                    <a href="{{ route('admin.password.request') }}" class="forgot-link">
                        Forgot Password?
                    </a>
                </div>

                <button type="submit" class="submit-btn">
                    Sign in to Dashboard
                </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Toggle password visibility
    document.querySelector('.toggle-password').addEventListener('click', function() {
        const passwordInput = document.querySelector('#password');
        const eyeIcon = this.querySelector('.eye-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `
                <path d="M2 2L22 22" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M6.71277 6.7226C3.66479 8.79527 2 12 2 12C2 12 5.63636 19 12 19C14.0503 19 15.8174 18.2734 17.2711 17.2884L6.71277 6.7226Z"/>
                <path d="M17.2812 17.2721C20.3287 15.1952 22 12 22 12C22 12 18.3636 5 12 5C9.94968 5 8.18264 5.72656 6.72893 6.71161L17.2812 17.2721Z"/>
                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 11.6494 14.9398 11.3128 14.8293 11L11 14.8293C11.3128 14.9398 11.6494 15 12 15Z"/>
                <path d="M12 9C10.3431 9 9 10.3431 9 12C9 12.3506 9.06019 12.6872 9.17071 13L13 9.17071C12.6872 9.06019 12.3506 9 12 9Z"/>
            `;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `
                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" />
                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" />
            `;
        }
    });

    // Add focus effect for icons
    document.querySelectorAll('.input-wrapper input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.querySelector('.icon').style.color = '#e84c3d';
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.querySelector('.icon').style.color = '#94a3b8';
            }
        });
    });
</script>
@endsection