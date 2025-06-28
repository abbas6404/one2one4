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
    
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .status-pending {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    .status-approved {
        background-color: rgba(0, 123, 255, 0.1);
        color: #007bff;
    }
    
    .status-completed {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .status-rejected {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .stats-card {
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        margin-bottom: 1.5rem;
        padding: 1.25rem;
        text-align: center;
    }
    
    .stats-card .icon {
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    
    .stats-card .count {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stats-card .label {
        color: #6c757d;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stats-card.pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .stats-card.approved {
        background-color: #cce5ff;
        color: #004085;
    }
    
    .stats-card.completed {
        background-color: #d4edda;
        color: #155724;
    }
    
    .stats-card.rejected {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .donor-info {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    /* Print button positioning */
    div.dt-buttons {
        position: relative;
        float: right;
        margin-top: 15px;
        margin-bottom: 15px;
        clear: both;
    }
    
    .left-col {
        float: left;
    }
    
    .right-col {
        float: right;
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
    <!-- Statistics Section -->
    <div class="row mt-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card pending">
                <div class="icon">
                    <i class="fa fa-hourglass-half"></i>
                </div>
                <div class="count">{{ $bloodDonations->where('status', 'pending')->count() }}</div>
                <div class="label">Pending</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card approved">
                <div class="icon">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="count">{{ $bloodDonations->where('status', 'approved')->count() }}</div>
                <div class="label">Approved</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card completed">
                <div class="icon">
                    <i class="fa fa-heart"></i>
                </div>
                <div class="count">{{ $bloodDonations->where('status', 'completed')->count() }}</div>
                <div class="label">Completed</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card rejected">
                <div class="icon">
                    <i class="fa fa-times-circle"></i>
                </div>
                <div class="count">{{ $bloodDonations->where('status', 'rejected')->count() }}</div>
                <div class="label">Rejected</div>
            </div>
        </div>
    </div>

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
                    <div class="print-button-container text-right mb-3">
                        <!-- Print button will be moved here via JavaScript -->
                    </div>
                    <div class="table-responsive">
                        <table id="donationsTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="15%">Donor</th>
                                    <th width="10%">Blood Type</th>
                                    <th width="10%">Status</th>
                                    <th width="15%">Request</th>
                                    <th width="15%">Donation Date</th>
                                    <th width="15%">Volume</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bloodDonations as $donation)
                                <tr>
                                    <td>{{ $donation->id }}</td>
                                    <td>
                                        <div class="donor-name">{{ $donation->donor->name ?? 'N/A' }}</div>
                                        @if($donation->donor)
                                            <div class="donor-info">
                                                <small>
                                                    <i class="fa fa-tint"></i> Total: {{ $donation->donor->total_blood_donation ?? 0 }}
                                                    @if($donation->donor->last_donation_date)
                                                        <br><i class="fa fa-calendar"></i> Last: {{ $donation->donor->last_donation_date->format('M d, Y') }}
                                                    @endif
                                                </small>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($donation->donor && $donation->donor->blood_group)
                                            <span class="blood-type">{{ $donation->donor->blood_group }}</span>
                                        @else
                                            <span class="blood-type bg-light text-muted">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $donation->status }}">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($donation->bloodRequest)
                                            <a href="{{ route('admin.blood_requests.show', $donation->bloodRequest->id) }}" class="request-link">
                                                Request #{{ $donation->bloodRequest->id }}
                                            </a>
                                            <div class="donor-info">
                                                {{ $donation->bloodRequest->hospital_name ?? 'N/A' }}
                                            </div>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="donation-date">
                                        {{ $donation->donation_date ? $donation->donation_date->format('M d, Y') : 'Not donated yet' }}
                                    </td>
                                    <td>
                                        {{ $donation->volume ? $donation->volume . ' ml' : 'N/A' }}
                                    </td>
                                    <td>
                                        @if(Auth::guard('admin')->user()->can('blood.donation.view'))
                                            <a class="btn btn-info btn-sm mb-1" 
                                               href="{{ route('admin.blood_donations.show', ['donation' => $donation->id]) }}">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                        @endif
                                        
                                        @if(Auth::guard('admin')->user()->can('blood.donation.edit'))
                                            <a class="btn btn-primary btn-sm mb-1" 
                                               href="{{ route('admin.blood_donations.edit', ['donation' => $donation->id]) }}">
                                                <i class="fa fa-edit"></i> Edit
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
            // Initialize DataTable
            var table = $('#donationsTable').DataTable({
                responsive: true,
                dom: '<"top"<"left-col"l><"right-col"f>>rt<"bottom"<"left-col"i><"right-col"p>>',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                order: [[0, 'desc']]
            });
            
            // Create print button separately
            var printBtn = $('<button class="btn btn-sm btn-info"><i class="fa fa-print"></i> Print</button>');
            $('.print-button-container').append(printBtn);
            
            // Add click event to print button
            printBtn.on('click', function() {
                // Create a new window with only the table data
                var printWindow = window.open('', '_blank');
                var tableHtml = '<html><head><title>Blood Donations</title>';
                tableHtml += '<style>';
                tableHtml += 'body { font-family: Arial, sans-serif; }';
                tableHtml += 'table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }';
                tableHtml += 'th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }';
                tableHtml += 'th { background-color: #f2f2f2; }';
                tableHtml += 'h2 { text-align: center; margin-bottom: 20px; }';
                tableHtml += '.blood-type { font-weight: bold; color: #dc3545; }';
                tableHtml += '.status-badge { font-weight: bold; }';
                tableHtml += '.status-pending { color: #ffc107; }';
                tableHtml += '.status-approved { color: #007bff; }';
                tableHtml += '.status-completed { color: #28a745; }';
                tableHtml += '.status-rejected { color: #dc3545; }';
                tableHtml += '</style>';
                tableHtml += '</head><body>';
                tableHtml += '<h2>Blood Donations Report</h2>';
                
                // Clone the table and remove the action column
                var $tableClone = $('#donationsTable').clone();
                $tableClone.find('tr').each(function() {
                    $(this).find('th:last-child, td:last-child').remove();
                });
                
                tableHtml += $tableClone.prop('outerHTML');
                tableHtml += '<div style="text-align: center; margin-top: 20px;">';
                tableHtml += '<p>Generated on: ' + new Date().toLocaleString() + '</p>';
                tableHtml += '</div>';
                tableHtml += '</body></html>';
                
                printWindow.document.write(tableHtml);
                printWindow.document.close();
                
                // Wait for the window to load before printing
                printWindow.onload = function() {
                    printWindow.print();
                };
            });
        });
    </script>
@endsection 