@extends('backend.layouts.master')

@section('title')
Internal Program Details
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
    .detail-row {
        display: flex;
        border-bottom: 1px solid #f1f1f1;
        padding: 15px 0;
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        width: 150px;
        font-weight: 600;
        color: #555;
    }
    .detail-value {
        flex: 1;
    }
    .blood-group {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        color: #fff;
        background-color: #dc3545;
    }
    .badge-pending {
        background-color: #ffc107;
        color: #212529;
    }
    .badge-approved {
        background-color: #28a745;
        color: #fff;
    }
    .badge-rejected {
        background-color: #dc3545;
        color: #fff;
    }
    .screenshot-container {
        max-width: 100%;
        margin-top: 10px;
    }
    .screenshot-img {
        width: 300px;
        height: 200px;
        object-fit: cover;
        border-radius: 5px;
        border: 1px solid #ddd;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    .screenshot-img:hover {
        transform: scale(1.05);
    }
    .status-form {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #f1f1f1;
    }
    .event-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 4px;
        background-color: #007bff;
        color: #fff;
        font-weight: 500;
        font-size: 13px;
        margin-bottom: 10px;
    }
    .event-details {
        background-color: #f8f9fa;
        border-radius: 6px;
        padding: 15px;
        margin-top: 10px;
    }
    .event-details h5 {
        margin-bottom: 10px;
        color: #333;
    }
    .event-details p {
        margin-bottom: 5px;
        color: #666;
    }
    .event-details .badge-featured {
        background-color: #ff9800;
        color: #fff;
    }
    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.8);
    }
    .modal-content {
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 90%;
    }
    .modal-close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Internal Program Details</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.internal-programs.index') }}">Internal Programs</a></li>
                    <li><span>View Program</span></li>
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Internal Program Details</h4>
                    <div>
                        <a href="{{ route('admin.internal-programs.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('admin.internal-programs.edit', $internalProgram->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="program-details">
                        <div class="detail-row">
                            <div class="detail-label">Name</div>
                            <div class="detail-value">{{ $internalProgram->name }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Phone</div>
                            <div class="detail-value">{{ $internalProgram->phone }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">{{ $internalProgram->email ?? 'N/A' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Blood Group</div>
                            <div class="detail-value">
                                <span class="blood-group">{{ $internalProgram->blood_group }}</span>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Present Address</div>
                            <div class="detail-value">
                                @if($internalProgram->upazila)
                                    <strong>{{ $internalProgram->upazila->name }}</strong>,
                                    {{ $internalProgram->upazila->district->name }},
                                    {{ $internalProgram->upazila->district->division->name }}
                                    @if($internalProgram->present_address)
                                        <br><span class="text-muted">{{ $internalProgram->present_address }}</span>
                                    @endif
                                @else
                                    {{ $internalProgram->present_address ?? 'N/A' }}
                                @endif
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">T-shirt Size</div>
                            <div class="detail-value">{{ $internalProgram->tshirt_size }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Event</div>
                            <div class="detail-value">
                                @if($internalProgram->event)
                                    <div class="event-badge">
                                        <i class="fa fa-calendar-check-o mr-1"></i> {{ $internalProgram->event->title }}
                                    </div>
                                    <div class="event-details">
                                        <h5>Event Details</h5>
                                        <p><strong>Date:</strong> {{ $internalProgram->event->start_date->format('M d, Y h:i A') }} to {{ $internalProgram->event->end_date->format('M d, Y h:i A') }}</p>
                                        <p><strong>Location:</strong> {{ $internalProgram->event->location ?? 'N/A' }}</p>
                                        <p><strong>Status:</strong> 
                                            <span class="badge {{ $internalProgram->event->status == 'active' ? 'badge-success' : 'badge-warning' }}">
                                                {{ ucfirst($internalProgram->event->status) }}
                                            </span>
                                            @if($internalProgram->event->is_featured)
                                                <span class="badge badge-featured ml-2">Featured</span>
                                            @endif
                                        </p>
                                        @if($internalProgram->event->event_fee)
                                            <p><strong>Fee:</strong> {{ $internalProgram->event->event_fee }} BDT</p>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">No event associated</span>
                                @endif
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Payment Method</div>
                            <div class="detail-value">{{ $internalProgram->payment_method }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Payment Amount</div>
                            <div class="detail-value">{{ $internalProgram->payment_amount ? $internalProgram->payment_amount . ' BDT' : 'N/A' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Transaction ID</div>
                            <div class="detail-value">{{ $internalProgram->trx_id ?? 'N/A' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Status</div>
                            <div class="detail-value">
                                @if ($internalProgram->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif ($internalProgram->status == 'approved')
                                    <span class="badge badge-success">Approved</span>
                                @else
                                    <span class="badge badge-danger">Rejected</span>
                                @endif
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Created At</div>
                            <div class="detail-value">{{ $internalProgram->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Updated At</div>
                            <div class="detail-value">{{ $internalProgram->updated_at->format('M d, Y h:i A') }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Payment Screenshot</div>
                            <div class="detail-value">
                                @if($internalProgram->screenshot)
                                    <div class="screenshot-container">
                                        <img src="{{ $internalProgram->screenshot_url }}" alt="Payment Screenshot" class="screenshot-img" id="screenshotImg" onclick="openImageModal()">
                                        <p class="mt-2 text-muted">Click on image to view full size</p>
                                    </div>
                                @else
                                    <span class="text-muted">No screenshot uploaded</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="status-form">
                        <h5>Update Status</h5>
                        <form action="{{ route('admin.internal-programs.update_status', $internalProgram->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="pending" {{ $internalProgram->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $internalProgram->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $internalProgram->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="modal">
    <span class="modal-close" onclick="closeImageModal()">&times;</span>
    <img class="modal-content" id="modalImage">
</div>
@endsection

@section('scripts')
<script>
    // Image modal functions
    function openImageModal() {
        var modal = document.getElementById("imageModal");
        var img = document.getElementById("screenshotImg");
        var modalImg = document.getElementById("modalImage");
        
        modal.style.display = "block";
        modalImg.src = img.src;
    }
    
    function closeImageModal() {
        document.getElementById("imageModal").style.display = "none";
    }
    
    // Close modal when clicking outside the image
    window.onclick = function(event) {
        var modal = document.getElementById("imageModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection 