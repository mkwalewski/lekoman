@extends('layouts.base')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <h3 class="page-title text-center p-2">
                        {{ __('Weź leki') }}
                        <a href="#take-modal-mood" class="btn btn-primary btn-xs waves-effect waves-light float-left"
                           data-animation="blur"
                           data-plugin="custommodal"
                           data-overlaySpeed="100"
                           data-overlayColor="#38414a">
                            <i class="fas fa-grin mr-1"></i> <span>{{ __('Samopoczucie') }}</span>
                        </a>
                        <!-- Modal -->
                        <div id="take-modal-mood" class="modal-demo">
                            <button type="button" class="close" onclick="Custombox.modal.close();">
                                <span>&times;</span><span class="sr-only">Close</span>
                            </button>
                            <h4 class="custom-modal-title">{{ __('Wybierz samopoczucie') }}</h4>
                            <div class="custom-modal-text text-center">
                                <form action="{{ route('medicines.moods') }}" method="post">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">{{ __('Samopoczucie') }}</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="moods_id">
                                                @foreach($moods as $value => $mood)
                                                    <option value="{{ $mood->id }}">{{ $mood->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success waves-effect waves-light">
                                        <span>{{ __('Zapisz') }}</span>
                                    </button>
                                    <a href="javascript:void(0);" onclick="Custombox.modal.close();">
                                        <button type="button" class="btn btn-danger waves-effect waves-light">
                                            <span>{{ __('Anuluj') }}</span>
                                        </button>
                                    </a>
                                </form>
                            </div>
                        </div>
                    </h3>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Lek</th>
                                    <th scope="col">Dawka</th>
                                    <th scope="col">Wzięto</th>
                                    <th scope="col">Pozostalo</th>
                                    <th scope="col">Harmonogram</th>
                                    <th scope="col">Jednostka</th>
                                    <th scope="col">Akcja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doses as $dose)
                                    <tr class="table-{{ HttpHelper::getClassForPercentage($dose->schedule, $dose->left_percent) }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $dose->medicines->name }}</td>
                                        <td>{{ $dose->amount }} {{ $dose->medicines->unit }}</td>
                                        <td>{{ $dose->take_amount }} {{ $dose->medicines->unit }}</td>
                                        <td>{{ $dose->left_amount }} {{ $dose->medicines->unit }}</td>
                                        <td>{{ __('schedules.' . $dose->schedule) }}</td>
                                        <td>
                                            @foreach ($dose->medicines->units as $unit)
                                                <span class="badge badge-pill badge-primary font-13">{{ $unit->amount }} {{ $dose->medicines->unit }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="#take-modal-{{ $dose->id }}" class="btn btn-success btn-sm waves-effect waves-light"
                                               data-animation="blur"
                                               data-plugin="custommodal"
                                               data-overlaySpeed="100"
                                               data-overlayColor="#38414a">
                                                <i class="fas fa-pills mr-1"></i> <span>{{ __('Weź') }}</span>
                                            </a>
                                            <!-- Modal -->
                                            <div id="take-modal-{{ $dose->id }}" class="modal-demo">
                                                <button type="button" class="close" onclick="Custombox.modal.close();">
                                                    <span>&times;</span><span class="sr-only">Close</span>
                                                </button>
                                                <h4 class="custom-modal-title">{{ __('Wybierz dawkę') }}</h4>
                                                <div class="custom-modal-text text-center">
                                                    <form action="{{ route('medicines.take') }}" method="post">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">{{ __('Dawka') }}</label>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="amount">
                                                                    @foreach(App\Models\MedicinesDoses::getUnitsForTake($dose->medicines->units) as $value => $option)
                                                                        <option value="{{ $value }}" @if($dose->default_unit == $value) selected @endif>{{ $option }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="medicines_id" value="{{ $dose->medicines->id }}" />
                                                        <button type="submit" class="btn btn-success waves-effect waves-light">
                                                            <span>{{ __('Weź') }}</span>
                                                        </button>
                                                        <a href="javascript:void(0);" onclick="Custombox.modal.close();">
                                                            <button type="button" class="btn btn-danger waves-effect waves-light">
                                                                <span>{{ __('Anuluj') }}</span>
                                                            </button>
                                                        </a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- end container-fluid -->
@endsection
