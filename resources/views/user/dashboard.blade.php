<!-- filepath: c:\xampp\htdocs\one2one4\resources\views\user\dashboard.blade.php -->
@extends('layouts.layout')

@section('title', 'User Dashboard')

@section('public_content')
<div class="container mt-5">
    <h1>Welcome to Your Dashboard!</h1>
    <p>This is the user dashboard page. Customize it as needed.</p>

    <!-- Logout Button -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger mt-3">Logout</button>
    </form>
</div>
@endsection