<!-- sidebar menu area start -->
@php
    $usr = Auth::guard('admin')->user();
@endphp
<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <h2 class="text-white">Admin</h2> 
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">

                    @if ($usr->can('dashboard.view'))
                    <li class="active">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>dashboard</span></a>
                        <ul class="collapse">
                            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('role.create') || $usr->can('role.view') ||  $usr->can('role.edit') ||  $usr->can('role.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                            Roles & Permissions
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.roles.create') || Route::is('admin.roles.index') || Route::is('admin.roles.edit') || Route::is('admin.roles.show') ? 'in' : '' }}">
                            @if ($usr->can('role.view'))
                                <li class="{{ Route::is('admin.roles.index')  || Route::is('admin.roles.edit') ? 'active' : '' }}"><a href="{{ route('admin.roles.index') }}">All Roles</a></li>
                            @endif
                            @if ($usr->can('role.create'))
                                <li class="{{ Route::is('admin.roles.create')  ? 'active' : '' }}"><a href="{{ route('admin.roles.create') }}">Create Role</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('admin.create') || $usr->can('admin.view') ||  $usr->can('admin.edit') ||  $usr->can('admin.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            Admins
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.admins.create') || Route::is('admin.admins.index') || Route::is('admin.admins.edit') || Route::is('admin.admins.show') ? 'in' : '' }}">
                            
                            @if ($usr->can('admin.view'))
                                <li class="{{ Route::is('admin.admins.index')  || Route::is('admin.admins.edit') ? 'active' : '' }}"><a href="{{ route('admin.admins.index') }}">All Admins</a></li>
                            @endif

                            @if ($usr->can('admin.create'))
                                <li class="{{ Route::is('admin.admins.create')  ? 'active' : '' }}"><a href="{{ route('admin.admins.create') }}">Create Admin</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('user.create') || $usr->can('user.view') ||  $usr->can('user.edit') ||  $usr->can('user.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-users"></i><span>
                            Users
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.users.create') || Route::is('admin.users.index') || Route::is('admin.users.edit') || Route::is('admin.users.show') ? 'in' : '' }}">
                            
                            @if ($usr->can('user.view'))
                                <li class="{{ Route::is('admin.users.index')  || Route::is('admin.users.edit') ? 'active' : '' }}"><a href="{{ route('admin.users.index') }}">All Users</a></li>
                            @endif

                            @if ($usr->can('user.create'))
                                <li class="{{ Route::is('admin.users.create')  ? 'active' : '' }}"><a href="{{ route('admin.users.create') }}">Create User</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('contact.view') || $usr->can('contact.update') || $usr->can('contact.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-envelope"></i><span>Contact Messages</span>
                        </a>
                        <ul class="collapse {{ Route::is('admin.contacts.*') ? 'in' : '' }}">
                            @if ($usr->can('contact.view'))
                            <li class="{{ Route::is('admin.contacts.index') || Route::is('admin.contacts.show') ? 'active' : '' }}">
                                <a href="{{ route('admin.contacts.index') }}">All Messages</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('location.view'))
                    <li>
                        <a href="{{ route('admin.locations.index') }}" aria-expanded="true">
                            <i class="fa fa-map-marker"></i><span>Location Management</span>
                        </a>
                    </li>
                    @endif

                    @if ($usr->can('blood.request.view'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-heartbeat"></i><span>Blood Requests</span>
                        </a>
                        <ul class="collapse {{ Route::is('admin.blood_requests.*') ? 'in' : '' }}">
                            <li class="{{ Route::is('admin.blood_requests.index') ? 'active' : '' }}">
                                <a href="{{ route('admin.blood_requests.index') }}">All Blood Requests</a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('blood.donation.view'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-medkit"></i><span>Blood Donations</span>
                        </a>
                        <ul class="collapse {{ Route::is('admin.blood_donations.*') ? 'in' : '' }}">
                            <li class="{{ Route::is('admin.blood_donations.index') ? 'active' : '' }}">
                                <a href="{{ route('admin.blood_donations.index') }}">All Blood Donations</a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('internal.program.view') || $usr->can('internal.program.create') || $usr->can('internal.program.edit'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-users"></i><span>Internal Programs</span>
                        </a>
                        <ul class="collapse {{ Route::is('admin.internal-programs.*') ? 'in' : '' }}">
                            @if ($usr->can('internal.program.view'))
                                <li class="{{ Route::is('admin.internal-programs.index') || Route::is('admin.internal-programs.show') ? 'active' : '' }}">
                                    <a href="{{ route('admin.internal-programs.index') }}">All Programs</a>
                                </li>
                            @endif
                            @if ($usr->can('internal.program.create'))
                                <li class="{{ Route::is('admin.internal-programs.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.internal-programs.create') }}">Add New Program</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('website.content.view'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-globe"></i><span>Web Template</span>
                        </a>
                        <ul class="collapse {{ Route::is('admin.web-template.*') ? 'in' : '' }}">
                            <li class="{{ Route::is('admin.web-template.index') ? 'active' : '' }}">
                                <a href="{{ route('admin.web-template.index') }}">Manage Template</a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('event.view') || $usr->can('event.create') || $usr->can('event.edit') || $usr->can('event.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-calendar"></i><span>Events</span>
                        </a>
                        <ul class="collapse {{ Route::is('admin.events.*') ? 'in' : '' }}">
                            @if ($usr->can('event.view'))
                                <li class="{{ Route::is('admin.events.index') || Route::is('admin.events.show') ? 'active' : '' }}">
                                    <a href="{{ route('admin.events.index') }}">All Events</a>
                                </li>
                            @endif
                            
                            @if ($usr->can('event.create'))
                                <li class="{{ Route::is('admin.events.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.events.create') }}">Create Event</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('gallery.view') || $usr->can('gallery.create') || $usr->can('gallery.edit') || $usr->can('gallery.delete') || $usr->can('gallery.category.view') || $usr->can('gallery.category.create') || $usr->can('gallery.category.edit') || $usr->can('gallery.category.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-image"></i><span>Gallery Management</span>
                        </a>
                        <ul class="collapse {{ Route::is('admin.gallery.*') || Route::is('admin.gallery-categories.*') ? 'in' : '' }}">
                            @if ($usr->can('gallery.view'))
                                <li class="{{ Route::is('admin.gallery.index') || Route::is('admin.gallery.show') ? 'active' : '' }}">
                                    <a href="{{ route('admin.gallery.index') }}">All Galleries</a>
                                </li>
                            @endif
                            @if ($usr->can('gallery.create'))
                                <li class="{{ Route::is('admin.gallery.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.gallery.create') }}">Add New Gallery</a>
                                </li>
                            @endif
                            @if ($usr->can('gallery.category.view'))
                                <li class="{{ Route::is('admin.gallery-categories.index') || Route::is('admin.gallery-categories.show') ? 'active' : '' }}">
                                    <a href="{{ route('admin.gallery-categories.index') }}">Gallery Categories</a>
                                </li>
                            @endif
                            @if ($usr->can('gallery.category.create'))
                                <li class="{{ Route::is('admin.gallery-categories.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.gallery-categories.create') }}">Add New Category</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    
                    @if ($usr->can('testimonial.view') || $usr->can('testimonial.create') || $usr->can('testimonial.edit') || $usr->can('testimonial.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-comments"></i><span>Testimonials</span>
                        </a>
                        <ul class="collapse {{ Route::is('admin.testimonials.*') ? 'in' : '' }}">
                            @if ($usr->can('testimonial.view'))
                                <li class="{{ Route::is('admin.testimonials.index') || Route::is('admin.testimonials.show') ? 'active' : '' }}">
                                    <a href="{{ route('admin.testimonials.index') }}">All Testimonials</a>
                                </li>
                            @endif
                            @if ($usr->can('testimonial.create'))
                                <li class="{{ Route::is('admin.testimonials.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.testimonials.create') }}">Add New Testimonial</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    
                    @if ($usr->can('sponsor.view') || $usr->can('sponsor.create') || $usr->can('sponsor.edit') || $usr->can('sponsor.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-star"></i><span>Sponsors</span>
                        </a>
                        <ul class="collapse {{ Route::is('admin.sponsors.*') ? 'in' : '' }}">
                            @if ($usr->can('sponsor.view'))
                                <li class="{{ Route::is('admin.sponsors.index') || Route::is('admin.sponsors.show') ? 'active' : '' }}">
                                    <a href="{{ route('admin.sponsors.index') }}">All Sponsors</a>
                                </li>
                            @endif
                            @if ($usr->can('sponsor.create'))
                                <li class="{{ Route::is('admin.sponsors.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.sponsors.create') }}">Add New Sponsor</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    <li>
                        <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                            <i class="fa fa-sign-out-alt"></i><span>Logout</span>
                        </a>
                        <form id="sidebar-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- sidebar menu area end -->