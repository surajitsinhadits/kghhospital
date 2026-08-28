@extends('layouts.structure')
@push('title')
    <title>Death Report</title>
@endpush
@push('css')
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto);

        body {
            font-family: Roboto, sans-serif;
        }

        #chart1 {
            max-width: 100%;
            margin: 5px auto;
        }

        #chart2 {
            max-width: 100%;
            margin: 5px auto;
        }
    </style>
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">DEATH REPORT</h4>
                </div>
                <div class="">
                    <div class="">
                        <form method="POST" id="filterForm">
                            @csrf
                            <div class="whitebackground">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="text" value="" class="form-control datePickr"
                                                id="fromDate" name="from_date" placeholder="Choose From Date">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="text" value="" class="form-control datePickr"
                                                id="toDate" name="to_date" placeholder="Choose To Date">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group d-flex flex-wrap">
                                            <button type="submit" class="btn btn-primary px-3 mr-2"><i
                                                    class="fas fa-filter"></i> Filter</button>
                                            <button type="button" class="btn btn-success px-3 mr-2" id="todayBtn"><i
                                                    class="fas fa-calendar-week"></i> Today</button>
                                            <button type="button" class="btn btn-warning px-3 mr-2" id="resetBtn"><i
                                                    class="fas fa-history"></i> Reset</button>
                                            <a href="{{ route('reports.death.export', ['format' => 'pdf']) }}"
                                                class="btn btn-danger px-3 mr-2" id="deathPdfExport"
                                                data-base-url="{{ route('reports.death.export', ['format' => 'pdf']) }}"><i
                                                    class="fas fa-file-pdf"></i> PDF</a>
                                            <a href="{{ route('reports.death.export', ['format' => 'excel']) }}"
                                                class="btn btn-success px-3" id="deathExcelExport"
                                                data-base-url="{{ route('reports.death.export', ['format' => 'excel']) }}"><i
                                                    class="fas fa-file-excel"></i> Excel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row reportmargin">
                        <div class="col-md-3">
                            <div id="chart1" style="height: 389px;"></div>
                        </div>
                        <div class="col-md-9">
                            <div id="chart2"style="height: 389px;"></div>
                        </div>
                    </div>
                    <div class="whitebackground">
                        <div class="table-responsive" id="table-responsive">
                            <table class="table table-bordered data-table">
                                <thead></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        var table;
        let chart1, chart2;
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            window.chartsInitialized = false;
            table.draw();
            updateDeathExportLinks();
        });
        $('#fromDate, #toDate').on('change', updateDeathExportLinks);
        $('#todayBtn').on('click', function() {
            const today = moment().format('DD-MM-YYYY');
            $('#fromDate').val(today);
            $('#toDate').val(today);
            window.chartsInitialized = false;
            table.draw();
            updateDeathExportLinks();
        });
        $('#resetBtn').on('click', function() {
            // Clear all filters
            $('#fromDate').val('');
            $('#toDate').val('');

            // Redraw the DataTable (will trigger serverSide AJAX reload)
            window.chartsInitialized = false;
            table.draw();
            updateDeathExportLinks();
        });

        function setDefaultDatesIfBlank() {
            let fromDate = $('#fromDate').val();
            let toDate = $('#toDate').val();
            if (!fromDate && !toDate) {
                let today = moment();
                let sixMonthsAgo = moment().subtract(6, 'months');
                $('#fromDate').val(sixMonthsAgo.format('DD-MM-YYYY'));
                $('#toDate').val(today.format('DD-MM-YYYY'));
            }
        }

        $(function() {
            setDefaultDatesIfBlank();
            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('reports.death') }}",
                    data: function(d) {
                        d.from_date = $('#fromDate').val();
                        d.to_date = $('#toDate').val();
                    }
                },
                columns: [{
                        data: null,
                        name: 'sl_no',
                        title: 'SN',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'patient_name',
                        name: 'p.name',
                        title: 'Patient Name',
                        render: function(data, type, row, meta) {
                            return `${row.patient_name} (${row.patient_uhid || row.patient_id})`;
                        },
                    },
                    {
                        data: 'adm_date',
                        name: 'ir.admission_date',
                        title: 'Admission Date',
                    },
                    {
                        data: 'doctor_name',
                        name: 'u.name',
                        title: 'Under Doctor',
                    },
                    {
                        data: 'dis_date',
                        name: 'discharge_reports.discharge_date',
                        title: 'Death Date',
                    },
                ],
                rowCallback: function(row, data) {
                    $(row).css('background-color', '#d3fdf7');
                }
            });
            updateDeathExportLinks();
        });
        $('.data-table').on('xhr.dt', function(e, settings, json) {
            if (json.recordsTotal > 0) {
                if (window.chartsInitialized) {
                    return;
                }
                const totals = json.totals;
                const gender = totals.gender;
                const doctor_list = json.totalsByDoctor.map(item => item.name);
                const totalCount = json.totalsByDoctor.map(item => Number(item.total_count));

                // Rebuild charts with updated data
                if (chart1) chart1.destroy();
                chart1 = new ApexCharts(document.querySelector("#chart1"), {
                    series: gender,
                    chart: {
                        width: '100%',
                        type: 'pie',
                    },
                    labels: ['MALE', 'FEMALE'],
                    legend: {
                        position: 'top'
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                });
                chart1.render();

                if (chart2) chart2.destroy();
                chart2 = new ApexCharts(document.querySelector("#chart2"), {
                    series: [{
                        name: 'Total',
                        data: totalCount
                    }],
                    chart: {
                        height: 350,
                        type: 'area',
                        animations: {
                            enabled: false
                        }
                    },
                    title: {
                        text: 'Total Doctors',
                        align: 'center',
                        style: {
                            fontSize: '18px',
                            fontWeight: 'bold'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    xaxis: {
                        type: 'category',
                        categories: doctor_list
                    },
                });
                chart2.render();

                window.chartsInitialized = true;
            } else {
                if (chart1) chart1.destroy();
                if (chart2) chart2.destroy();
            }
        });

        function updateDeathExportLinks() {
            const params = new URLSearchParams();
            const from = $('#fromDate').val();
            const to = $('#toDate').val();
            if (from) params.set('from_date', from);
            if (to) params.set('to_date', to);

            const query = params.toString();
            ['#deathPdfExport', '#deathExcelExport'].forEach(function(selector) {
                const link = $(selector);
                if (!link.length) return;
                const baseUrl = link.data('base-url') || link.attr('href');
                link.attr('href', query ? `${baseUrl}?${query}` : baseUrl);
            });
        }
    </script>
@endpush
