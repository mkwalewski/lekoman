@extends('layouts.base')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <h3 class="page-title text-center p-2">
                        {{ __('Dawkowanie') }}
                        <a href="{{ route('medicines.dose.update', 0) }}">
                            <button class="btn btn-primary btn-xs waves-effect waves-light float-left">
                                <i class="fas fa-plus mr-1"></i> <span>{{ __('Dodaj') }}</span>
                            </button>
                        </a>
                    </h3>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Lek</th>
                                    <th scope="col">Dawka</th>
                                    <th scope="col">Harmonogram</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Akcja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doses as $dose)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $dose->medicines->name }}</td>
                                        <td>{{ $dose->amount }} {{ $dose->medicines->unit }}</td>
                                        <td>{{ __('schedules.' . $dose->schedule) }}</td>
                                        <td>
                                            @if($dose->active)
                                                <span class="badge badge-pill badge-primary font-12">{{ __('Aktywne') }}</span>
                                            @else
                                                <span class="badge badge-pill badge-danger font-12">{{ __('Nieaktywne') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('medicines.dose.update', $dose->id) }}">
                                                <button class="btn btn-success btn-xs waves-effect waves-light">
                                                    <i class="fas fa-edit mr-1"></i> <span>{{ __('Edytuj') }}</span>
                                                </button>
                                            </a>
                                            <a href="#delete-modal-{{ $dose->id }}" class="btn btn-danger btn-xs waves-effect waves-light"
                                               data-animation="blur"
                                               data-plugin="custommodal"
                                               data-overlaySpeed="100"
                                               data-overlayColor="#38414a">
                                                <i class="fas fa-times mr-1"></i> <span>{{ __('Usuń') }}</span>
                                            </a>
                                            <!-- Modal -->
                                            <div id="delete-modal-{{ $dose->id }}" class="modal-demo">
                                                <button type="button" class="close" onclick="Custombox.modal.close();">
                                                    <span>&times;</span><span class="sr-only">Close</span>
                                                </button>
                                                <h4 class="custom-modal-title">{{ __('Czy na pewno chcesz usunąć ?') }}</h4>
                                                <div class="custom-modal-text text-center">
                                                    <form action="{{ route('medicines.dose.delete', $dose->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger waves-effect waves-light">
                                                            <span>{{ __('Usuń') }}</span>
                                                        </button>
                                                        <a href="javascript:void(0);" onclick="Custombox.modal.close();">
                                                            <button type="button" class="btn btn-success waves-effect waves-light">
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
