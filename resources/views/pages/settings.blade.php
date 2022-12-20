@extends('layouts.base')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <h3 class="page-title text-center p-2">
                        {{ __('Edytuj ustawienia') }}
                    </h3>

                    <div class="p-3">
                        <form class="form-horizontal" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ __('Nowe hasło') }}</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="password" id="password" name="password" required="" placeholder="{{ __('Podaj nowe hasło') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"></label>
                                <div class="col-md-10">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">{{ __('Zapisz') }}</button>
                                    <a href="{{ route('dashboard') }}">
                                        <button type="button" class="btn btn-danger waves-effect waves-light">{{ __('Anuluj') }}</button>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- end container-fluid -->
@endsection
