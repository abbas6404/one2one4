<!-- Header -->
<header class="main-header">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="logo-container">
                    <div class="d-flex align-items-center">
                        <div class="logo-image">
                            <img src="{{ asset(app('website-content')->get('site.logo', 'images/logo.jpeg')) }}" alt="Blood Donation Logo" class="img-fluid">
                        </div>
                        <div class="logo-text bengali-text ms-2">
                            <div class="fw-semibold" style="color: #b22222;">{{ app('website-content')->get('site.title', 'এসএসএফ ১২ ও এইচএসএফ ১৪ ব্যাচ') }}</div>
                            <div style="color: #b22222;">{{ app('website-content')->get('site.subtitle', 'রক্তের বন্ধন অটুট থাক, জীবন বাঁচাতে রক্ত দিন') }}</div>
                        </div>
                    </div>
                </div>
            </a>
            
            <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNav" aria-controls="mobileNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Desktop Navigation -->
            <div class="collapse navbar-collapse d-none d-lg-block" id="navbarMain">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">ABOUT US</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('donors.index') ? 'active' : '' }}" href="{{ route('donors.index') }}">DONOR LIST</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}" href="{{ route('gallery') }}">GALLERY</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('internal-program.registration') ? 'active' : '' }}" href="{{ route('internal-program.registration') }}">EVENT REGISTRATION</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('emergency') ? 'active' : '' }}" href="{{ route('emergency') }}">EMERGENCY</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">CONTACT</a>
                    </li>
                </ul>
                
                <div class="auth-buttons d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-register">Register</a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Mobile Side Navigation -->
    <div class="offcanvas offcanvas-end mobile-nav" tabindex="-1" id="mobileNav" aria-labelledby="mobileNavLabel">
        <div class="offcanvas-header">
            <div class="mobile-logo-container">
                <div class="d-flex align-items-center">
                    <div class="logo-image">
                        <img src="{{ asset(app('website-content')->get('site.logo', 'images/logo.jpeg')) }}" alt="Blood Donation Logo" class="img-fluid" style="width: 40px;">
                    </div>
                    <div class="logo-text bengali-text ms-2">
                        <div class="fw-semibold mobile-bengali-title">{{ app('website-content')->get('site.title', 'এসএসএফ ১২ ও এইচএসএফ ১৪ ব্যাচ') }}</div>
                        <div class="mobile-bengali-subtitle">{{ app('website-content')->get('site.subtitle', 'রক্তের বন্ধন অটুট থাক, জীবন বাঁচাতে রক্ত দিন') }}</div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close text-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="mobile-menu">
                <ul class="mobile-nav-list">
                    <li class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" class="mobile-nav-link">
                            <i class="fas fa-home"></i>
                            <span>HOME</span>
                        </a>
                    </li>
                    <li class="mobile-nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                        <a href="{{ route('about') }}" class="mobile-nav-link">
                            <i class="fas fa-info-circle"></i>
                            <span>ABOUT US</span>
                        </a>
                    </li>
                    <li class="mobile-nav-item {{ request()->routeIs('donors.index') ? 'active' : '' }}">
                        <a href="{{ route('donors.index') }}" class="mobile-nav-link">
                            <i class="fas fa-users"></i>
                            <span>DONOR LIST</span>
                        </a>
                    </li>
                    <li class="mobile-nav-item {{ request()->routeIs('gallery') ? 'active' : '' }}">
                        <a href="{{ route('gallery') }}" class="mobile-nav-link">
                            <i class="fas fa-images"></i>
                            <span>PROGRAM</span>
                        </a>
                    </li>
                    <li class="mobile-nav-item {{ request()->routeIs('internal-program.registration') ? 'active' : '' }}">
                        <a href="{{ route('internal-program.registration') }}" class="mobile-nav-link">
                            <i class="fas fa-calendar-check"></i>
                            <span>INTERNAL PROGRAMS</span>
                        </a>
                    </li>
                    <li class="mobile-nav-item {{ request()->routeIs('emergency') ? 'active' : '' }}">
                        <a href="{{ route('emergency') }}" class="mobile-nav-link">
                            <i class="fas fa-ambulance"></i>
                            <span>EMERGENCY</span>
                        </a>
                    </li>
                    <li class="mobile-nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                        <a href="{{ route('contact') }}" class="mobile-nav-link">
                            <i class="fas fa-envelope"></i>
                            <span>CONTACT</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="mobile-auth-buttons">
                <a href="{{ route('login') }}" class="btn btn-mobile-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-mobile-register">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            </div>
            
            <div class="mobile-contact-info">
                <h5>Contact Us</h5>
                <ul class="mobile-contact-list">
                    <li>
                        <i class="fas fa-phone-alt"></i>
                        <span>{{ app('website-content')->get('footer.contact.phone', '+880 1234 567890') }}</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>{{ app('website-content')->get('footer.contact.email', 'info@one2one4.org') }}</span>
                    </li>
                </ul>
                
                <div class="mobile-social-links">
                    @if(app('website-content')->get('social.facebook'))
                    <a href="{{ app('website-content')->get('social.facebook') }}" class="mobile-social-link" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    @endif
                    
                    @if(app('website-content')->get('social.twitter'))
                    <a href="{{ app('website-content')->get('social.twitter') }}" class="mobile-social-link" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                    @endif
                    
                    @if(app('website-content')->get('social.instagram'))
                    <a href="{{ app('website-content')->get('social.instagram') }}" class="mobile-social-link" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif
                    
                    @if(app('website-content')->get('social.linkedin'))
                    <a href="{{ app('website-content')->get('social.linkedin') }}" class="mobile-social-link" target="_blank">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    @endif
                    
                    @if(app('website-content')->get('social.youtube'))
                    <a href="{{ app('website-content')->get('social.youtube') }}" class="mobile-social-link" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="notice-bar">
        <div class="container">
            <div class="d-flex align-items-center">
                <div class="notification-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="notification-content">
                    <marquee behavior="scroll" direction="left" class="bengali-text notification-text">
                        {{ app('website-content')->get('site.notification', 'আজকের রক্তদান শিবির - ২১ আগস্ট, ২০২৪ | বিস্তারিত জানতে যোগাযোগ করুন') }}
                    </marquee>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Add CSS for mobile side navigation -->
<style>
/* Custom Navbar Toggler */
.custom-toggler {
    border: none;
    padding: 0.25rem;
    border-radius: 5px;
}

.custom-toggler:focus {
    box-shadow: none;
}

/* Mobile Side Navigation */
.mobile-nav {
    width: 280px;
    background: #161630;
    color: white;
}

.offcanvas-header {
    background: #0f0f20;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    padding: 1rem;
}

.offcanvas-header .btn-close {
    background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='white'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    opacity: 0.8;
}

.offcanvas-title {
    font-weight: 700;
    color: white;
    margin-bottom: 0;
    font-size: 1.2rem;
}

.mobile-nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.mobile-nav-item {
    margin-bottom: 0.5rem;
}

.mobile-nav-link {
    display: flex;
    align-items: center;
    padding: 0.875rem 1rem;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s;
}

.mobile-nav-link i {
    font-size: 1.25rem;
    width: 2rem;
    color: #b22222;
}

.mobile-nav-link span {
    font-weight: 500;
}

.mobile-nav-item.active .mobile-nav-link {
    background-color: rgba(178, 34, 34, 0.2);
    color: white;
}

.mobile-nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: white;
}

.mobile-auth-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin: 1.5rem 0;
}

.btn-mobile-login, 
.btn-mobile-register {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem;
    border-radius: 5px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-mobile-login {
    background-color: rgba(255, 255, 255, 0.1);
    color: white;
}

.btn-mobile-register {
    background: linear-gradient(45deg, #b22222, #ff6b6b);
    color: white;
}

.btn-mobile-login:hover {
    background-color: rgba(255, 255, 255, 0.2);
    color: white;
}

.btn-mobile-register:hover {
    background: linear-gradient(45deg, #a51c1c, #e63946);
    color: white;
}

.btn-mobile-login i,
.btn-mobile-register i {
    margin-right: 8px;
}

.mobile-contact-info {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.mobile-contact-info h5 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: white;
}

.mobile-contact-list {
    list-style: none;
    padding: 0;
    margin: 0 0 1.5rem;
}

.mobile-contact-list li {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
}

.mobile-contact-list li i {
    width: 1.5rem;
    font-size: 1rem;
    color: #b22222;
}

.mobile-social-links {
    display: flex;
    gap: 10px;
}

.mobile-social-link {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 16px;
    transition: all 0.3s;
}

.mobile-social-link:hover {
    background: #b22222;
    color: #fff;
}

@media (min-width: 992px) {
    .navbar-toggler {
        display: none;
    }
}

@media (max-width: 991px) {
    .navbar-collapse {
        display: none !important;
    }
}

.mobile-bengali-title {
    color: #fff;
    font-size: 0.9rem;
    line-height: 1.2;
}

.mobile-bengali-subtitle {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.8rem;
    line-height: 1.2;
}

@media (max-width: 400px) {
    .mobile-bengali-title {
        font-size: 0.8rem;
    }
    
    .mobile-bengali-subtitle {
        font-size: 0.7rem;
    }
}

/* Notice Bar Styling */
.notice-bar {
    background-color: #a51c1c;
    color: white;
    padding: 0.6rem 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
}

.notice-bar .d-flex {
    position: relative;
}

.notification-icon {
    margin-right: 15px;
    background: rgba(255, 255, 255, 0.2);
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse-icon 2s infinite;
}

@keyframes pulse-icon {
    0% {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
    }
}

.notification-content {
    flex: 1;
    overflow: hidden;
}

.notification-text {
    font-size: 0.95rem;
    font-weight: 500;
    letter-spacing: 0.03em;
    display: block;
    padding: 2px 0;
    white-space: nowrap;
}
</style>
