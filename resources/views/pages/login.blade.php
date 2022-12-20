@extends('layouts.login')

@section('content')
    <div class="account-pages my-5 pt-md-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center pb-1">
                        <h5 class="font-20 text-muted mt-3">{{ config('app.name', 'Lekoman') }} {{ __('Admin Dashboard') }}</h5>
                    </div>
                    <div class="card mt-4">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <h5 class="text-uppercase">{{ __('Sign In') }}</h5>
                            </div>
                            <form method="POST" action="{{ route('login') }}" class="p-2">
                                @csrf
                                <div class="form-group mb-3">
                                    <input class="form-control @error('email') parsley-error @enderror" type="email" id="email" name="email" required="" placeholder="{{ __('Enter your email') }}" value="{{ old('email') }}">
                                    @error('email')
                                    <div class="font-14 text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input class="form-control @error('password') parsley-error @enderror" type="password" id="password" name="password" required="" placeholder="{{ __('Enter your password') }}">
                                    @error('password')
                                    <div class="font-14 text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <button class="btn btn-primary btn-bordered-primary btn-block waves-effect waves-light" type="submit"> {{ __('Log In') }} </button>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->
                    <!-- end row -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->
@endsection
