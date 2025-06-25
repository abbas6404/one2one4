@extends('errors.errors_layout')

@section('title')
404 - Page Not Found
@endsection

@section('error-content')
    <h2>404</h2>
    <p>Sorry ! Page Not Found !</p>
    
    @if(str_contains(request()->path(), 'admin'))
        <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
        <a href="{{ route('admin.login') }}">Login Again !</a>
    @else
        <a href="{{ route('user.dashboard') }}">Back to Dashboard</a>
        <a href="{{ route('login') }}">Login Again !</a>
    @endif
@endsection