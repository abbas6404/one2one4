@extends('layouts.public-layout')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4 text-danger mb-4">{{ $pageTitle }}</h1>
            <p class="lead">{{ $pageDescription }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-danger">
                <div class="card-header bg-danger text-white">
                    <h3 class="mb-0">Emergency Hotlines</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($hotlines as $hotline)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">{{ $hotline['name'] }}</h5>
                                <p class="mb-0 text-muted">{{ $hotline['description'] }}</p>
                            </div>
                            <a href="tel:{{ str_replace(' ', '', $hotline['phone']) }}" class="btn btn-outline-danger">
                                <i class="fas fa-phone-alt me-2"></i>{{ $hotline['phone'] }}
                            </a>
                        </li>
                        @empty
                        <li class="list-group-item">
                            <p class="mb-0 text-muted">No emergency hotlines available at the moment.</p>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100 border-danger">
                <div class="card-header bg-danger text-white">
                    <h3 class="mb-0">Emergency Instructions</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>{{ $whatToDoTitle }}</h5>
                        <ol>
                            @foreach($whatToDo as $item)
                            <li>{{ $item }}</li>
                            @endforeach
                        </ol>
                    </div>
                    <div>
                        <h5>{{ $requiredInfoTitle }}</h5>
                        <ul>
                            @foreach($requiredInfo as $item)
                            <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 