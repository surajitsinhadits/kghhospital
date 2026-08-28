@extends('layouts.structure')
@push('title')
    <title>Dialysis Patients Report</title>
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
            max-width: 40%;
            margin: 5px auto;
        }
    </style>
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">DIALYSIS PATIENTS REPORT</h4>
                </div>
                <div class="">
                    <div class="">
                        <form method="POST" id="filterForm">
                            @csrf
                            <div class="whitebackground">
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="visit_type">Visit Type</label>
                                        <select class="form-control mt-1" name="visit_type" id="visit_type">
                                            <option value="">Select</option>
                                            <option value="new"> New</option>
                                            <option value="old"> Old</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="dialysis_type">Dialysis Type</label>
                                        <select class="form-control mt-1" name="dialysis_type" id="dialysis_type">
                                            <option value="">Select</option>
                                            <option value="DIRECT">DIRECT</option>
                                            <option value="IPD">MOVED TO IPD</option>
                                            <option value="EMG">MOVED TO EMG</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="patient_type">Patient Type</label>
                                        <select class="form-control select2-show-search mt-1" name="patient_type"
                                            id="patient_type">
                                            <option value="">Select</option>
                                            @foreach ($tpa as $item)
                                                <option value="{{ $item->id }}">{{ $item->tpa_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="ward">Ward</label>
                                        <select class="form-control select2-show-search mt-1" name="ward" id="ward">
                                            <option value="">Select</option>
                                            @foreach ($wards as $ward)
                                                <option value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="department">Department</label>
                                        <select class="form-control select2-show-search" name="department" id="department">
                                            <option value="">Select</option>
                                            @foreach ($department as $dept)
                                                <option value="{{ $dept->id }}">{{ $dept->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="doctor">Doctor</label>
                                        <select class="form-control select2-show-search" name="doctor" id="doctor">
                                            <option value="">Select</option>
                                            @foreach ($doctor as $doc)
                                                <option value="{{ $doc->id }}">Dr. {{ $doc->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="referral">Referral</label>
                                        <select class="form-control select2-show-search" name="referral" id="referral">
                                            <option value="">Select</option>
                                            @foreach ($referral as $ref)
                                                <option value="{{ $ref->id }}">{{ $ref->referral_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="market_by">Market By</label>
                                        <select class="form-control select2-show-search" name="market_by" id="market_by">
                                            <option value="">Select</option>
                                            @foreach ($market_by as $mar)
                                                <option value="{{ $mar->id }}">{{ $mar->referral_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="provider">Providor</label>
                                        <select class="form-control select2-show-search" name="provider" id="provider">
                                            <option value="">Select</option>
                                            @foreach ($provider as $pro)
                                                <option value="{{ $pro->id }}">{{ $pro->referral_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        {{-- <label for="fromDate">From Date</label> --}}
                                        <input type="text" value="" class="form-control datePickr" id="fromDate"
                                            name="from_date" placeholder="Choose From Date">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        {{-- <label for="toDate">To Date</label> --}}
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
                                        <a href="{{ route('reports.dialysis.export', ['format' => 'pdf']) }}"
                                            class="btn btn-danger px-3 mr-2" id="dialysisPdfExport"
                                            data-base-url="{{ route('reports.dialysis.export', ['format' => 'pdf']) }}"><i
                                                class="fas fa-file-pdf"></i> PDF</a>
                                        <a href="{{ route('reports.dialysis.export', ['format' => 'excel']) }}"
                                            class="btn btn-success px-3" id="dialysisExcelExport"
                                            data-base-url="{{ route('reports.dialysis.export', ['format' => 'excel']) }}"><i
                                                class="fas fa-file-excel"></i> Excel</a>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                    <div class="row reportmargin">
                        <div class="col-md-3">
                            <div id="chart1" style="height: 342px;"></div>
                        </div>
                        <div class="col-md-3">
                            <div id="chart3" style="height: 342px;"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="chart4" style="height: 342px;"></div>
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
        let chart1, chart2, chart3, chart4;

        function refreshDialysisData(resetPaging = true) {
            window.chartsInitialized = false;
            if (table) {
                table.ajax.reload(null, resetPaging);
            }
            updateDialysisExportLinks();
        }

        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            refreshDialysisData();
        });
        $('#visit_type, #dialysis_type, #patient_type, #ward, #department, #doctor, #referral, #market_by, #provider, #fromDate, #toDate').on('change', updateDialysisExportLinks);
        $('#todayBtn').on('click', function() {
            const today = moment().format('DD-MM-YYYY');
            $('#fromDate').val(today);
            $('#toDate').val(today);
            refreshDialysisData();
        });
        $('#resetBtn').on('click', function() {
            // Clear all filters
            $('#visit_type').val('');
            $('#dialysis_type').val('');
            $('#patient_type').val('').trigger('change');
            $('#ward').val('').trigger('change');
            $('#charge').val('').trigger('change');
            $('#department').val('').trigger('change');
            $('#doctor').val('').trigger('change');
            $('#referral').val('').trigger('change');
            $('#market_by').val('').trigger('change');
            $('#provider').val('').trigger('change');
            $('#fromDate').val('');
            $('#toDate').val('');

            // Redraw the DataTable (will trigger serverSide AJAX reload)
            refreshDialysisData();
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
                serverSide: false,
                pageLength: 50,
                lengthMenu: [
                    [50, 100, 200, 300, 400],
                    [50, 100, 200, 300, 400]
                ],
                ajax: {
                    url: "{{ route('reports.dialysis') }}",
                    data: function(d) {
                        d.visit_type = $('#visit_type').val();
                        d.dialysis_type = $('#dialysis_type').val();
                        d.patient_type = $('#patient_type').val();
                        d.ward = $('#ward').val();
                        d.charge = $('#charge').val();
                        d.department = $('#department').val();
                        d.doctor = $('#doctor').val();
                        d.referral = $('#referral').val();
                        d.market_by = $('#market_by').val();
                        d.provider = $('#provider').val();
                        d.from_date = $('#fromDate').val();
                        d.to_date = $('#toDate').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'dialysis_registers.id',
                        title: 'Dialysis ID',
                    },
                    {
                        data: 'dialysis_type',
                        name: 'dialysis_registers.dialysis_type',
                        title: 'Type',
                        render: function(data, type, row, meta) {
                            return `${row.dialysis_type} (${row.type})`;
                        },
                    },
                    {
                        data: 'patient_name',
                        name: 'p.name',
                        title: 'Patient (UHID)',
                        render: function(data, type, row, meta) {
                            return `${row.patient_name} (${row.patient_uhid || row.patient_id})`;
                        },
                    },
                    {
                        data: 'gender',
                        name: 'p.gender',
                        title: 'Gender',
                    },
                    {
                        data: 'dob_year',
                        name: 'p.dob_year',
                        title: 'Age',
                        render: function(data, type, row, meta) {
                            return `${row.dob_year ?? 0}Y ${row.dob_month ?? 0}M ${row.dob_day ?? 0}D`;
                        },
                    },
                    {
                        data: 'phone',
                        name: 'p.phone',
                        title: 'Mobile',
                    },
                    // {
                    //     data: 'guardian_name',
                    //     name: 'p.guardian_name',
                    //     title: 'Guardian Name',
                    // },
                    {
                        data: 'cre_date',
                        name: 'dialysis_registers.admission_date',
                        title: 'Admission Date',
                    },
                    {
                        data: 'ward_name',
                        name: 'w.ward_name',
                        title: 'Ward & Bed',
                        render: function(data, type, row, meta) {
                            return `${row.ward_name} || ${row.bed_name}`;
                        },
                    },
                    // {
                    //     data: 'tpa_name',
                    //     name: 'tpa.tpa_name',
                    //     title: 'Pt. Type',
                    // },
                    {
                        data: 'department_name',
                        name: 'd.department_name',
                        title: 'Department',
                    },
                    {
                        data: 'doctor_name',
                        name: 'u.name',
                        title: 'Doctor',
                        render: function(data, type, row, meta) {
                            return `Dr. ${row.doctor_name}`;
                        },
                    },
                    // {
                    //     data: 'type',
                    //     name: 'dialysis_registers.type',
                    //     title: 'Visit Type',
                    // },
                ],
                rowCallback: function(row, data) {
                    $(row).css('background-color', '#d3fdf7');
                }
            });
            updateDialysisExportLinks();
        });
        $('.data-table').on('xhr.dt', function(e, settings, json) {
            if (json.recordsTotal > 0) {
                if (window.chartsInitialized) {
                    return;
                }
                const totals = json.totals;
                const dialysis_type = totals.dialysis_type;
                const maleNew = totals.male_new;
                const maleOld = totals.male_old;
                const femaleNew = totals.female_new;
                const femaleOld = totals.female_old;
                const departmentNames = json.totalsByDept.map(item => item.department_name);
                const newArray = json.totalsByDept.map(item => Number(item.new_count));
                const oldArray = json.totalsByDept.map(item => Number(item.old_count));

                // Rebuild charts with updated data
                if (chart1) chart1.destroy();
                chart1 = new ApexCharts(document.querySelector("#chart1"), {
                    series: dialysis_type,
                    chart: {
                        width: '100%',
                        type: 'pie',
                    },
                    labels: ['DIRECT', 'MOVED BY IPD', 'MOVED BY EMG'],
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

                if (chart3) chart3.destroy();
                chart3 = new ApexCharts(document.querySelector("#chart3"), {
                    series: [{
                            name: 'Old',
                            data: [maleOld, femaleOld]
                        },
                        {
                            name: 'New',
                            data: [maleNew, femaleNew]
                        },
                    ],
                    chart: {
                        type: 'bar',
                        height: 300,
                        stacked: true,
                        toolbar: {
                            show: true
                        },
                        zoom: {
                            enabled: true
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            borderRadius: 10,
                            dataLabels: {
                                total: {
                                    enabled: true,
                                    style: {
                                        fontSize: '13px',
                                        fontWeight: 900
                                    }
                                }
                            }
                        }
                    },
                    xaxis: {
                        type: 'category',
                        categories: ['Male', 'Female']
                    },
                    legend: {
                        position: 'right',
                        offsetY: 40
                    },
                    fill: {
                        opacity: 1
                    }
                });
                chart3.render();

                if (chart4) chart4.destroy();
                chart4 = new ApexCharts(document.querySelector("#chart4"), {
                    series: [{
                            name: 'Old',
                            data: oldArray
                        },
                        {
                            name: 'New',
                            data: newArray
                        }
                    ],
                    chart: {
                        height: 300,
                        type: 'area',
                        animations: {
                            enabled: false
                        }
                    },
                    title: {
                        text: 'Total Departments',
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
                        categories: departmentNames
                    },
                });
                chart4.render();

                window.chartsInitialized = true;
            } else {
                if (chart1) chart1.destroy();
                if (chart3) chart3.destroy();
                if (chart4) chart4.destroy();
            }
        });

        function updateDialysisExportLinks() {
            const params = new URLSearchParams();
            const fields = {
                visit_type: $('#visit_type').val(),
                dialysis_type: $('#dialysis_type').val(),
                patient_type: $('#patient_type').val(),
                ward: $('#ward').val(),
                department: $('#department').val(),
                doctor: $('#doctor').val(),
                referral: $('#referral').val(),
                market_by: $('#market_by').val(),
                provider: $('#provider').val(),
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
            ['#dialysisPdfExport', '#dialysisExcelExport'].forEach(function(selector) {
                const link = $(selector);
                if (!link.length) return;
                const baseUrl = link.data('base-url') || link.attr('href');
                link.attr('href', query ? `${baseUrl}?${query}` : baseUrl);
            });
        }
    </script>
@endpush
