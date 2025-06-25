@extends('backend.layouts.master')

@section('title')
Blood Donations
@endsection

@section('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        padding: 1rem 1.35rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .header-title {
        margin-bottom: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
    }
    .blood-type {
        font-weight: 600;
        color: #dc3545;
        background-color: rgba(220, 53, 69, 0.1);
        padding: 4px 8px;
        border-radius: 4px;
    }
    .donor-name {
        font-weight: 500;
        color: #333;
    }
    .donation-date {
        color: #555;
    }
    .table thead th {
        background-color: #f8f9fc;
        color: #333;
        font-weight: 600;
        border-bottom: 2px solid #e3e6f0;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    .table tbody td {
        vertical-align: middle;
        border-color: #e3e6f0;
        padding: 0.75rem;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }
    .btn-view {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    .btn-view:hover {
        background-color: #2e59d9;
        border-color: #2e59d9;
    }
    .btn-edit {
        background-color: #1cc88a;
        border-color: #1cc88a;
    }
    .btn-edit:hover {
        background-color: #17a673;
        border-color: #17a673;
    }
    .request-link {
        color: #4e73df;
        font-weight: 500;
        text-decoration: none;
    }
    .request-link:hover {
        text-decoration: underline;
    }
    .dataTables_wrapper .dataTables_length, 
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }
    .dataTables_wrapper .dataTables_info {
        padding-top: 1rem;
        font-size: 0.9rem;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem 0.75rem;
        margin-left: 0.25rem;
        border: 1px solid #e3e6f0;
        border-radius: 0.25rem;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #4e73df;
        color: white !important;
        border-color: #4e73df;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #eaecf4;
        color: #333 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #2e59d9;
        color: white !important;
    }
    .dataTables_filter input {
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
    }
    .dataTables_length select {
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Blood Donations</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>Blood Donations</span></li>
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
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Blood Donation List</h4>
                    @if(Auth::guard('admin')->user()->can('blood.donation.create'))
                    <a href="{{ route('admin.blood_donations.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Add New Donation
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="donationsTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="15%">Donor</th>
                                    <th width="10%">Blood Type</th>
                                    <th width="15%">Request</th>
                                    <th width="20%">Hospital</th>
                                    <th width="15%">Donation Date</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bloodDonations as $donation)
                                <tr>
                                    <td>{{ $donation->id }}</td>
                                    <td class="donor-name">{{ $donation->donor->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($donation->donor && $donation->donor->blood_group)
                                            <span class="blood-type">{{ $donation->donor->blood_group }}</span>
                                        @else
                                            <span class="blood-type bg-light text-muted">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($donation->bloodRequest)
                                            <a href="{{ route('admin.blood_requests.show', $donation->bloodRequest->id) }}" class="request-link">
                                                Request #{{ $donation->bloodRequest->id }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($donation->bloodRequest)
                                            {{ $donation->bloodRequest->hospital_name }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="donation-date">
                                        {{ $donation->donation_date ? $donation->donation_date->format('M d, Y') : 'Not donated yet' }}
                                    </td>
                                    <td>
                                        @if(Auth::guard('admin')->user()->can('blood.donation.view'))
                                            <a class="btn-info text-white btn-sm mb-1" 
                                               href="{{ route('admin.blood_donations.show', ['donation' => $donation->id]) }}">
                                                <i class="fa fa-eye"></i> View
                                            </a>
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

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
@endsection

@section('scripts')
    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#donationsTable').DataTable({
                responsive: true,
                dom: '<"top"<"left-col"l><"center-col"B><"right-col"f>>rtip',
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Print',
                        className: 'btn btn-sm btn-info',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }
                ],
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                order: [[0, 'desc']]
            });
        });
    </script>
@endsection 