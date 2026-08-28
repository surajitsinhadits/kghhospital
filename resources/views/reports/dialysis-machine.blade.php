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
                    <h4 class="card-title card_hearder_mimi_text">DIALYSIS MACHINE REPORT</h4>
                </div>
                <div class="">
                    <div class="">
                        <form method="POST" id="filterForm">
                            @csrf
                            <div class="whitebackground">
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="machine_no">Machine</label>
                                        <select class="form-control mt-1" name="machine_no" id="machine_no">
                                            <option value="">Select</option>
                                            <option value="3XKA4L8U">3XKA4L8U (40008s)</option>
                                            <option value="3XKA4L8V">3XKA4L8V (40008s)</option>
                                            <option value="3XKA4L8X">3XKA4L8X (40008s)</option>
                                            <option value="3XKA4L8Y">3XKA4L8Y (40008s)</option>
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
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="fromDate">From Date</label>
                                        <input type="text" value="" class="form-control datePickr" id="fromDate"
                                            name="from_date" placeholder="Choose From Date">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="toDate">To Date</label>
                                        <input type="text" value="" class="form-control datePickr" id="toDate"
                                            name="to_date" placeholder="Choose To Date">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group d-flex flex-wrap mt-3">
                                        <button type="submit" class="btn btn-primary px-3 mr-2"><i
                                            class="fas fa-filter"></i> Filter</button>
                                        <button type="button" class="btn btn-success px-3 mr-2"
                                            id="todayBtn"><i
                                            class="fas fa-calendar-week"></i> Today</button>
                                        <button type="button" class="btn btn-warning px-3 mr-2" id="resetBtn"><i
                                            class="fas fa-history"></i> Reset</button>
                                        <!-- <a href="{{ route('reports.dialysis-machine.export', ['format' => 'pdf']) }}"
                                            class="btn btn-danger px-3 mr-2" id="dialysisPdfExport"
                                            data-base-url="{{ route('reports.dialysis-machine.export', ['format' => 'pdf']) }}"><i
                                                class="fas fa-file-pdf"></i> PDF</a> -->
                                        <a href="{{ route('reports.dialysis-machine.export', ['format' => 'excel']) }}"
                                            class="btn btn-success px-3" id="dialysisExcelExport"
                                            data-base-url="{{ route('reports.dialysis-machine.export', ['format' => 'excel']) }}"><i
                                                class="fas fa-file-excel"></i> Excel</a>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                    <div class="row reportmargin">
                        <div class="col-md-6">
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
        let chart3, chart4;

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
        $('#machine_no, #department, #doctor, #fromDate, #toDate').on('change', updateDialysisExportLinks);
        $('#todayBtn').on('click', function() {
            const today = moment().format('DD-MM-YYYY');
            $('#fromDate').val(today);
            $('#toDate').val(today);
            refreshDialysisData();
        });
        $('#resetBtn').on('click', function() {
            // Clear all filters
            $('#machine_no').val('').trigger('change');
            $('#department').val('').trigger('change');
            $('#doctor').val('').trigger('change');
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
                    url: "{{ route('reports.dialysis-machine') }}",
                    data: function(d) {
                        d.machine_no = $('#machine_no').val();
                        d.department = $('#department').val();
                        d.doctor = $('#doctor').val();
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
                        data: 'patient_name',
                        name: 'p.name',
                        title: 'Patient (UHID)',
                        render: function(data, type, row, meta) {
                            return `${row.patient_name} (${row.patient_id})`;
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
                    {
                        data: 'machine_no',
                        name: 'dmh.machine_no',
                        title: 'Machine No',
                    },
                    {
                        data: 'start_time',
                        name: 'dmh.start_time',
                        title: 'Start Time',
                    },
                    {
                        data: 'end_time',
                        name: 'dmh.end_time',
                        title: 'End Time',
                    },
                    {
                        data: 'ward_name',
                        name: 'w.ward_name',
                        title: 'Ward & Bed',
                        render: function(data, type, row, meta) {
                            return `${row.ward_name} || ${row.bed_name}`;
                        },
                    },
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
                ],
                rowCallback: function(row, data) {
                    $(row).css('background-color', '#d3fdf7');
                }
            });
            updateDialysisExportLinks();
        });
        const dialysisMachineNumbers = ['3XKA4L8U', '3XKA4L8V', '3XKA4L8X', '3XKA4L8Y'];
        const dialysisMachineLabels = {
            '3XKA4L8U': '3XKA4L8U (40008s)',
            '3XKA4L8V': '3XKA4L8V (40008s)',
            '3XKA4L8X': '3XKA4L8X (40008s)',
            '3XKA4L8Y': '3XKA4L8Y (40008s)',
        };

        $('.data-table').on('xhr.dt', function(e, settings, json) {
            if (window.chartsInitialized) {
                return;
            }

            const totalsByMachine = json.totalsByMachine || [];
            const machineTotals = {};
            totalsByMachine.forEach(function(item) {
                if (item.machine_no) {
                    machineTotals[item.machine_no] = item;
                }
            });

            const machineNames = dialysisMachineNumbers.map(function(machineNo) {
                return dialysisMachineLabels[machineNo];
            });
            const machineNewArray = dialysisMachineNumbers.map(function(machineNo) {
                return Number((machineTotals[machineNo] && machineTotals[machineNo].new_count) || 0);
            });
            const machineOldArray = dialysisMachineNumbers.map(function(machineNo) {
                return Number((machineTotals[machineNo] && machineTotals[machineNo].old_count) || 0);
            });

            // Rebuild machine chart with all configured machines, even when counts are zero.
            if (chart3) chart3.destroy();
            chart3 = new ApexCharts(document.querySelector("#chart3"), {
                series: [{
                        name: 'Old',
                        data: machineOldArray
                    },
                    {
                        name: 'New',
                        data: machineNewArray
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
                title: {
                    text: 'Total Machines',
                    align: 'center',
                    style: {
                        fontSize: '18px',
                        fontWeight: 'bold'
                    }
                },
                xaxis: {
                    type: 'category',
                    categories: machineNames
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

            if (json.recordsTotal > 0) {
                const totalsByDept = json.totalsByDept || [];
                const departmentNames = totalsByDept.map(item => item.department_name);
                const newArray = totalsByDept.map(item => Number(item.new_count));
                const oldArray = totalsByDept.map(item => Number(item.old_count));

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
                if (chart4) chart4.destroy();
                window.chartsInitialized = true;
            }
        });

        function updateDialysisExportLinks() {
            const params = new URLSearchParams();
            const fields = {
                machine_no: $('#machine_no').val(),
                department: $('#department').val(),
                doctor: $('#doctor').val(),
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
