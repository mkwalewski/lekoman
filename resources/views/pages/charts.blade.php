@extends('layouts.base')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <h3 class="page-title text-center p-2">
                        {{ __('Wykresy') }}
                    </h3>

                    <div class="p-3">
                        <form class="form-horizontal" method="get">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">{{ __('Wybierz tydzień') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="medicines_id">
                                        @foreach ($weeks as $week => $value)
                                            <option value="{{ $week }}" @if($week == $selectedWeek) selected @endif>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"></label>
                                <div class="col-md-10">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">{{ __('Zobacz') }}</button>
                                    <a href="{{ route('medicines.charts') }}">
                                        <button type="button" class="btn btn-danger waves-effect waves-light">{{ __('Resetuj') }}</button>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="p-3">
                        <ul class="nav nav-tabs" role="tablist">
                            @foreach ($histories as $id => $history)
                                <li class="nav-item">
                                    <a class="nav-link {{ HttpHelper::getClassForActive($loop->index, ['active', '']) }}" id="t{{ $id }}-tab" data-toggle="tab" href="#t{{ $id }}" role="tab" aria-controls="t{{ $id }}" aria-selected="{{ HttpHelper::getClassForActive($loop->index, ['true', 'false']) }}">
                                        <span class="d-block d-sm-none"><i class="fa fa-home"></i></span>
                                        <span class="d-none d-sm-block">{{ $history['name'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                                <li class="nav-item">
                                    <a class="nav-link" id="moods-tab" data-toggle="tab" href="#moods" role="tab" aria-controls="moods" aria-selected="false">
                                        <span class="d-block d-sm-none"><i class="fa fa-home"></i></span>
                                        <span class="d-none d-sm-block">{{ __('Samopoczucie') }}</span>
                                    </a>
                                </li>
                        </ul>
                        <div class="tab-content p-3 border border-top-0">
                            @foreach ($histories as $id => $history)
                            <div class="tab-pane {{ HttpHelper::getClassForActive($loop->index, ['show active', '']) }}" id="t{{ $id }}" role="tabpanel" aria-labelledby="t{{ $id }}-tab">
                                <!-- Dawki -->
                                <div class="text-center mt-5">
                                    <h4 class="header-title">{{ $history['name'] }}</h4>
                                    <ul class="list-inline chart-detail-list">
                                        <li class="list-inline-item">
                                            <h5 class="font-14"><i class="fas fa-circle mr-1" style="color: #57c5a5;"></i>{{ __('Wzięto') }}</h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <h5 class="font-14"><i class="fas fa-circle mr-1" style="color: #ddd;"></i>{{ __('Dawka') }}</h5>
                                        </li>
                                    </ul>
                                </div>
                                <div id="med-chart-{{ $id }}" class="morris-chart" style="height: 300px;"></div>
                                <!-- Godziny -->
                                <div class="text-center mt-5">
                                    <ul class="list-inline chart-detail-list">
                                        <li class="list-inline-item">
                                            <h5 class="font-14"><i class="fas fa-circle mr-1" style="color: #9ac9dc;"></i>{{ __('Godzina') }}</h5>
                                        </li>
                                    </ul>
                                </div>
                                <div id="med-chart-hours-{{ $id }}" class="morris-chart" style="height: 300px;"></div>
                            </div>
                            @endforeach
                                <div class="tab-pane" id="moods" role="tabpanel" aria-labelledby="moods-tab">
                                    <!-- Nastrój -->
                                    <div class="text-center mt-5">
                                        <h4 class="header-title">{{ __('Samopoczucie') }}</h4>
                                        <ul class="list-inline chart-detail-list">
                                            @foreach($moods as $mood)
                                                <li class="list-inline-item">
                                                    <h5 class="font-14"><i class="fas fa-circle mr-1" style="color: #9adcc9;"></i>{{ $mood->id }} - {{ $mood->name }}</h5>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div id="med-moods-chart" class="morris-chart" style="height: 300px;"></div>
                                    <!-- Godziny -->
                                    <div class="text-center mt-5">
                                        <ul class="list-inline chart-detail-list">
                                            <li class="list-inline-item">
                                                <h5 class="font-14"><i class="fas fa-circle mr-1" style="color: #9ac9dc;"></i>{{ __('Godzina') }}</h5>
                                            </li>
                                        </ul>
                                    </div>
                                    <div id="med-moods-chart-hours" class="morris-chart" style="height: 300px;"></div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- end container-fluid -->
@endsection

@section('scripts')
    <!--Morris Chart-->
    <script src="{{ asset('libs/morris-js/morris.min.js') }}"></script>
    <script src="{{ asset('libs/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('js/pages/morris.init.js') }}"></script>
    <script type="text/javascript">
        (function( $ ){
            @foreach ($histories as $id => $history)
                var {{ $history['name'] }} = {!! json_encode($histories[$id]['history']) !!};
                var {{ $history['name'] }}Chart = Morris.Line({
                    element: 'med-chart-{{ $id }}',
                    data: {{ $history['name'] }},
                    xkey: 'date',
                    ykeys: ['taken_amount', 'dose_amount'],
                    labels: ['{{ __('Wzięto') }}', '{{ __('Dawka') }}'],
                    postUnits: ' {{ $history['unit'] }}',
                    smooth: false,
                    parseTime: false,
                    continuousLine: true,
                    fillOpacity: ['0.9'],
                    pointFillColors: ['#ffffff'],
                    pointStrokeColors: ['#999999'],
                    behaveLikeLine: true,
                    gridLineColor: 'rgba(108, 120, 151, 0.1)',
                    hideHover: 'auto',
                    resize: true, //defaulted to true
                    pointSize: 0,
                    lineColors: ['#9adcc9', '#ddd']
                });
                var {{ $history['name'] }}ChartHours = Morris.Line({
                    element: 'med-chart-hours-{{ $id }}',
                    data: {{ $history['name'] }},
                    xkey: 'date',
                    ykeys: ['time'],
                    ymin: 0,
                    ymax: 24,
                    labels: ['{{ __('Godzina') }}'],
                    smooth: false,
                    parseTime: false,
                    continuousLine: true,
                    fillOpacity: ['0.9'],
                    pointFillColors: ['#ffffff'],
                    pointStrokeColors: ['#999999'],
                    behaveLikeLine: true,
                    gridLineColor: 'rgba(108, 120, 151, 0.1)',
                    hideHover: 'auto',
                    resize: true, //defaulted to true
                    pointSize: 0,
                    lineColors: ['#9ac9dc']
                });
            @endforeach
            var Moods = {!! json_encode($moodsHistories) !!};
            var MoodsChart = Morris.Line({
                element: 'med-moods-chart',
                data: Moods,
                xkey: 'date',
                ykeys: ['moods_id'],
                ymin: 0,
                ymax: 5,
                labels: ['{{ __('Nastrój') }}'],
                postUnits: '',
                smooth: false,
                parseTime: false,
                continuousLine: true,
                fillOpacity: ['0.9'],
                pointFillColors: ['#ffffff'],
                pointStrokeColors: ['#999999'],
                behaveLikeLine: true,
                gridLineColor: 'rgba(108, 120, 151, 0.1)',
                hideHover: 'auto',
                resize: true, //defaulted to true
                pointSize: 0,
                lineColors: ['#9adcc9']
            });
            var MoodsChartHours = Morris.Line({
                element: 'med-moods-chart-hours',
                data: Moods,
                xkey: 'date',
                ykeys: ['time'],
                ymin: 0,
                ymax: 24,
                labels: ['{{ __('Godzina') }}'],
                smooth: false,
                parseTime: false,
                continuousLine: true,
                fillOpacity: ['0.9'],
                pointFillColors: ['#ffffff'],
                pointStrokeColors: ['#999999'],
                behaveLikeLine: true,
                gridLineColor: 'rgba(108, 120, 151, 0.1)',
                hideHover: 'auto',
                resize: true, //defaulted to true
                pointSize: 0,
                lineColors: ['#9ac9dc']
            });
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr("href") // activated tab

                switch (target) {
                    @foreach ($histories as $id => $history)
                        case "#t{{ $id }}":
                            {{ $history['name'] }}Chart.redraw();
                            {{ $history['name'] }}ChartHours.redraw();
                            $(window).trigger('resize');
                            break;
                    @endforeach
                    case '#moods':
                        MoodsChart.redraw();
                        MoodsChartHours.redraw();
                        $(window).trigger('resize');
                        break;
                }
            });
        })( jQuery );
    </script>
@endsection
