<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Blood Connect') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            padding-bottom: 70px; /* Space for mobile navigation */
        }
        
        .sidebar {
            background: linear-gradient(180deg, #1e2a3a 0%, #1a1f24 100%);
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 0;
        }

        .sidebar-sticky {
            position: sticky;
            top: 0;
            height: 100vh;
            padding-top: .5rem;
            padding-bottom: 120px; /* Increased padding at the bottom */
            overflow-x: hidden;
            overflow-y: auto;
        }

        .nav-link {
            padding: 0.75rem 1rem;
            color: rgba(255,255,255,0.8) !important;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff !important;
        }

        .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: #fff !important;
            border-left: 3px solid #dc3545;
            border-right: none;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 16.666667%;
            margin-right: 0;
        }

        /* Added styles for collapsed sidebar */
        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed h4 {
            display: none;
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .badge {
            padding: 0.5em 1em;
        }

        .user-info img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        /* Mobile Specific Styles */
        .mobile-topbar {
            background: #1a1f24;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            color: white;
            height: 60px;
            padding: 0;
        }
        
        .mobile-topbar .logo-wrapper {
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            z-index: 5;
        }

        .mobile-topbar .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            order: 1;
        }

        .mobile-topbar .actions {
            order: 2;
            text-align: right;
            z-index: 10;
        }

        .mobile-topbar .logo i {
            color: #dc3545;
        }

        .mobile-topbar .actions button {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
        }

        .mobile-bottomnav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 1100;
        }

        .mobile-bottomnav ul {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            justify-content: space-around;
        }

        .mobile-bottomnav li {
            flex: 1;
            text-align: center;
        }

        .mobile-bottomnav a {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 5px;
            color: #6c757d;
            text-decoration: none;
            font-size: 0.75rem;
        }

        .mobile-bottomnav a.active {
            color: #dc3545;
        }

        .mobile-bottomnav i {
            font-size: 1.2rem;
            margin-bottom: 4px;
        }

        .status-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .status-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .status-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
        }

        .status-info h3 {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
        }

        .status-info p {
            font-size: 0.8rem;
            color: #6c757d;
            margin: 0;
        }

        .status-pending .status-icon {
            background-color: #dc3545;
        }

        .status-completed .status-icon {
            background-color: #28a745;
        }

        .status-progress .status-icon {
            background-color: #007bff;
        }

        .status-total .status-icon {
            background-color: #fd7e14;
        }

        .filter-tabs {
            display: flex;
            overflow-x: auto;
            margin-bottom: 15px;
            padding-bottom: 5px;
        }

        .filter-tabs .tab {
            padding: 8px 20px;
            border: 1px solid #dee2e6;
            background: white;
            margin-right: 10px;
            border-radius: 20px;
            white-space: nowrap;
            font-size: 0.9rem;
        }

        .filter-tabs .tab.active {
            background: #f8f9fa;
            font-weight: 500;
        }

        .request-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .request-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .blood-type {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #dc3545;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
        }

        .request-info h3 {
            font-size: 1.1rem;
            margin: 0;
        }

        .request-info p {
            font-size: 0.8rem;
            color: #6c757d;
            margin: 0;
        }

        .request-status {
            margin-left: auto;
            background: #e9ecef;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .request-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .detail-item {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }

        .detail-item label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 5px;
            display: block;
        }

        .detail-item p {
            margin: 0;
            font-weight: 500;
        }

        .urgency-normal {
            color: #007bff;
            background: #e7f5ff;
            display: inline-block;
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 0.8rem;
        }

        /* Media Queries */
        @media (max-width: 1080px) {
            body {
                padding-top: 60px;
            }
            
            .sidebar {
                position: fixed;
                height: 100%;
                left: auto;
                right: -280px; /* Start off-screen */
                transition: all 0.3s ease;
                z-index: 1050; /* Higher than topbar */
                box-shadow: -2px 0 5px rgba(0,0,0,0.1);
                width: 280px;
                top: 0;
            }
            
            .sidebar.show {
                right: 0;
            }
            
            /* Add overlay when sidebar is open */
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0,0,0,0.5);
                z-index: 1045;
                display: none;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .main-content {
                margin-left: 0 !important;
                margin-right: 0;
                padding: 10px 15px;
                width: 100%;
            }
            
            .mobile-topbar {
                display: flex !important;
            }
            
            .mobile-bottomnav {
                display: block;
            }
            
            .sidebar-toggler {
                display: none;
            }
            
            .d-lg-none {
                display: block !important;
            }
            
            .d-none.d-lg-block {
                display: none !important;
            }
            
            .d-none.d-lg-flex {
                display: none !important;
            }
        }

        /* App View Specific Styles for Tablets (768px - 1080px) */
        @media (min-width: 768px) and (max-width: 1080px) {
            .status-cards {
                grid-template-columns: repeat(4, 1fr);
            }

            .request-card {
                display: flex;
                flex-direction: column;
            }

            .mobile-bottomnav a {
                font-size: 0.85rem;
            }

            .mobile-bottomnav i {
                font-size: 1.4rem;
            }

            .mobile-topbar h5 {
                font-size: 1.2rem;
            }
        }

        /* Add more space to the logout button */
        .sidebar .mt-3 {
            margin-bottom: 70px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Mobile Top Bar -->
    <div class="mobile-topbar d-lg-none">
        <div style="position: relative; height: 60px;">
            <!-- Logo and site name in center -->
            <div style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); text-align: center; width: auto; white-space: nowrap;">
                @php
                    $siteLogo = \App\Models\WebsiteContent::where('key', 'site.logo')->where('is_active', true)->first();
                    $siteName = \App\Models\WebsiteContent::where('key', 'site.name')->where('is_active', true)->first();
                @endphp
                <img src="{{ asset($siteLogo ? $siteLogo->content : 'images/logo.jpeg') }}" alt="Logo" height="30" class="rounded-circle" style="vertical-align: middle;">
                @if($siteName)
                    <span class="ms-2" style="vertical-align: middle;">{{ $siteName->content }}</span>
                @endif
            </div>
            
            <!-- Menu button always at right -->
            <button id="mobileMenuBtn" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: white; font-size: 1.5rem; padding: 0; margin: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 sidebar" id="mainSidebar">
                <div class="sidebar-sticky">
                    <div class="py-4 position-relative">
                        <!-- Close button for mobile -->
                        <button id="closeSidebarBtn" class="position-absolute top-0 end-0 mt-3 me-3 btn text-white d-lg-none" style="background: rgba(255,255,255,0.2); width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: none; z-index: 10; box-shadow: 0 0 5px rgba(0,0,0,0.2);">
                            <i class="fas fa-times" style="font-size: 18px;"></i>
                        </button>
                        
                        <a href="{{ route('home') }}" class="text-white text-decoration-none">
                            @php
                                $siteLogo = \App\Models\WebsiteContent::where('key', 'site.logo')->where('is_active', true)->first();
                                $siteName = \App\Models\WebsiteContent::where('key', 'site.name')->where('is_active', true)->first();
                            @endphp
                            <div class="d-flex align-items-center ps-3" style="justify-content: flex-start;">
                                <img src="{{ asset($siteLogo ? $siteLogo->content : 'images/logo.jpeg') }}" alt="Logo" height="30" class="rounded-circle" style="vertical-align: middle;">
                                <span class="ms-2 h4 mb-0">{{ $siteName ? $siteName->content : 'BloodConnect' }}</span>
                            </div>
                        </a>
                    </div>

                    <!-- Sidebar Toggle Button for Mobile -->
                    <div class="d-block d-lg-none text-end ps-3 pe-3 mb-2 d-none">
                        <!-- Button hidden as we moved it above -->
                    </div>

                    <!-- Navigation Menu -->
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" 
                               href="{{ route('user.dashboard') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.donors.index') ? 'active' : '' }}" 
                               href="{{ route('user.donors.index') }}">
                                <i class="fas fa-users"></i> Donor List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.blood-requests.index') ? 'active' : '' }}" 
                               href="{{ route('user.blood-requests.index') }}">
                                <i class="fas fa-tint"></i> Blood Requests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.my-donors') ? 'active' : '' }}" 
                               href="{{ route('user.my-donors') }}">
                                <i class="fas fa-user-friends"></i> My Donors
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.donation.history') ? 'active' : '' }}" 
                               href="{{ route('user.donation.history') }}">
                                <i class="fas fa-history"></i> Donation History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}" 
                               href="{{ route('user.profile') }}">
                                <i class="fas fa-user"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.calendar') ? 'active' : '' }}" 
                               href="{{ route('user.calendar') }}">
                                <i class="fas fa-calendar"></i> Calendar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.notifications') ? 'active' : '' }}" 
                               href="{{ route('user.notifications') }}">
                                <i class="fas fa-bell"></i> Notifications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.settings') ? 'active' : '' }}" 
                               href="{{ route('user.settings') }}">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                        </li>
                    </ul>

                    <!-- Logout -->
                    <div class="mt-3">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link text-white border-0 bg-transparent w-100">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-lg-10 main-content px-lg-4 px-3 app-container" id="mainContent">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-bottomnav d-lg-none">
        <ul>
            <li>
                <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.donors.index') }}" class="{{ request()->routeIs('user.donors.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Donor</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.blood-requests.index') }}" class="{{ request()->routeIs('user.blood-requests.*') ? 'active' : '' }}">
                    <i class="fas fa-tint"></i>
                    <span>Request</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.my-donors') }}" class="{{ request()->routeIs('user.my-donors') ? 'active' : '' }}">
                    <i class="fas fa-user-friends"></i>
                    <span>My Donors</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        // Mobile Menu Toggle - Improved reliability
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const closeSidebarBtn = document.getElementById('closeSidebarBtn');
            const sidebar = document.getElementById('mainSidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            function openSidebar() {
                sidebar.classList.add('show');
                sidebarOverlay.classList.add('show');
                document.body.style.overflow = 'hidden'; // Prevent scrolling when sidebar is open
            }
            
            function closeSidebar() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                document.body.style.overflow = '';
            }
            
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    openSidebar();
                });
            }
            
            if (closeSidebarBtn) {
                closeSidebarBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeSidebar();
                });
            }
            
            // Close sidebar when clicking overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    closeSidebar();
                });
            }
            
            // Close sidebar when clicking outside
            document.addEventListener('click', function(event) {
                if (
                    sidebar && 
                    sidebar.classList.contains('show') && 
                    !sidebar.contains(event.target) && 
                    event.target !== mobileMenuBtn &&
                    !mobileMenuBtn.contains(event.target)
                ) {
                    closeSidebar();
                }
            });
            
        // Add keyboard shortcut for sidebar toggle
        document.addEventListener('keydown', function(e) {
            // Check if Ctrl+B was pressed
            if (e.ctrlKey && e.key === 'b') {
                e.preventDefault();
                    if (window.innerWidth <= 1080) {
                        if (sidebar.classList.contains('show')) {
                            closeSidebar();
                        } else {
                            openSidebar();
                        }
                    } else {
                const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
                if (sidebarToggleBtn) {
                    sidebarToggleBtn.click();
                }
            }
                }
                
                // Also close on ESC key
                if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                    closeSidebar();
                }
            });
            
            // Desktop sidebar toggle
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            if (sidebarToggleBtn) {
                sidebarToggleBtn.addEventListener('click', function() {
                    mainContent.classList.toggle('expanded');
                    sidebar.classList.toggle('collapsed');
                });
            }
            
            // Fix for touch events on mobile
            if (sidebar) {
                sidebar.addEventListener('touchstart', function(e) {
                    e.stopPropagation();
                }, {passive: true});
            }
            
            // Ensure toggle buttons are properly initialized
            console.log('Mobile menu button exists:', !!mobileMenuBtn);
            console.log('Close sidebar button exists:', !!closeSidebarBtn);
            console.log('Sidebar exists:', !!sidebar);
            
            // Force redraw sidebar on window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 1080) {
                    sidebar.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>
    
    <!-- Auto-hide alerts after 5 seconds -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>
    @stack('scripts')
</body>
</html> 