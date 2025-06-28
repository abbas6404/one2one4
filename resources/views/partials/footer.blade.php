<!-- Footer -->
<footer class="footer">
    <div class="footer-blood-cells"></div>
    <div class="container position-relative">
        <div class="footer-header text-center mb-5">
            <div class="footer-logo-container">
                <span class="footer-logo-icon">
                    <img src="{{ asset(app('website-content')->get('site.logo_icon', 'images/logo-icon.png')) }}" alt="Logo Icon" class="img-fluid">
                </span>
                <h2>{{ app('website-content')->get('site.name', 'OneToOneFor') }}</h2>
            </div>
            <p class="footer-tagline">{{ app('website-content')->get('site.tagline', 'Connecting blood donors with recipients since 2024') }}</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="footer-widget">
                    <h5 class="footer-title">Navigation <span class="title-accent"></span></h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="{{ route('donors.index') }}"><i class="fas fa-chevron-right"></i> Find Donors</a></li>
                        <li><a href="{{ route('gallery') }}"><i class="fas fa-chevron-right"></i> Gallery</a></li>
                        <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="footer-widget">
                    <h5 class="footer-title">For Donors <span class="title-accent"></span></h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('register') }}"><i class="fas fa-chevron-right"></i> Register as Donor</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Donation Guidelines</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Health Resources</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> FAQs</a></li>
                        <li><a href="{{ route('emergency') }}"><i class="fas fa-chevron-right"></i> Emergency Requests</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="footer-widget">
                    <h5 class="footer-title">Contact Us <span class="title-accent"></span></h5>
                    <ul class="footer-contact-info">
                        <li>
                            <span class="contact-icon"><i class="fas fa-map-marker-alt"></i></span>
                            <span class="contact-text">{{ app('website-content')->get('footer.contact.address', 'Bangladesh') }}</span>
                        </li>
                        <!-- <li>
                            <span class="contact-icon"><i class="fas fa-phone-alt"></i></span>
                            <span class="contact-text">{{ app('website-content')->get('footer.contact.phone', '+880 1234 567890') }}</span>
                        </li> -->
                        <li>
                            <span class="contact-icon"><i class="fas fa-envelope"></i></span>
                            <span class="contact-text">{{ app('website-content')->get('footer.contact.email', 'one2one4.bd@gmail.com') }}</span>
                        </li>
                        <li>
                            <span class="contact-icon"><i class="fas fa-clock"></i></span>
                            <span class="contact-text">Mon-Fri: 9AM-6PM</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h5 class="footer-title">Newsletter <span class="title-accent"></span></h5>
                    <p class="newsletter-text">Subscribe to our newsletter for updates on blood donation camps and urgent requests.</p>
                    <form class="newsletter-form">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Your Email Address">
                        </div>
                        <button type="submit" class="btn btn-subscribe">Subscribe</button>
                    </form>
                    
                    <div class="social-links mt-4">
                        @if(app('website-content')->get('social.facebook'))
                        <a href="{{ app('website-content')->get('social.facebook') }}" class="social-link" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        
                        @if(app('website-content')->get('social.twitter'))
                        <a href="{{ app('website-content')->get('social.twitter') }}" class="social-link" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        @endif
                        
                        @if(app('website-content')->get('social.instagram'))
                        <a href="{{ app('website-content')->get('social.instagram') }}" class="social-link" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        
                        @if(app('website-content')->get('social.linkedin'))
                        <a href="{{ app('website-content')->get('social.linkedin') }}" class="social-link" target="_blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        @endif
                        
                        @if(app('website-content')->get('social.youtube'))
                        <a href="{{ app('website-content')->get('social.youtube') }}" class="social-link" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="copyright">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-md-0">© {{ date('Y') }} OneToOneFor. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Designed with <i class="fas fa-heart text-danger"></i> by <a href="https://www.aioinnovation.com/" target="_blank">AiO Innovation Limited</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to top button -->
<a href="#" id="back-to-top" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="fas fa-arrow-up"></i>
</a>

<!-- Add CSS for the enhanced footer -->
<style>
.footer {
    position: relative;
    background: #1a1a2e;
    color: rgba(255, 255, 255, 0.8);
    padding: 80px 0 0;
    overflow: hidden;
}

.footer-blood-cells {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('{{ asset('images/blood-cells-dark.png') }}') center/cover no-repeat;
    opacity: 0.05;
    z-index: 0;
}

.footer-header {
    position: relative;
    z-index: 1;
}

.footer-logo-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 15px;
}

.footer-logo-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(145deg, #b22222, #d32f2f);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

.footer-logo-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.footer-logo-icon i {
    font-size: 32px;
}

.footer-logo-container h2 {
    font-size: 32px;
    font-weight: 700;
    color: white;
    margin: 0;
}

.footer-tagline {
    color: rgba(255, 255, 255, 0.6);
    margin-top: 10px;
    font-size: 16px;
}

.footer-widget {
    position: relative;
    z-index: 1;
    margin-bottom: 30px;
}

.footer-title {
    color: #fff;
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 25px;
    position: relative;
    display: inline-block;
}

.title-accent {
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 40px;
    height: 2px;
    background: linear-gradient(to right, #b22222, #ff6b6b);
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all 0.3s;
    display: flex;
    align-items: center;
}

.footer-links a i {
    font-size: 12px;
    margin-right: 8px;
    color: #b22222;
}

.footer-links a:hover {
    color: #fff;
    transform: translateX(5px);
}

.footer-contact-info {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-contact-info li {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
}

.contact-icon {
    width: 30px;
    height: 30px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    flex-shrink: 0;
}

.contact-icon i {
    font-size: 14px;
    color: #b22222;
}

.contact-text {
    line-height: 1.4;
    color: rgba(255, 255, 255, 0.7);
}

.newsletter-text {
    margin-bottom: 20px;
    font-size: 14px;
    line-height: 1.6;
}

.newsletter-form .form-control {
    height: 46px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #fff;
    border-radius: 5px;
    padding: 0 15px;
    margin-bottom: 15px;
}

.newsletter-form .form-control:focus {
    box-shadow: none;
    border-color: rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.15);
}

.newsletter-form .form-control::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.btn-subscribe {
    background: linear-gradient(45deg, #b22222, #ff6b6b);
    border: none;
    color: #fff;
    border-radius: 5px;
    padding: 10px 20px;
    font-weight: 600;
    width: 100%;
    transition: all 0.3s;
}

.btn-subscribe:hover {
    background: linear-gradient(45deg, #a51c1c, #e63946);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(229, 62, 62, 0.3);
}

.social-links {
    display: flex;
    gap: 10px;
}

.social-link {
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

.social-link:hover {
    background: #b22222;
    color: #fff;
    transform: translateY(-3px);
}

.copyright {
    background: rgba(0, 0, 0, 0.2);
    padding: 20px 0;
    margin-top: 50px;
    position: relative;
    z-index: 1;
    font-size: 14px;
}

.copyright p {
    color: rgba(255, 255, 255, 0.6);
    margin-bottom: 0;
}

.copyright a {
    color: #ff6b6b;
    text-decoration: none;
    transition: color 0.3s;
}

.copyright a:hover {
    color: #fff;
}

@media (max-width: 991px) {
    .footer {
        padding: 60px 0 0;
    }
    
    .footer-logo-icon {
        width: 60px;
        height: 60px;
    }
    
    .footer-logo-icon i {
        font-size: 28px;
    }
    
    .footer-logo-container h2 {
        font-size: 28px;
    }
}

@media (max-width: 767px) {
    .footer {
        padding: 50px 0 0;
    }
    
    .footer-widget {
        margin-bottom: 40px;
    }
    
    .copyright .text-md-end {
        text-align: center !important;
        margin-top: 10px;
    }
    
    .copyright .text-md-start {
        text-align: center !important;
    }
}
</style>
