@extends('layouts.structure')
@push('title')
    <title>My Collection</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-header card_hearder_mimi">
                <div class="card-title card_hearder_mimi_text"> My Collection</div>
            </div>
            <div class="card-body p-0">
                <div class="col-md-12 border-right">
                    <form method="POST" action="{{ route('reports.my-collection') }}">
                        @csrf
                        <div class="row justify-content-center my-2">
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
                                    <button type="submit" class="btn btn-primary px-3 mr-2"><i class="fas fa-search"></i>
                                        Search</button>
                                    <a href="{{ route('reports.my-collection') }}" class="btn btn-warning px-3 mr-2"><i
                                            class="fas fa-history"></i> Reset</a>
                                    <button type="button" onclick="window.print()" class="btn btn-info px-3"><i
                                            class="fas fa-print"></i> Print</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-7">
                    <div class="card-body">
                        <div style="width: 90%; margin-left: 5%">
                            <div class="table-responsive">
                                <table class="table text-nowrap " id="hucahfcuegw"
                                    style="border: 2px solid #8d8d8d !important;">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th scope="col" class="text-yellow text-center">SECTION</th>
                                            <th scope="col" class="text-yellow text-center">CASH</th>
                                            <th scope="col" class="text-yellow text-center">BANK</th>
                                            <th scope="col" class="text-yellow text-center">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="font-weight:600;font-size:20px;color: black; text-align: left;"> OPD
                                                Patient
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->where('section', 'OPD')->where('payment_mode', 'Cash')->sum('payment_amount') }}
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->where('section', 'OPD')->whereNotIn('payment_mode', ['Cash'])->sum('payment_amount') }}
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                <form method="POST"
                                                    action="{{ route('reports.total-collection-view') }}">
                                                    @csrf
                                                    <input type="hidden" name="collected_user"
                                                        value="{{ Auth::user()->id }}">
                                                    <input type="hidden" name="section" value="OPD">
                                                    <input type="hidden" name="from_date"
                                                        value="{{ @$request_data['from_date'] ? $request_data['from_date'] : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                    <input type="hidden" name="to_date"
                                                        value="{{ @$request_data['to_date'] ? $request_data['to_date'] : \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                                    <button type="submit" class="btn btn-default btn-sm"><b>{{ $result->where('section', 'OPD')->sum('payment_amount') }}</b></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;font-size:20px;color: black; text-align: left;">EMG
                                                Patient
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->where('section', 'EMG')->where('payment_mode', 'Cash')->sum('payment_amount') }}
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->where('section', 'EMG')->whereNotIn('payment_mode', ['Cash'])->sum('payment_amount') }}
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                <form method="POST"
                                                    action="{{ route('reports.total-collection-view') }}">
                                                    @csrf
                                                    <input type="hidden" name="collected_user"
                                                        value="{{ Auth::user()->id }}">
                                                    <input type="hidden" name="section" value="EMG">
                                                    <input type="hidden" name="from_date"
                                                        value="{{ @$request_data['from_date'] ? $request_data['from_date'] : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                    <input type="hidden" name="to_date"
                                                        value="{{ @$request_data['to_date'] ? $request_data['to_date'] : \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                                    <button type="submit" class="btn btn-default btn-sm"><b>{{ $result->where('section', 'EMG')->sum('payment_amount') }}</b></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;font-size:20px;color: black; text-align: left;">IPD
                                                Patient
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->where('section', 'IPD')->where('payment_mode', 'Cash')->sum('payment_amount') }}
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->where('section', 'IPD')->whereNotIn('payment_mode', ['Cash'])->sum('payment_amount') }}
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                <form method="POST"
                                                    action="{{ route('reports.total-collection-view') }}">
                                                    @csrf
                                                    <input type="hidden" name="collected_user"
                                                        value="{{ Auth::user()->id }}">
                                                    <input type="hidden" name="section" value="IPD">
                                                    <input type="hidden" name="from_date"
                                                        value="{{ @$request_data['from_date'] ? $request_data['from_date'] : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                    <input type="hidden" name="to_date"
                                                        value="{{ @$request_data['to_date'] ? $request_data['to_date'] : \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                                    <button type="submit" class="btn btn-default btn-sm"><b>{{ $result->where('section', 'IPD')->sum('payment_amount') }}</b></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;font-size:20px;color: black; text-align: left;">
                                                DAYCARE
                                                Patient</td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->where('section', 'DAYCARE')->where('payment_mode', 'Cash')->sum('payment_amount') }}
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->where('section', 'DAYCARE')->whereNotIn('payment_mode', ['Cash'])->sum('payment_amount') }}
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                <form method="POST"
                                                    action="{{ route('reports.total-collection-view') }}">
                                                    @csrf
                                                    <input type="hidden" name="collected_user"
                                                        value="{{ Auth::user()->id }}">
                                                    <input type="hidden" name="section" value="DAYCARE">
                                                    <input type="hidden" name="from_date"
                                                        value="{{ @$request_data['from_date'] ? $request_data['from_date'] : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                    <input type="hidden" name="to_date"
                                                        value="{{ @$request_data['to_date'] ? $request_data['to_date'] : \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                                    <button type="submit" class="btn btn-default btn-sm"><b>{{ $result->where('section', 'DAYCARE')->sum('payment_amount') }}</b></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;font-size:20px;color: black; text-align: left;">
                                                DIALYSIS
                                                Patient</td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->where('section', 'DIALYSIS')->where('payment_mode', 'Cash')->sum('payment_amount') }}
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->where('section', 'DIALYSIS')->whereNotIn('payment_mode', ['Cash'])->sum('payment_amount') }}
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                <form method="POST"
                                                    action="{{ route('reports.total-collection-view') }}">
                                                    @csrf
                                                    <input type="hidden" name="collected_user"
                                                        value="{{ Auth::user()->id }}">
                                                    <input type="hidden" name="section" value="DIALYSIS">
                                                    <input type="hidden" name="from_date"
                                                        value="{{ @$request_data['from_date'] ? $request_data['from_date'] : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                    <input type="hidden" name="to_date"
                                                        value="{{ @$request_data['to_date'] ? $request_data['to_date'] : \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                                    <button type="submit" class="btn btn-default btn-sm"><b>{{ $result->where('section', 'DIALYSIS')->sum('payment_amount') }}</b></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;font-size:20px;color: black; text-align: left;">
                                                Investigation
                                                Patient</td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->where('section', 'INVESTIGATION')->where('payment_mode', 'Cash')->sum('payment_amount') }}
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->where('section', 'INVESTIGATION')->whereNotIn('payment_mode', ['Cash'])->sum('payment_amount') }}
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                <form method="POST"
                                                    action="{{ route('reports.total-collection-view') }}">
                                                    @csrf
                                                    <input type="hidden" name="collected_user"
                                                        value="{{ Auth::user()->id }}">
                                                    <input type="hidden" name="section" value="INVESTIGATION">
                                                    <input type="hidden" name="from_date"
                                                        value="{{ @$request_data['from_date'] ? $request_data['from_date'] : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                    <input type="hidden" name="to_date"
                                                        value="{{ @$request_data['to_date'] ? $request_data['to_date'] : \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                                    <button type="submit" class="btn btn-default btn-sm"><b>{{ $result->where('section', 'INVESTIGATION')->sum('payment_amount') }}</b></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:700;font-size:20px;color: black; text-align: left;">
                                                Refund</td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $payment_refund }}
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr style="background-color:#d9dfff">
                                            <td style="font-weight:600;font-size:20px;color: black; text-align: left;">Total
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->where('payment_mode', 'Cash')->sum('payment_amount') - $payment_refund }}
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->whereNotIn('payment_mode', ['Cash'])->sum('payment_amount') }}
                                            </td>
                                            <td style="font-size:20px;text-align: center;font-weight:600">
                                                {{ $result->sum('payment_amount') - $payment_refund }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <!-- PIE CHART SECTION -->
                    <div class="card-body">
                        <div class="mb-4 p-3 ">
                            {{-- <h5 class="mb-3" style="font-weight: bold; color: #1976d2; letter-spacing: 1px;">
                                Section-wise Total Collection
                            </h5> --}}
                            <div id="sectionPieChartApex" style="min-height: 350px;"></div>
                            {{--  <div class="row justify-content-center">
                                <div class="col-md-8">
                                </div>
                            </div>  --}}
                        </div>
                    </div>
                    <!-- END PIE CHART SECTION -->
                </div>
            </div>



        </div>
    </div>
@endsection
@push('js')
    <script>
        const pieLabels = [
            'OPD',
            'EMG',
            'IPD',
            'DAYCARE',
            'DIALYSIS',
            'INVESTIGATION'
        ];
        const pieData = [
            {{ $result->where('section', 'OPD')->sum('payment_amount') }},
            {{ $result->where('section', 'EMG')->sum('payment_amount') }},
            {{ $result->where('section', 'IPD')->sum('payment_amount') }},
            {{ $result->where('section', 'DAYCARE')->sum('payment_amount') }},
            {{ $result->where('section', 'DIALYSIS')->sum('payment_amount') }},
            {{ $result->where('section', 'INVESTIGATION')->sum('payment_amount') }}
        ];

        // Check if all values are zero or falsy
        const hasPieData = pieData.some(val => val && val !== 0);

        if (hasPieData) {
            var options = {
                series: pieData,
                chart: {
                    width: '100%',
                    height: 350,
                    type: 'pie',
                    fontFamily: 'inherit'
                },
                labels: pieLabels,
                colors: [
                    '#90caf9', // OPD - light blue
                    '#ffe082', // EMG - light yellow
                    '#a5d6a7', // IPD - light green
                    '#b39ddb', // DAYCARE - light purple
                    '#ffccbc', // DIALYSIS - light orange
                    '#80cbc4' // INVESTIGATION - teal
                ],
                plotOptions: {
                    pie: {
                        dataLabels: {
                            offset: -40
                        },
                    },
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold',
                        colors: ['#333', '#333', '#333', '#333', '#333', '#333']
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
                    show: true,
                    position: 'right',
                    fontSize: '15px'
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#sectionPieChartApex"), options);
            chart.render();
        } else {
            // Hide the chart container if no data
            const chartDiv = document.querySelector("#sectionPieChartApex");
            if (chartDiv) {
                chartDiv.style.display = "none";
            }
        }
    </script>
@endpush
