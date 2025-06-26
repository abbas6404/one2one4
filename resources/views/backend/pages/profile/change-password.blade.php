@extends('backend.layouts.master')

@section('title')
Change Password
@endsection

@section('styles')
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #f1f1f1;
    }
    .card-title {
        margin-bottom: 0;
        font-weight: 600;
    }
    .password-rules {
        background-color: #f9f9f9;
        border-left: 4px solid #007bff;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    .password-rules ul {
        margin-bottom: 0;
        padding-left: 20px;
    }
    .btn-change-password {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-change-password:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Change Password</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>Change Password</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>

<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto mt-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Change Your Password</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="password-rules">
                        <h5>Password Requirements:</h5>
                        <ul>
                            <li>At least 8 characters long</li>
                            <li>Include a combination of letters, numbers, and special characters</li>
                            <li>Avoid using easily guessable information</li>
                        </ul>
                    </div>

                    <form action="{{ route('admin.profile.change-password') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary btn-change-password">
                                <i class="fa fa-key mr-1"></i> Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 