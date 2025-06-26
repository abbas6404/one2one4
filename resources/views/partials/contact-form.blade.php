<!-- Contact Form Partial -->
<div class="contact-card">
    <div class="row g-0">
        <div class="col-md-5">
            <div class="contact-info-panel">
                <div class="contact-blood-cells"></div>
                <div class="contact-logo">
                    <i class="fas fa-hand-holding-medical"></i>
                </div>
                <h3 class="contact-info-title">{{ $info_title ?? 'Blood Donation Platform' }}</h3>
                <p class="contact-tagline">{{ $info_tagline ?? 'Saving lives through voluntary blood donation' }}</p>
                
                <div class="contact-info-list">
                    <div class="contact-info-item">
                        <div class="icon-box">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <h5>Location</h5>
                            <p>{{ $address ?? app('website-content')->get('footer.contact.address', 'SSF-12 & HSF-14 Batch, Medical College Gate, Dhaka') }}</p>
                        </div>
                    </div>
                    
                    <div class="contact-info-item">
                        <div class="icon-box">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="info-content">
                            <h5>Phone Number</h5>
                            <p>{{ $phone ?? app('website-content')->get('footer.contact.phone', '+880 1234 567890') }}</p>
                        </div>
                    </div>
                    
                    <div class="contact-info-item">
                        <div class="icon-box">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h5>Email Address</h5>
                            <p>{{ $email ?? app('website-content')->get('footer.contact.email', 'info@one2one4.org') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="social-links">
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
        
        <div class="col-md-7">
            <div class="contact-form-wrapper">
                <h3 class="form-title">{{ $form_title ?? 'Send us a Message' }}</h3>
                <form id="contactForm" action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Your Name" required value="{{ old('name') }}">
                                <label for="name"><i class="fas fa-user"></i> Your Name</label>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Your Email" required value="{{ old('email') }}">
                                <label for="email"><i class="fas fa-envelope"></i> Your Email</label>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Your Phone" value="{{ old('phone') }}">
                                <label for="phone"><i class="fas fa-phone"></i> Your Phone (Optional)</label>
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Subject" required value="{{ old('subject') }}">
                                <label for="subject"><i class="fas fa-heading"></i> Subject</label>
                                @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" placeholder="Your Message" style="height: 150px" required>{{ old('message') }}</textarea>
                                <label for="message"><i class="fas fa-comment-alt"></i> Your Message</label>
                                @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-send-message">
                                <i class="fas fa-paper-plane me-2"></i> {{ $button_text ?? 'Send Message' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="fas fa-check-circle me-2"></i> Success
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <i class="fas fa-envelope-open-text text-success" style="font-size: 3rem;"></i>
                </div>
                <h4>Thank You!</h4>
                <p class="mb-0">{{ session('success') ?? 'Your message has been sent successfully! We will get back to you soon.' }}</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-success px-4" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    });
</script>
@endif 