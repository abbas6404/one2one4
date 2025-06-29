<!-- filepath: c:\xampp\htdocs\laravel-role\resources\views\backend\pages\users\index.blade.php -->
@extends('backend.layouts.master')

@section('title')
Users - Admin Panel
@endsection

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Users</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>All Users</span></li>
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
                    <h4 class="header-title float-left">Users List</h4>
                    <p class="float-right mb-2">
                        <a class="btn btn-primary text-white" href="{{ route('admin.users.create') }}">Create New User</a>
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th width="10%">Name</th>
                                    <th width="10%">Email/Phone</th>
                                    <th width="10%">Blood Group</th>
                                    <th width="10%">Total Donations</th>
                                    <th width="15%">Location</th>
                                    <th width="10%">Created By</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($users as $user)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        {{ $user->email ?? 'N/A' }}
                                        @if($user->phone)
                                        <br><small>{{ $user->phone }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $user->blood_group ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $totalDonations = App\Models\BloodDonation::where('donor_id', $user->id)
                                                ->where('status', 'completed')
                                                ->count();
                                        @endphp
                                        <span class="badge badge-{{ $totalDonations > 0 ? 'success' : 'secondary' }}">
                                            {{ $totalDonations }}
                                        </span>
                                        @if($user->last_donation_date)
                                            <br><small>Last: {{ \Carbon\Carbon::parse($user->last_donation_date)->format('M d, Y') }}</small>
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        <small>
                                            {{ $user->getPresentDivisionAttribute() ?? 'N/A' }}, 
                                            {{ $user->getPresentDistrictAttribute() ?? 'N/A' }}, 
                                            {{ $user->getPresentSubDistrictAttribute() ?? 'N/A' }}, 
                                            <!-- {{ $user->getPresentAddressAttribute() ?? 'N/A' }} -->
                                        </small>
                                    </td>
                                    <td>
                                        @if($user->created_by)
                                            @php
                                                $admin = \App\Models\Admin::find($user->created_by);
                                            @endphp
                                            {{ $admin ? $admin->name : 'Unknown' }}
                                        @else
                                            Auto
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info text-white btn-sm mb-1" href="{{ route('admin.users.show', $user->id) }}">
                                            <i class="fa fa-eye"></i> View
                                        </a>

                                        <a class="btn btn-success text-white btn-sm mb-1" href="{{ route('admin.users.edit', $user->id) }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <a class="btn btn-danger text-white btn-sm" href="{{ route('admin.users.destroy', $user->id) }}"
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>

                                        <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection

@section('scripts')
     <!-- Start datatable js -->
     <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
     
     <script>
         /*================================
        datatable active
        ==================================*/
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }

     </script>
@endsection