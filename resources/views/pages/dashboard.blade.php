@extends('layouts.base')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ __('Tablica') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            @foreach($doses as $dose)
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('medicines.take') }}">
                        <div class="card widget-user border-{{ HttpHelper::getClassForPercentage($dose->left_percent) }}">
                            <div class="card-body text-center">
                                <h3 class="text-primary">
                                    @if ($dose->left_percent > 0)
                                        <span class="badge badge-pill badge-{{ HttpHelper::getClassForPercentage($dose->left_percent) }} font-18">
                                        <i class="mdi mdi-exclamation"></i>
                                    </span>
                                    @endif
                                    {{ $dose->medicines->name }}
                                </h3>
                                <h5 class="font-16">
                                    {{ __('Pozostało') }} {{ $dose->left_amount }} {{ $dose->medicines->unit }} z {{ $dose->amount }} {{ $dose->medicines->unit }}
                                </h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <!-- end row -->

    </div> <!-- end container-fluid -->
@endsection
