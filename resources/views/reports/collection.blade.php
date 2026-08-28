@extends('layouts.structure')
@push('title')
    <title>{{ $title }}</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-header card_hearder_mimi">
                <div class="card-title card_hearder_mimi_text"> {{ $title }} Report</div>
            </div>
            <div class="card-body p-0">
                <div class="col-md-12 border-right">
                    <form method="POST" action="{{ $action }}">
                        @csrf
                        <div class="whitebackground">
                            <div class="row ">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control datePickr"
                                            value="{{ @$request_data['from_date'] }}" id="fromDate" name="from_date"
                                            placeholder="Choose From Date">
                                        @error('from_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control datePickr"
                                            value="{{ @$request_data['to_date'] }}" id="toDate" name="to_date"
                                            placeholder="Choose To Date">
                                        @error('to_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group d-flex">
                                        <button type="submit" class="btn btn-primary px-3 mr-2"><i
                                                class="fas fa-search"></i> Search</button>
                                        <a href="{{ $action }}" class="btn btn-warning px-3 mr-2"><i
                                                class="fas fa-history"></i> Reset</a>
                                        <button type="button" onclick="window.print()" class="btn btn-info px-3"><i
                                                class="fas fa-print"></i> Print</button>
                                        @if (!empty($request_data['from_date']) && !empty($request_data['to_date']))
                                            <a href="{{ route('reports.collection.export', ['format' => 'excel', 'from_date' => $request_data['from_date'], 'to_date' => $request_data['to_date']]) }}"
                                                class="btn btn-success px-3 mr-2" target="_blank" rel="noopener"><i
                                                    class="fas fa-file-excel"></i> Excel</a>
                                            <a href="{{ route('reports.collection.export', ['format' => 'pdf', 'from_date' => $request_data['from_date'], 'to_date' => $request_data['to_date']]) }}"
                                                class="btn btn-danger px-3" target="_blank" rel="noopener"><i
                                                    class="fas fa-file-pdf"></i> PDF</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- GRAPHS SECTION -->
            @php
                // Calculate totals for each section for pie charts
                $opdPie = [
                    collect($result)->sum(function ($item) {
                        return $item['payments']
                            ->where('section', 'OPD')
                            ->where('payment_mode', 'Cash')
                            ->sum('payment_amount');
                    }),
                    collect($result)->sum(function ($item) {
                        return $item['payments']
                            ->where('section', 'OPD')
                            ->whereNotIn('payment_mode', ['Cash'])
                            ->sum('payment_amount');
                    }),
                ];
                $emgPie = [
                    collect($result)->sum(function ($item) {
                        return $item['payments']
                            ->where('section', 'EMG')
                            ->where('payment_mode', 'Cash')
                            ->sum('payment_amount');
                    }),
                    collect($result)->sum(function ($item) {
                        return $item['payments']
                            ->where('section', 'EMG')
                            ->whereNotIn('payment_mode', ['Cash'])
                            ->sum('payment_amount');
                    }),
                ];
                $ipdPie = [
                    collect($result)->sum(function ($item) {
                        return $item['payments']
                            ->where('section', 'IPD')
                            ->where('payment_mode', 'Cash')
                            ->sum('payment_amount');
                    }),
                    collect($result)->sum(function ($item) {
                        return $item['payments']
                            ->where('section', 'IPD')
                            ->whereNotIn('payment_mode', ['Cash'])
                            ->sum('payment_amount');
                    }),
                ];
                $daycarePie = [
                    collect($result)->sum(function ($item) {
                        return $item['payments']
                            ->where('section', 'DAYCARE')
                            ->where('payment_mode', 'Cash')
                            ->sum('payment_amount');
                    }),
                    collect($result)->sum(function ($item) {
                        return $item['payments']
                            ->where('section', 'DAYCARE')
                            ->whereNotIn('payment_mode', ['Cash'])
                            ->sum('payment_amount');
                    }),
                ];
                $dialysisPie = [
                    collect($result)->sum(function ($item) {
                        return $item['payments']
                            ->where('section', 'DIALYSIS')
                            ->where('payment_mode', 'Cash')
                            ->sum('payment_amount');
                    }),
                    collect($result)->sum(function ($item) {
                        return $item['payments']
                            ->where('section', 'DIALYSIS')
                            ->whereNotIn('payment_mode', ['Cash'])
                            ->sum('payment_amount');
                    }),
                ];
                $investigationPie = [
                    collect($result)->sum(function ($item) {
                        return $item['payments']
                            ->where('section', 'INVESTIGATION')
                            ->where('payment_mode', 'Cash')
                            ->sum('payment_amount');
                    }),
                    collect($result)->sum(function ($item) {
                        return $item['payments']
                            ->where('section', 'INVESTIGATION')
                            ->whereNotIn('payment_mode', ['Cash'])
                            ->sum('payment_amount');
                    }),
                ];
                // For bar chart
                $sectionTotals = [
                    collect($result)->sum(function ($item) {
                        return $item['payments']->where('section', 'OPD')->sum('payment_amount');
                    }),
                    collect($result)->sum(function ($item) {
                        return $item['payments']->where('section', 'EMG')->sum('payment_amount');
                    }),
                    collect($result)->sum(function ($item) {
                        return $item['payments']->where('section', 'IPD')->sum('payment_amount');
                    }),
                    collect($result)->sum(function ($item) {
                        return $item['payments']->where('section', 'DAYCARE')->sum('payment_amount');
                    }),
                    collect($result)->sum(function ($item) {
                        return $item['payments']->where('section', 'DIALYSIS')->sum('payment_amount');
                    }),
                    collect($result)->sum(function ($item) {
                        return $item['payments']->where('section', 'INVESTIGATION')->sum('payment_amount');
                    }),
                ];
            @endphp

            @if (array_sum($sectionTotals) > 0 ||
                    array_sum($opdPie) > 0 ||
                    array_sum($emgPie) > 0 ||
                    array_sum($ipdPie) > 0 ||
                    array_sum($daycarePie) > 0 ||
                    array_sum($dialysisPie) > 0 ||
                    array_sum($investigationPie) > 0)
                <div class="row ">
                    <div class="col-5">
                        @if (array_sum($sectionTotals) > 0)
                            <div class="card-body">
                                <div class="">
                                    <div id="sectionBarChart" style="min-height: 350px;"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-7">
                        <div class="row">
                            @if (array_sum($opdPie) > 0)
                                <div class="col-md-4 " style="margin-top: -13px;">
                                    <div class="card-body">
                                        <div class="">
                                            <div id="opdPieChart" style="min-height: 200px;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (array_sum($emgPie) > 0)
                                <div class="col-md-4 " style="margin-top: -13px;">
                                    <div class="card-body">
                                        <div class="">
                                            <div id="emgPieChart" style="min-height: 200px;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (array_sum($ipdPie) > 0)
                                <div class="col-md-4 " style="margin-top: -13px;">
                                    <div class="card-body">
                                        <div class="">
                                            <div id="ipdPieChart" style="min-height: 200px;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (array_sum($daycarePie) > 0)
                                <div class="col-md-4 " style="margin-top: -13px;">
                                    <div class="card-body">
                                        <div class="">
                                            <div id="daycarePieChart" style="min-height: 200px;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (array_sum($dialysisPie) > 0)
                                <div class="col-md-4 " style="margin-top: -13px;">
                                    <div class="card-body">
                                        <div class="">
                                            <div id="dialysisPieChart" style="min-height: 200px;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (array_sum($investigationPie) > 0)
                                <div class="col-md-4 " style="margin-top: -13px;">
                                    <div class="card-body">
                                        <div class="">
                                            <div id="investigationPieChart" style="min-height: 200px;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            <!-- END GRAPHS SECTION -->
            @if ($title == 'Users Collection')
                @if (!empty($kghResult))
                    <div class="whitebackground mt-4">
                        <div class="card-body">
                            @include('reports.partials.collection-table', [
                                'branchTitle' => 'KGH Collection',
                                'branchKey' => 'kgh',
                                'tableData' => $kghResult,
                                'request_data' => $request_data,
                                'title' => $title,
                                'tableId' => 'collection-kgh'
                            ])
                        </div>
                    </div>
                @endif
                @if (!empty($jmnResult))
                    <div class="whitebackground">
                        <div class="card-body">
                            @include('reports.partials.collection-table', [
                                'branchTitle' => 'JMN Collection',
                                'branchKey' => 'jmn',
                                'tableData' => $jmnResult,
                                'request_data' => $request_data,
                                'title' => $title,
                                'tableId' => 'collection-jmn'
                            ])
                        </div>
                    </div>
                @endif
            @else
                <div class="whitebackground mt-4">
                    <div class="card-body">
                        @include('reports.partials.collection-table', [
                            'branchTitle' => 'KGH Collection',
                            'branchKey' => 'kgh',
                            'tableData' => $kghResult,
                            'request_data' => $request_data,
                            'title' => $title,
                            'tableId' => 'collection-kgh'
                        ])
                    </div>
                </div>
                <div class="whitebackground mt-4">
                    <div class="card-body">
                        @include('reports.partials.collection-table', [
                            'branchTitle' => 'JMN Collection',
                            'branchKey' => 'jmn',
                            'tableData' => $jmnResult,
                            'request_data' => $request_data,
                            'title' => $title,
                            'tableId' => 'collection-jmn'
                        ])
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
</div>
@endsection
@push('js')
    <script>
        // Pie chart data from PHP
        const sectionData = {
            OPD: @json($opdPie),
            EMG: @json($emgPie),
            IPD: @json($ipdPie),
            DAYCARE: @json($daycarePie),
            DIALYSIS: @json($dialysisPie),
            INVESTIGATION: @json($investigationPie)
        };
        const pieColors = [
            ['#90caf9', '#ffe082'], // OPD
            ['#a5d6a7', '#ffd54f'], // EMG
            ['#b39ddb', '#ffccbc'], // IPD
            ['#80cbc4', '#f8bbd0'], // DAYCARE
            ['#80cbc4', '#f8bbd0'], // DAYCARE
            ['#ce93d8', '#bcaaa4'] // INVESTIGATION
        ];
        const pieIds = [{
                id: "#opdPieChart",
                data: sectionData.OPD,
                colors: pieColors[0],
                title: 'OPD'
            },
            {
                id: "#emgPieChart",
                data: sectionData.EMG,
                colors: pieColors[1],
                title: 'EMG'
            },
            {
                id: "#ipdPieChart",
                data: sectionData.IPD,
                colors: pieColors[2],
                title: 'IPD'
            },
            {
                id: "#daycarePieChart",
                data: sectionData.DAYCARE,
                colors: pieColors[3],
                title: 'DAYCARE'
            },
            {
                id: "#dialysisPieChart",
                data: sectionData.DIALYSIS,
                colors: pieColors[4],
                title: 'DIALYSIS'
            },
            {
                id: "#investigationPieChart",
                data: sectionData.INVESTIGATION,
                colors: pieColors[5],
                title: 'INVESTIGATION'
            }
        ];
        pieIds.forEach(function(pie) {
            if ((pie.data[0] || 0) > 0 || (pie.data[1] || 0) > 0) {
                var options = {
                    series: pie.data,
                    chart: {
                        type: 'pie',
                        height: 160,
                        fontFamily: 'inherit'
                    },
                    labels: ['Cash', 'Bank'],
                    colors: pie.colors,
                    title: {
                        text: pie.title,
                        align: 'center',
                        style: {
                            fontSize: '16px',
                            fontWeight: 'bold',
                            color: '#333'
                        }
                    },
                    plotOptions: {
                        pie: {
                            dataLabels: {
                                offset: -10
                            },
                        },
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '12px',
                            fontWeight: 'bold',
                            colors: ['#333', '#333']
                        },
                        formatter(val, opts) {
                            const name = opts.w.globals.labels[opts.seriesIndex];
                            return [name, val.toFixed(1) + '%'];
                        },
                        dropShadow: {
                            enabled: false
                        }
                    },
                    legend: {
                        show: false
                    },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    }
                };
                new ApexCharts(document.querySelector(pie.id), options).render();
            }
        });

        // Bar chart data from PHP
        const sectionTotals = @json($sectionTotals);
        const barHasData = sectionTotals.some(val => val > 0);
        if (barHasData) {
            const barSeries = [{
                data: sectionTotals
            }];
            const barLabels = ['OPD', 'EMG', 'IPD', 'DAYCARE', 'DIALYSIS', 'INVESTIGATION'];
            const barColors = ['#90caf9', '#a5d6a7', '#b39ddb', '#80cbc4', '#80cbc4', '#ce93d8'];
            var barOptions = {
                series: barSeries,
                chart: {
                    type: 'bar',
                    height: 390,
                    fontFamily: 'inherit'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 6,
                        columnWidth: '50%',
                        distributed: true,
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                colors: barColors,
                dataLabels: {
                    enabled: true,
                    offsetY: -20,
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold',
                        colors: ['#333']
                    },
                    formatter: function(val) {
                        return val.toLocaleString();
                    }
                },
                xaxis: {
                    categories: barLabels,
                    labels: {
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold'
                        }
                    },
                    title: {
                        style: {
                            fontSize: '16px',
                            fontWeight: 'bold'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold'
                        }
                    },
                    title: {
                        style: {
                            fontSize: '16px',
                            fontWeight: 'bold'
                        }
                    }
                },
                title: {
                    align: 'center',
                    style: {
                        fontSize: '18px',
                        fontWeight: 'bold'
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value.toLocaleString();
                        }
                    }
                },
                grid: {
                    borderColor: '#eee'
                }
            };
            new ApexCharts(document.querySelector("#sectionBarChart"), barOptions).render();
        }
        $('.datatable-all').DataTable({
            paging: false,
            searching: true,
            ordering: true,
            info: false
        });
    </script>
@endpush
