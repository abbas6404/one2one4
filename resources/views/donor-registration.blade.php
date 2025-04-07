<!-- filepath: c:\xampp\htdocs\one2one4\resources\views\donor-registration.blade.php -->
@extends('layouts.layout')

@section('title', 'Donor Registration')

@section('public_content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <!-- Card Header -->
                <div class="card-header text-white text-center" style="background-color: #8a0303;">
                    <h3>Donor Registration</h3>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('donor.register.submit') }}" enctype="multipart/form-data">
                        @csrf <!-- CSRF token for security -->

                        <!-- Full Name -->
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" required>
                        </div>

                        <!-- Phone Number -->
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter your phone number" required>
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email address" required>
                        </div>

                        <!-- Blood Group -->
                        <div class="form-group mb-3">
                            <label for="blood_group" class="form-label">Blood Group</label>
                            <select name="blood_group" id="blood_group" class="form-select" required>
                                <option value="" selected>Select your blood group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>

                        <!-- Last Blood Donation Date -->
                        <div class="form-group mb-3">
                            <label for="last_donation" class="form-label">Last Blood Donation Date</label>
                            <input type="date" name="last_donation" id="last_donation" class="form-control">
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn text-white" style="background-color: #8a0303;">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection