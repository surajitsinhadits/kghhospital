@extends('layouts.structure')
@push('title')
    <title>Discharge Report</title>
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
                    <h4 class="card-title card_hearder_mimi_text">DISCHARGE REPORT</h4>
                </div>
                <div class="">
                    <div class="">
                        <form method="POST" id="filterForm">
                            @csrf
                            <div class="whitebackground">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select class="form-control mt-1" name="discharge_status" id="discharge_status">
                                            <option value="">Select Discharge Status</option>
                                            <option value="Death"> Death</option>
                                            <option value="Refferal"> Referral</option>
                                            <option value="Normal"> Normal</option>
                                            <option value="LAMA"> LAMA</option>
                                            <option value="DORB"> DORB</option>
                                            <option value="DMA"> DMA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" value="" class="form-control datePickr" id="fromDate"
                                            name="from_date" placeholder="Choose From Date">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" value="" class="form-control datePickr" id="toDate"
                                            name="to_date" placeholder="Choose To Date">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group d-flex flex-wrap">
                                        <button type="submit" class="btn btn-primary px-3 mr-2"><i
                                            class="fas fa-filter"></i> Filter</button>
                                        <button type="button" class="btn btn-success px-3 mr-2"
                                            id="todayBtn"><i
                                            class="fas fa-calendar-week"></i> Today</button>
                                        <button type="button" class="btn btn-warning px-3 mr-2" id="resetBtn"><i
                                            class="fas fa-history"></i> Reset</button>
                                        <a href="{{ route('reports.discharge.export', ['format' => 'pdf']) }}"
                                            class="btn btn-danger px-3 mr-2" id="dischargePdfExport"
                                            data-base-url="{{ route('reports.discharge.export', ['format' => 'pdf']) }}"><i
                                                class="fas fa-file-pdf"></i> PDF</a>
                                        <a href="{{ route('reports.discharge.export', ['format' => 'excel']) }}"
                                            class="btn btn-success px-3" id="dischargeExcelExport"
                                            data-base-url="{{ route('reports.discharge.export', ['format' => 'excel']) }}"><i
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
                            <div id="chart2" style="height: 389px;"></div>
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
            updateDischargeExportLinks();
        });
        $('#discharge_status, #fromDate, #toDate').on('change', updateDischargeExportLinks);
        $('#todayBtn').on('click', function() {
            const today = moment().format('DD-MM-YYYY');
            $('#fromDate').val(today);
            $('#toDate').val(today);
            window.chartsInitialized = false;
            table.draw();
            updateDischargeExportLinks();
        });
        $('#resetBtn').on('click', function() {
            // Clear all filters
            $('#discharge_status').val('');
            $('#fromDate').val('');
            $('#toDate').val('');

            // Redraw the DataTable (will trigger serverSide AJAX reload)
            window.chartsInitialized = false;
            table.draw();
            updateDischargeExportLinks();
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
                pageLength: 50,
                lengthMenu: [
                    [50, 100, 200, 300, 400],
                    [50, 100, 200, 300, 400]
                ],
                ajax: {
                    url: "{{ route('reports.discharge') }}",
                    data: function(d) {
                        d.discharge_status = $('#discharge_status').val();
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
                        data: 'billBtn',
                        name: 'bill.uid',
                        title: 'Bill No',
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
                        data: 'dis_date',
                        name: 'discharge_reports.discharge_date',
                        title: 'Discharge Date',
                    },
                    {
                        data: 'discharge_type',
                        name: 'discharge_reports.discharge_type',
                        title: 'Discharge Status',
                    },
                ],
                rowCallback: function(row, data) {
                    $(row).css('background-color', '#d3fdf7');
                }
            });
            updateDischargeExportLinks();
        });
        $('.data-table').on('xhr.dt', function(e, settings, json) {
            if (json.recordsTotal > 0) {
                if (window.chartsInitialized) {
                    return;
                }
                const totals = json.totals;
                const gender = totals.gender;
                const discharge_type = json.totalsByType.map(item => item.discharge_type);
                const totalCount = json.totalsByType.map(item => Number(item.total_count));

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
                        text: 'Total Discharge Status',
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
                        categories: discharge_type
                    },
                });
                chart2.render();

                window.chartsInitialized = true;
            } else {
                if (chart1) chart1.destroy();
                if (chart2) chart2.destroy();
            }
        });

        function updateDischargeExportLinks() {
            const params = new URLSearchParams();
            const fields = {
                discharge_status: $('#discharge_status').val(),
                from_date: $('#fromDate').val(),
                to_date: $('#toDate').val(),
            };

            Object.keys(fields).forEach(function(key) {
                const value = fields[key];
                if (value) {
                    params.set(key, value);
                }
            });

            const query = params.toString();
            ['#dischargePdfExport', '#dischargeExcelExport'].forEach(function(selector) {
                const link = $(selector);
                if (!link.length) return;
                const baseUrl = link.data('base-url') || link.attr('href');
                link.attr('href', query ? `${baseUrl}?${query}` : baseUrl);
            });
        }
    </script>
@endpush
