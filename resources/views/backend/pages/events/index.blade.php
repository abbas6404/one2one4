@extends('backend.layouts.master')

@section('title', 'Events Management')

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Events</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>All Events</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Events List</h4>
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('event.create'))
                            <a class="btn btn-primary text-white" href="{{ route('admin.events.create') }}">Create New Event</a>
                        @endif
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Id</th>
                                    <th width="10%">Image</th>
                                    <th width="20%">Title</th>
                                    <th width="15%">Date</th>
                                    <th width="10%">Location</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Featured</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                <tr>
                                    <td>{{ $event->id }}</td>
                                    <td>
                                        @if ($event->image)
                                            <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" style="max-width: 80px; max-height: 60px;">
                                        @else
                                            <img src="{{ asset('images/default.png') }}" alt="Default" style="max-width: 80px; max-height: 60px;">
                                        @endif
                                    </td>
                                    <td>{{ $event->title }}</td>
                                    <td>
                                        <strong>Start:</strong> {{ $event->start_date->format('M d, Y h:i A') }}<br>
                                        <strong>End:</strong> {{ $event->end_date->format('M d, Y h:i A') }}
                                    </td>
                                    <td>{{ $event->location ?? 'N/A' }}</td>
                                    <td>
                                        @if ($event->status == 'active')
                                            <span class="badge badge-success">Active</span>
                                        @elseif ($event->status == 'inactive')
                                            <span class="badge badge-warning">Inactive</span>
                                        @else
                                            <span class="badge badge-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($event->is_featured)
                                            <span class="badge badge-info">Featured</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('event.view'))
                                            <a class="btn btn-info text-white btn-sm" href="{{ route('admin.events.show', $event->id) }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif
                                        
                                        @if (Auth::guard('admin')->user()->can('event.edit'))
                                            <a class="btn btn-success text-white btn-sm" href="{{ route('admin.events.edit', $event->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                        
                                        @if (Auth::guard('admin')->user()->can('event.delete'))
                                            <a class="btn btn-danger text-white btn-sm" href="{{ route('admin.events.destroy', $event->id) }}"
                                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $event->id }}').submit();">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <form id="delete-form-{{ $event->id }}" action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 