@extends('layouts.base')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <h3 class="page-title text-center p-2">
                        @if ($id === 0)
                            {{ __('Dodaj dawkowanie') }}
                        @else
                            {{ __('Edytuj dawkowanie') }}
                        @endif
                    </h3>

                    <div class="p-3">
                        <form class="form-horizontal" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">{{ __('Lek') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="medicines_id">
                                        @foreach ($medicines as $medicine)
                                            <option value="{{ $medicine->id }}" @if($medicine->id == $medicinesDose?->medicines->id ?? old('medicines_id')) selected @endif>
                                                {{ $medicine->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ __('Dawka') }}</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control" name="amount" value="{{ $medicinesDose?->amount ?? old('amount') }}" placeholder="0" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">mg/ml</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ __('Domyślna jednostka') }}</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control" name="default_unit" value="{{ $medicinesDose?->default_unit ?? old('default_unit') }}" placeholder="0" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">mg/ml</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">{{ __('Harmonogram') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="schedule">
                                        @foreach ($schedules as $schedule)
                                            <option value="{{ $schedule }}" @if($schedule == $medicinesDose?->schedule ?? old('schedule')) selected @endif>
                                                {{ __('schedules.' . $schedule) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ __('Status') }}</label>
                                <div class="col-md-10">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="active" @if($medicinesDose?->active ?? old('active') ?? 1) checked @endif>
                                        <label class="custom-control-label" for="customSwitch1">{{ __('Aktywne') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"></label>
                                <div class="col-md-10">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">{{ __('Zapisz') }}</button>
                                    <a href="{{ route('medicines.dose') }}">
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
