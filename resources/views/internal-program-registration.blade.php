@extends('layouts.public-layout')

@section('title', app('website-content')->get('internal_program.title', 'Internal Programs Registration'))

@push('styles')
<style>
    .internal-program-section {
        padding: 80px 0;
        background-color: #f8f9fa;
    }
    
    .program-header {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .program-title {
        color: #b22222;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .program-subtitle {
        color: #555;
        font-size: 1.2rem;
        margin-bottom: 20px;
    }
    
    .program-description {
        max-width: 800px;
        margin: 0 auto 40px;
        line-height: 1.8;
    }
    
    .registration-form-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 30px;
    }
    
    .form-section-title {
        color: #b22222;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .form-label {
        font-weight: 500;
    }
    
    .required-field::after {
        content: "*";
        color: #b22222;
        margin-left: 4px;
    }
    
    .blood-group-select {
        background-color: #fff;
    }
    
    .payment-info {
        background-color: #f8f9fa;
        border-left: 4px solid #b22222;
        padding: 15px;
        margin-bottom: 20px;
    }
    
    .screenshot-preview {
        max-width: 100%;
        max-height: 200px;
        display: none;
        margin-top: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    
    .submit-btn {
        background-color: #b22222;
        border: none;
        padding: 10px 30px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .submit-btn:hover {
        background-color: #9a0000;
    }
    
    .contact-info {
        margin-top: 40px;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        text-align: center;
    }
</style>
@endpush

@section('content')
<section class="internal-program-section">
    <div class="container">
        <div class="program-header">
            <h1 class="program-title">{{ app('website-content')->get('internal_program.title', 'Internal Programs Registration') }}</h1>
            <p class="program-subtitle">{{ app('website-content')->get('internal_program.subtitle', 'Join our exclusive internal programs for SSC-12 & HSC-14 batch members') }}</p>
            <div class="program-description">
                <p>{{ app('website-content')->get('internal_program.description', 'Our internal programs are designed specifically for our batch members to strengthen our community bonds, promote blood donation awareness, and engage in social welfare activities. Register below to participate in upcoming events and receive your exclusive batch T-shirt.') }}</p>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="registration-form-container">
                    <h3 class="form-section-title">{{ app('website-content')->get('internal_program.registration.title', 'Program Registration') }}</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('internal-program.register') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label required-field">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label required-field">Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address (Optional)</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="blood_group" class="form-label required-field">Blood Group</label>
                                <select class="form-select blood-group-select @error('blood_group') is-invalid @enderror" id="blood_group" name="blood_group" required>
                                    <option value="" selected disabled>Select Blood Group</option>
                                    <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                                @error('blood_group')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="present_address" class="form-label required-field">Present Address</label>
                            <textarea class="form-control @error('present_address') is-invalid @enderror" id="present_address" name="present_address" rows="3" required>{{ old('present_address') }}</textarea>
                            @error('present_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="tshirt_size" class="form-label required-field">T-shirt Size</label>
                            <select class="form-select @error('tshirt_size') is-invalid @enderror" id="tshirt_size" name="tshirt_size" required>
                                <option value="" selected disabled>Select T-shirt Size</option>
                                <option value="S" {{ old('tshirt_size') == 'S' ? 'selected' : '' }}>Small (S)</option>
                                <option value="M" {{ old('tshirt_size') == 'M' ? 'selected' : '' }}>Medium (M)</option>
                                <option value="L" {{ old('tshirt_size') == 'L' ? 'selected' : '' }}>Large (L)</option>
                                <option value="XL" {{ old('tshirt_size') == 'XL' ? 'selected' : '' }}>Extra Large (XL)</option>
                                <option value="XXL" {{ old('tshirt_size') == 'XXL' ? 'selected' : '' }}>Double XL (XXL)</option>
                            </select>
                            @error('tshirt_size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="payment-info">
                            <p>{{ app('website-content')->get('internal_program.payment.instructions', 'Please complete your registration by making a payment of 500 BDT using one of the available payment methods. Upload a screenshot of your payment for verification.') }}</p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="payment_method" class="form-label required-field">Payment Method</label>
                                <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                    <option value="" selected disabled>Select Payment Method</option>
                                    <option value="bKash" {{ old('payment_method') == 'bKash' ? 'selected' : '' }}>bKash</option>
                                    <option value="Nagad" {{ old('payment_method') == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                                    <option value="Rocket" {{ old('payment_method') == 'Rocket' ? 'selected' : '' }}>Rocket</option>
                                    <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="trx_id" class="form-label">Transaction ID (Optional)</label>
                                <input type="text" class="form-control @error('trx_id') is-invalid @enderror" id="trx_id" name="trx_id" value="{{ old('trx_id') }}">
                                @error('trx_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="screenshot" class="form-label">Payment Screenshot (Optional)</label>
                            <input type="file" class="form-control @error('screenshot') is-invalid @enderror" id="screenshot" name="screenshot" accept="image/*">
                            <img id="screenshot-preview" class="screenshot-preview" alt="Payment Screenshot Preview">
                            @error('screenshot')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary submit-btn">Submit Registration</button>
                        </div>
                    </form>
                </div>
                
                <div class="contact-info">
                    <p>{{ app('website-content')->get('internal_program.contact.info', 'For any queries regarding registration or payment, please contact our program coordinator at +880 1234-567890 or email at programs@one2one4.org') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Preview uploaded screenshot
    document.getElementById('screenshot').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('screenshot-preview');
                preview.src = event.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush 