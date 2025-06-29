<div class="user-profile pull-right">
    {{-- <img class="avatar user-thumb" src="{{ asset('backend/assets/images/author/avatar.png') }}" alt="avatar"> --}}
    <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
    {{ Auth::guard('admin')->user()->name }}
    <i class="fa fa-angle-down"></i></h4>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('admin.profile.change-password') }}">
            <i class="fa fa-key"></i> Change Password
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('admin.logout') }}"
        onclick="event.preventDefault();
                      document.getElementById('admin-logout-form').submit();">
            <i class="fa fa-sign-out-alt"></i> Log Out
        </a>
    </div>

    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>