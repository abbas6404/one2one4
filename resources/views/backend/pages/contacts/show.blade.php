@extends('backend.layouts.master')

@section('title', 'View Contact Message')

@section('admin-content')
<div class="main-content">
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">View Message</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.contacts.index') }}">Contact Messages</a></li>
                        <li><span>View Message</span></li>
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
                            <h4 class="header-title">Message Details</h4>
                            <div>
                                <a href="{{ route('admin.contacts.index') }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        
                        @include('backend.layouts.partials.messages')
                        
                        <div class="message-container">
                            <div class="message-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="subject mb-3">{{ $contact->subject }}</h5>
                                        <div class="sender-info">
                                            <p><strong>From:</strong> {{ $contact->name }} &lt;{{ $contact->email }}&gt;</p>
                                            @if($contact->phone)
                                                <p><strong>Phone:</strong> {{ $contact->phone }}</p>
                                            @endif
                                            <p><strong>Date:</strong> {{ $contact->created_at->format('F d, Y h:i A') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <span class="badge badge-{{ $contact->status == 'read' ? 'success' : 'warning' }} mb-3">
                                            {{ ucfirst($contact->status) }}
                                        </span>
                                        
                                        <div class="btn-group">
                                            @if($contact->status == 'unread')
                                                <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST" class="d-inline">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="hidden" name="status" value="read">
                                                    <button type="submit" class="btn btn-success btn-sm mr-2">
                                                        <i class="fa fa-check"></i> Mark as Read
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST" class="d-inline">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="hidden" name="status" value="unread">
                                                    <button type="submit" class="btn btn-warning btn-sm mr-2">
                                                        <i class="fa fa-undo"></i> Mark as Unread
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this message?')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="message-body mt-4">
                                <div class="card">
                                    <div class="card-body bg-light">
                                        <p class="message-text">{{ $contact->message }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="message-actions mt-4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#replyEmailModal">
                                    <i class="fa fa-reply"></i> Reply via Email
                                </button>
                                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-list"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reply Email Modal -->
<div class="modal fade" id="replyEmailModal" tabindex="-1" role="dialog" aria-labelledby="replyEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyEmailModalLabel">Reply to {{ $contact->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.contacts.reply', $contact->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="to">To</label>
                        <input type="email" class="form-control" id="to" name="to" value="{{ $contact->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" value="RE: {{ $contact->subject }}" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="10" required>

--------------------------------------------------
Original Message:
{{ $contact->message }}
</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send Reply</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .message-container {
        padding: 15px 0;
    }
    .subject {
        font-size: 1.4rem;
        font-weight: 600;
        color: #333;
    }
    .sender-info p {
        margin-bottom: 0.5rem;
    }
    .message-body {
        min-height: 200px;
    }
    .message-text {
        white-space: pre-wrap;
        font-size: 1.05rem;
        line-height: 1.6;
    }
    .badge {
        padding: 0.5em 0.8em;
        font-size: 85%;
    }
</style>
@endpush 