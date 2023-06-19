<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Lekoman') }} {{ __('Admin Dashboard') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css"  id="app-stylesheet" />

    <!-- Custom box css -->
    <link href="{{ asset('libs/custombox/custombox.min.css') }}" rel="stylesheet">

    <!-- Custom styles -->
    @yield('styles')
</head>

<body>

<!-- Begin page -->
<div id="wrapper">

    @component('components.topbar')
    @endcomponent

    @component('components.sidebar')
    @endcomponent

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">

        @if (Session::has('alerts'))
            @foreach(Session::get('alerts') as $type => $message)
                <div class="alert alert-{{ $type }} mt-2">
                    {{ $message }}
                </div>
            @endforeach
        @endif

        <div class="content">
            @yield('content')
        </div> <!-- end content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        2023 &copy; {{ config('app.name', 'Lekoman') }}
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

<!-- Vendor js -->
<script src="{{ asset('js/vendor.min.js') }}"></script>

<!-- Modal-Effect -->
<script src="{{ asset('libs/custombox/custombox.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('js/app.min.js') }}"></script>

<!-- Custom scripts -->
@yield('scripts')

</body>
</html>
