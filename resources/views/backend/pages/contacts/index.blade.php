@extends('backend.layouts.master')

@section('title', 'Contact Messages')

@section('admin-content')
<div class="main-content">
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Contact Messages</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><span>Contact Messages</span></li>
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
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="header-title">Contact Messages List</h4>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-filter"></i> Filter
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.contacts.index') }}">All Messages</a>
                                    <a class="dropdown-item" href="{{ route('admin.contacts.index', ['status' => 'read']) }}">Read Messages</a>
                                    <a class="dropdown-item" href="{{ route('admin.contacts.index', ['status' => 'unread']) }}">Unread Messages</a>
                                </div>
                            </div>
                        </div>
                        
                        @include('backend.layouts.partials.messages')
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contacts as $contact)
                                    <tr class="{{ $contact->status == 'unread' ? 'font-weight-bold' : '' }}">
                                        <td>{{ $contact->id }}</td>
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ Str::limit($contact->subject, 30) }}</td>
                                        <td>
                                            @if($contact->status == 'read')
                                                <span class="badge badge-success">Read</span>
                                            @else
                                                <span class="badge badge-warning">Unread</span>
                                            @endif
                                        </td>
                                        <td>{{ $contact->created_at->format('M d, Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-info btn-sm" title="View Message">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this message?')" title="Delete Message">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            @if($contact->status == 'unread')
                                                <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST" class="d-inline">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="hidden" name="status" value="read">
                                                    <button type="submit" class="btn btn-success btn-sm" title="Mark as Read">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST" class="d-inline">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="hidden" name="status" value="unread">
                                                    <button type="submit" class="btn btn-warning btn-sm" title="Mark as Unread">
                                                        <i class="fa fa-undo"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No contact messages found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            
                            <div class="mt-3">
                                {{ $contacts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge {
        font-size: 85%;
        padding: 0.35em 0.6em;
    }
    .table th, .table td {
        vertical-align: middle;
    }
</style>
@endpush 