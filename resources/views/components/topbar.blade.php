<!-- Topbar Start -->
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{ asset('images/man.svg') }}" alt="user-image" class="rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome {{ Auth::user()?->name }} !</h6>
                </div>

                <!-- item-->
                <a href="{{ route('settings') }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-settings-outline"></i>
                    <span>Settings</span>
                </a>

                <div class="dropdown-divider"></div>

                <!-- item-->
                <a class="dropdown-item notify-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="mdi mdi-logout-variant"></i>
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>

    </ul>

    <!-- LOGO -->

    <div class="logo-box">
        <a href="{{ route('dashboard') }}" class="logo text-center mt-3">
            <h3 class="text-white">{{ config('app.name', 'Lekoman') }}</h3>
        </a>
    </div>

</div>
<!-- end Topbar -->
