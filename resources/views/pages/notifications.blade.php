@extends('layouts.base')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <h3 class="page-title text-center p-2">
                        {{ __('Notyfikacje') }}
                        <a href="{{ route('notifications.update', 0) }}">
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
                                    <th scope="col">Harmonogram</th>
                                    <th scope="col">Zaczyna się o</th>
                                    <th scope="col">Kończy się o</th>
                                    <th scope="col">Powtarzaj co</th>
                                    <th scope="col">Licznik powótrzeń</th>
                                    <th scope="col">Wiadomość (1st)</th>
                                    <th scope="col">Wiadomość (nth)</th>
                                    <th scope="col">Akcja</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($notifications as $notification)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ __('schedules.' . $notification->schedule) }}</td>
                                        <td>{{ $notification->start_at }}</td>
                                        <td>{{ $notification->end_at ?? '-' }}</td>
                                        <td>{{ $notification->repeat_every }}</td>
                                        <td>{{ $notification->repeat_count }}</td>
                                        <td>{{ Str::limit($notification->message, 50) }}</td>
                                        <td>{{ Str::limit($notification->repeated_message, 50) }}</td>
                                        <td>
                                            <a href="{{ route('notifications.update', $notification->id) }}">
                                                <button class="btn btn-success btn-xs waves-effect waves-light">
                                                    <i class="fas fa-edit mr-1"></i> <span>{{ __('Edytuj') }}</span>
                                                </button>
                                            </a>
                                            <a href="#delete-modal-{{ $notification->id }}" class="btn btn-danger btn-xs waves-effect waves-light"
                                               data-animation="blur"
                                               data-plugin="custommodal"
                                               data-overlaySpeed="100"
                                               data-overlayColor="#38414a">
                                                <i class="fas fa-times mr-1"></i> <span>{{ __('Usuń') }}</span>
                                            </a>
                                            <!-- Modal -->
                                            <div id="delete-modal-{{ $notification->id }}" class="modal-demo">
                                                <button type="button" class="close" onclick="Custombox.modal.close();">
                                                    <span>&times;</span><span class="sr-only">Close</span>
                                                </button>
                                                <h4 class="custom-modal-title">{{ __('Czy na pewno chcesz usunąć ?') }}</h4>
                                                <div class="custom-modal-text text-center">
                                                    <form action="{{ route('notifications.delete', $notification->id) }}" method="post">
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
