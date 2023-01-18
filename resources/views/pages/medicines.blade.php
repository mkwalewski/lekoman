@extends('layouts.base')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <h3 class="page-title text-center p-2">{{ __('Leki') }}</h3>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nazwa</th>
                                    <th scope="col">Opakowanie</th>
                                    <th scope="col">Jednostki</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($medicines as $medicine)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $medicine->name }}</td>
                                        <td>
                                            @if ($medicine->unit == 'mg')
                                                {{ $medicine->package }} {{ $medicine->take_unit }}
                                            @elseif ($medicine->unit == 'ml')
                                                {{ $medicine->package }} {{ $medicine->unit }}
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($medicine->units as $unit)
                                                <span class="badge badge-pill badge-primary font-13">{{ $unit->amount }} {{ $medicine->unit }}</span>
                                            @endforeach
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
