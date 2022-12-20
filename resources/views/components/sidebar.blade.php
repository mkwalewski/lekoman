<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li class="menu-title">{{ __('Nawigacja') }}</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="mdi mdi-speedometer"></i>
                        <span> {{ __('Tablica') }} </span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-pill"></i>
                        <span> {{ __('Leki') }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{{ route('medicines.list') }}">{{ __('Lista leków') }}</a></li>
                        <li><a href="{{ route('medicines.dose') }}">{{ __('Dawkowanie') }}</a></li>
                        <li><a href="{{ route('medicines.take') }}">{{ __('Weź leki') }}</a></li>
                        <li><a href="{{ route('medicines.history') }}">{{ __('Historia') }}</a></li>
                        <li><a href="{{ route('medicines.charts') }}">{{ __('Wykresy') }}</a></li>
                    </ul>
                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
