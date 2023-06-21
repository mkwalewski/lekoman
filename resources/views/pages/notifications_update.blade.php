@extends('layouts.base')

@section('styles')
    <link href="{{ asset('libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <h3 class="page-title text-center p-2">
                        @if ($id === 0)
                            {{ __('Dodaj notyfikację') }}
                        @else
                            {{ __('Edytuj notyfikację') }}
                        @endif
                    </h3>

                    <div class="p-3">
                        <form class="form-horizontal" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">{{ __('Harmonogram') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="schedule">
                                        @foreach ($schedules as $schedule)
                                            <option value="{{ $schedule }}" @if($schedule == $notification?->schedule ?? old('schedule')) selected @endif>
                                                {{ __('schedules.' . $schedule) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">{{ __('Zaczyna się o') }}</label>
                                <div class="col-sm-10 input-group">
                                    <input type="text" class="form-control time_start" name="start_at" value="{{ $notification->start_at ?? old('start_at') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-danger text-white"><i class="mdi mdi-clock-outline"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">{{ __('Kończy się o') }}</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control time_end" name="end_at" value="{{ $notification->end_at ?? old('end_at') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-danger text-white"><i class="mdi mdi-clock-outline"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-text">
                                        Czas "0:00" jest traktowany jako null.
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ __('Powtarzaj co') }}</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="repeat_every" value="{{ $notification->repeat_every ?? old('repeat_every') }}" required placeholder="{{ __('e.g. 1h') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ __('Licznik powótrzeń') }}</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="repeat_count" value="{{ $notification->repeat_count ?? old('repeat_count') }}" required placeholder="{{ __('e.g. 1x') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ __('Wiadomość (pierwsza)') }}</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="message" required>{{ $notification->message ?? old('message') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ __('Wiadomość (powtórzenia)') }}</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="repeated_message">{{ $notification->repeated_message ?? old('repeated_message') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ __('Status') }}</label>
                                <div class="col-md-10">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="active" @if($notification?->active ?? old('active') ?? 1) checked @endif>
                                        <label class="custom-control-label" for="customSwitch1">{{ __('Aktywne') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"></label>
                                <div class="col-md-10">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">{{ __('Zapisz') }}</button>
                                    <a href="{{ route('notifications.list') }}">
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

@section('scripts')
    <script src="{{ asset('libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script type="text/javascript">
        (function( $ ){
            $('.time_start').timepicker({
                minuteStep: 5,
                defaultTime: '{{ Config::get('notification.default_start_time') }}',
                showMeridian: false,
                icons: {up: "mdi mdi-chevron-up", down: "mdi mdi-chevron-down"}
            });
            $('.time_end').timepicker({
                minuteStep: 5,
                defaultTime: '{{ Config::get('notification.empty_time') }}',
                showMeridian: false,
                icons: {up: "mdi mdi-chevron-up", down: "mdi mdi-chevron-down"}
            });
        })( jQuery );
    </script>
@endsection
