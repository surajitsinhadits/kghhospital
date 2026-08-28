@extends('layouts.structure')

@push('title')
    <title>OPD Patients Report</title>
@endpush

@push('css')
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto);

        body { font-family: Roboto, sans-serif; }

        #chart1 { max-width: 100%; margin: 5px auto; }
        #chart2 { max-width: 40%; margin: 5px auto; }
    </style>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">OPD PATIENTS REPORT</h4>
                </div>

                <div class="">
                    <div class="">
                        <form method="POST" id="filterForm">
                            @csrf

                            <div class="whitebackground">
                                <div class="row">

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="visit_type">Visit Type</label>
                                            <select class="form-control mt-1" name="visit_type" id="visit_type">
                                                <option value="">Select</option>
                                                <option value="new">New</option>
                                                <option value="old">Old</option>
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
                                            <label for="doctor">Consultant Doctor</label>
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
                                            <label for="referral">Referral</label>
                                            <select class="form-control select2-show-search" name="referral" id="referral">
                                                <option value="">Select</option>
                                                @foreach ($referral as $ref)
                                                    <option value="{{ $ref->id }}">{{ $ref->referral_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
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

                                    <div class="col-sm-2">
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

                                    {{-- ✅ Hospital Type --}}
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select name="hospital_type" id="hospital_type" class="form-control mt-1">
                                                <option value="3" selected>KGH Hospital</option>
                                                <option value="4">JMN Medical College</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- ✅ OPD Type (only for KGH) --}}
                                    <div class="col-md-2" id="opdTypeWrap">
                                        <div class="form-group">
                                            <select id="opd_sub_type" class="form-control mt-1">
                                                <option value="">Select OPD Type</option>
                                                <option value="1">OPD</option>
                                                <option value="2">ORC (OUT REACH PAID OPD CLINIC)</option>
                                                <option value="3">Free Camp OPD</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- ✅ only this field is POSTED as opd_type --}}
                                    <input type="hidden" name="opd_type" id="opd_type_final" value="">

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

                                    <div class="col-sm-4">
                                        <div class="form-group d-flex flex-wrap">
                                            <button type="submit" class="btn btn-primary px-3 mr-2">
                                                <i class="fas fa-filter"></i> Filter
                                            </button>

                                            <button type="button" class="btn btn-success px-3 mr-2" id="todayBtn">
                                                <i class="fas fa-calendar-week"></i> Today
                                            </button>

                                            <button type="button" class="btn btn-warning px-3 mr-2" id="resetBtn">
                                                <i class="fas fa-history"></i> Reset
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="row reportmargin">
                        <div class="col-md-3 chartrareadesign">
                            <div id="chart3" style="height: 330px;"></div>
                        </div>
                        <div class="col-md-9">
                            <div id="chart4" style="height: 330px;"></div>
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

    // ✅ sets hidden opd_type based on selections
    function syncOpdType() {
        const hospital = $('#hospital_type').val(); // 3 or 4
        const opdSub   = $('#opd_sub_type').val();  // 1/2/3 or ""

        if (hospital === '4') {
            // JMN -> hide dropdown, send only 4
            $('#opdTypeWrap').hide();
            $('#opd_sub_type').val('');
            $('#opd_type_final').val('4');
        } else {
            // KGH -> show dropdown, send opd type (1/2/3)
            $('#opdTypeWrap').show();
            $('#opd_type_final').val(opdSub); // can be empty until filter click
        }
    }

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

    // ✅ ONLY filter button triggers table reload
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();

        // set hidden opd_type just before requesting data
        syncOpdType();

        window.chartsInitialized = false;
        table.draw();
        updateOpdExportLinks();
    });

    // ✅ today button triggers reload
    $('#todayBtn').on('click', function() {
        const today = moment().format('DD-MM-YYYY');
        $('#fromDate').val(today);
        $('#toDate').val(today);

        syncOpdType();
        window.chartsInitialized = false;
        table.draw();
        updateOpdExportLinks();
    });

    // ✅ reset triggers reload
    $('#resetBtn').on('click', function() {
        $('#visit_type').val('');
        $('#department').val('').trigger('change');
        $('#doctor').val('').trigger('change');
        $('#referral').val('').trigger('change');
        $('#market_by').val('').trigger('change');
        $('#provider').val('').trigger('change');

        // default hospital KGH
        $('#hospital_type').val('3');
        $('#opd_sub_type').val('');

        $('#fromDate').val('');
        $('#toDate').val('');

        syncOpdType();
        window.chartsInitialized = false;
        table.draw();
        updateOpdExportLinks();
    });

    // ✅ ONLY UI behavior (NO filtering on change)
    $('#hospital_type').on('change', function() {
        syncOpdType(); // only show/hide + set hidden value
        updateOpdExportLinks(); // optional: keep export ready
    });

    $('#opd_sub_type').on('change', function() {
        syncOpdType(); // only set hidden value
        updateOpdExportLinks(); // optional
    });

    $(function() {
        setDefaultDatesIfBlank();
        syncOpdType();

        table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            lengthMenu: [
                [50, 100, 200, 300, 400],
                [50, 100, 200, 300, 400]
            ],
            ajax: {
                url: "{{ route('reports.opd') }}",
                data: function(d) {
                    d.visit_type = $('#visit_type').val();
                    d.department = $('#department').val();
                    d.doctor = $('#doctor').val();
                    d.referral = $('#referral').val();
                    d.market_by = $('#market_by').val();
                    d.provider = $('#provider').val();

                    // ✅ only value sent to server
                    d.opd_type = $('#opd_type_final').val();

                    d.from_date = $('#fromDate').val();
                    d.to_date = $('#toDate').val();
                }
            },
            columns: [
                { data: 'id', name: 'opd_registers.id', title: 'OPD ID' },
                {
                    data: 'patient_name',
                    name: 'p.name',
                    title: 'Patient Name (UHID)',
                    render: function(data, type, row) {
                        return `${row.patient_name} (${row.patient_id})`;
                    },
                },
                { data: 'gender', name: 'p.gender', title: 'Gender' },
                {
                    data: 'dob_year',
                    name: 'opd_registers.patient_id',
                    title: 'Age',
                    render: function(data, type, row) {
                        return `${row.dob_year ?? 0}Y ${row.dob_month ?? 0}M ${row.dob_day ?? 0}D`;
                    },
                },
                { data: 'phone', name: 'p.phone', title: 'Mobile' },
                { data: 'type', name: 'opd_registers.type', title: 'Visit Type' },
                { data: 'cre_date', name: 'opd_registers.appointment_date', title: 'Appointment Date' },
                { data: 'department_name', name: 'd.department_name', title: 'Department' },
                {
                    data: 'doctor_name',
                    name: 'u.name',
                    title: 'Doctor',
                    render: function(data, type, row) {
                        return `Dr. ${row.doctor_name}`;
                    },
                }
            ],
            rowCallback: function(row, data) {
                $(row).css('background-color', '#d3fdf7');
            }
        });

        updateOpdExportLinks();
    });

    $('.data-table').on('xhr.dt', function(e, settings, json) {
        if (json.recordsTotal > 0) {
            if (window.chartsInitialized) return;

            const totals = json.totals;
            const maleNew = totals.male_new;
            const maleOld = totals.male_old;
            const femaleNew = totals.female_new;
            const femaleOld = totals.female_old;

            const departmentNames = json.totalsByDept.map(item => item.department_name);
            const newArray = json.totalsByDept.map(item => Number(item.new_count));
            const oldArray = json.totalsByDept.map(item => Number(item.old_count));

            if (chart3) chart3.destroy();
            chart3 = new ApexCharts(document.querySelector("#chart3"), {
                series: [
                    { name: 'Old', data: [maleOld, femaleOld] },
                    { name: 'New', data: [maleNew, femaleNew] },
                ],
                chart: {
                    type: 'bar',
                    height: 300,
                    stacked: true,
                    toolbar: { show: true },
                    zoom: { enabled: true }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 10,
                        dataLabels: {
                            total: {
                                enabled: true,
                                style: { fontSize: '13px', fontWeight: 900 }
                            }
                        }
                    }
                },
                xaxis: { type: 'category', categories: ['Male', 'Female'] },
                legend: { position: 'right', offsetY: 40 },
                fill: { opacity: 1 }
            });
            chart3.render();

            if (chart4) chart4.destroy();
            chart4 = new ApexCharts(document.querySelector("#chart4"), {
                series: [
                    { name: 'Old', data: oldArray },
                    { name: 'New', data: newArray }
                ],
                chart: { height: 300, type: 'area', animations: { enabled: false } },
                title: {
                    text: 'Total Departments',
                    align: 'center',
                    style: { fontSize: '18px', fontWeight: 'bold' }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                xaxis: { type: 'category', categories: departmentNames },
            });
            chart4.render();

            window.chartsInitialized = true;
        } else {
            if (chart3) chart3.destroy();
            if (chart4) chart4.destroy();
        }
    });

    function updateOpdExportLinks() {
        const params = new URLSearchParams();
        const fields = {
            visit_type: $('#visit_type').val(),
            department: $('#department').val(),
            doctor: $('#doctor').val(),
            referral: $('#referral').val(),
            market_by: $('#market_by').val(),
            provider: $('#provider').val(),

            // ✅ export uses same opd_type
            opd_type: $('#opd_type_final').val(),

            from_date: $('#fromDate').val(),
            to_date: $('#toDate').val(),
        };

        Object.keys(fields).forEach(function(key) {
            const value = fields[key];
            if (value) params.set(key, value);
        });

        const query = params.toString();
        ['#opdPdfExport', '#opdExcelExport'].forEach(function(selector) {
            const link = $(selector);
            if (!link.length) return;
            const baseUrl = link.data('base-url') || link.attr('href');
            link.attr('href', query ? `${baseUrl}?${query}` : baseUrl);
        });
    }
</script>
@endpush
