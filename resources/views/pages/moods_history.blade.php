@extends('layouts.base')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <h3 class="page-title text-center p-2">
                        {{ __('Historia nastrojów') }}
                    </h3>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nazwa</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Akcja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($histories as $history)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $history->moods->name }}</td>
                                        <td>{{ $history->history_time->format('d-m-Y H:i') }}</td>
                                        <td>
                                            <a href="#delete-modal-{{ $history->id }}" class="btn btn-danger btn-xs waves-effect waves-light"
                                               data-animation="blur"
                                               data-plugin="custommodal"
                                               data-overlaySpeed="100"
                                               data-overlayColor="#38414a">
                                                <i class="fas fa-times mr-1"></i> <span>{{ __('Usuń') }}</span>
                                            </a>
                                            <!-- Modal -->
                                            <div id="delete-modal-{{ $history->id }}" class="modal-demo">
                                                <button type="button" class="close" onclick="Custombox.modal.close();">
                                                    <span>&times;</span><span class="sr-only">Close</span>
                                                </button>
                                                <h4 class="custom-modal-title">{{ __('Czy na pewno chcesz usunąć ?') }}</h4>
                                                <div class="custom-modal-text text-center">
                                                    <form action="{{ route('medicines.moods.history.delete', $history->id) }}" method="post">
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
