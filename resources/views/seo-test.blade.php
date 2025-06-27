@extends('layouts.public-layout')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title">SEO Test Page</h1>
                    
                    @if(isset($id))
                        <h2>Dynamic Test #{{ $id }}</h2>
                    @endif
                    
                    <p class="card-text">This page demonstrates the SEO middleware and service functionality.</p>
                    
                    <div class="alert alert-info">
                        <strong>View the page source</strong> to see the generated meta tags and structured data.
                    </div>
                    
                    <h3 class="mt-4">Current SEO Data:</h3>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Title</th>
                                <td>{{ Seo::getTitle() }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ Seo::getDescription() }}</td>
                            </tr>
                            <tr>
                                <th>Keywords</th>
                                <td>{{ Seo::getKeywords() }}</td>
                            </tr>
                            <tr>
                                <th>Canonical URL</th>
                                <td>{{ Seo::getCanonical() }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ Seo::getType() }}</td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td>{{ Seo::getImage() }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('seo.test') }}" class="btn btn-primary">View Route-based Test</a>
                        <a href="{{ route('seo.controller') }}" class="btn btn-secondary ms-2">View Controller-based Test</a>
                        <a href="{{ route('seo.dynamic', ['id' => rand(1, 100)]) }}" class="btn btn-info ms-2">View Random Dynamic Test</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 