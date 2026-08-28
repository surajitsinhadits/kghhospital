@extends('layouts.structure')
@push('title')
    <title>Appointments</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">APPOINTMENTS LIST</h4>
                <div>
                    <a class="btn btn-sm btn-warning" href="{{Route('opd.add-enquiry')}}">NEW ENQUIRY</a>
                    <a class="btn btn-sm btn-warning" href="{{Route('opd.opd-register')}}">NEW OPD REGISTER</a>
                </div>
            </div>
            <div class="card-header d-block">
                <form method="POST" id="filterForm">
                    @csrf
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select class="form-control" name="field_name" id="fieldName" onchange="changeField()">
                                    <option value="">SELECT FIELD</option>
                                    <option value="opd_enquiries.name">PATIENT NAME</option>
                                    {{-- <option value="opd_enquiries.id">Enquery No</option> --}}
                                    <option value="opd_enquiries.doctor_id">Doctor</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3" id="textInput">
                            <div class="form-group">
                                <input type="text" value="" class="form-control" id="fieldValue" name="field_value" placeholder="Field Value">
                            </div>
                        </div>
                        <div class="col-sm-3 d-none" id="selcetInput">
                            <div class="form-group">
                                <select class="form-control select2-show-search" name="select_value" id="selectValue">
                                    @foreach ($doctor as $doc)
                                    <option value="{{ $doc->id }}">Dr. {{ $doc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="text" value="" class="form-control datePickr" id="fromDate" name="from_date" placeholder="Choose From Date">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="text" value="" class="form-control datePickr" id="toDate" name="to_date" placeholder="Choose To Date">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group d-flex">
                                <button type="submit" class="btn btn-primary px-3 mr-2">Search</button>
                                <button type="button" class="btn btn-success px-3 mr-2" id="todayBtn">Today</button>
                                <button type="button" class="btn btn-warning px-3" id="resetBtn">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-responsive">
                    <table class="table table-bordered text-nowrap data-table">
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="slot_Change_modal">
    <div class="modal-dialog" role="document" style="width: 80% !important;">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Select Slot</h6>
                <button type="button" class="btn btn-primary btn-sm" onclick="modelDelete()"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="d-md-flex">
                    <div class="border" style="width: 25%;">
                        <div class="panel panel-primary tabs-style-4">
                            <div class="">
                                <div class="tabs-menu ">
                                    <ul class="nav panel-tabs mt-2 ml-5 " id="all_slot"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tabs-style-4" style="width: 80%;">
                        <div class="panel-body tabs-menu-body">
                            <div class="tab-content">
                                <div class="row">
                                    <span id="jhfhf" style="margin: 0px 0px 0px 290px;font-size: 20px;">No data found</span>
                                </div>
                                <div class="row" id="allvilable_unavi_slot"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
		$("body").on("click", function(event) {
			$('#search_result').attr('style', 'display:none', true);
		});
	});
    function modelDelete() {
        $('#allvilable_unavi_slot').html('');
        $('#jhfhf').html('');
        $('#all_slot').html('');
        $('#slot_Change_modal').modal('hide');
    }
    function slotChangeModal(doctor_id, enq_id) {
        if (doctor_id) {
            $('#all_slot').html('');
            $('#jhfhf').html('');
            var div_data = '';
            $.ajax({
                url: "{{ route('opd.get-schedule') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    doctorId: doctor_id,
                },
                success: function(response) {
                    if (response.success && (response.uniqueDates.length > 0)) {
                        $.each(response.uniqueDates, function(key, value) {
                            div_data += `<button onclick="getslotdetails(${response.doctor_id},'${value}',${enq_id})" type="button" class="btn btn-primary" style="margin-bottom: 10px; padding:4px 14px; margin-right:7px;font-size:14px;">
                                <i class="fa fa-calendar"></i> ${formatDate(value)}
                            </button> `;
                        });
                    }
					$('#all_slot').append(div_data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
            $('#slot_Change_modal').modal('show');
        }

        function formatDate(inputDate) {
			var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
			var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
			var parts = inputDate.split('-'); // Split the input date into year, month, and day parts
			var day = parseInt(parts[2]);
			var monthIndex = parseInt(parts[1]) - 1; // Months in JavaScript are 0-based
			var year = parseInt(parts[0]);

			// Create a Date object to get the day of the week
			var formattedDate = new Date(year, monthIndex, day);
			var dayOfWeek = days[formattedDate.getDay()];

			// Format the date as desired (e.g., '15 Jan 2022 (Sat)')
			var formattedDateString = day + ' ' + months[monthIndex] + ' ' + year + ' <br>' + dayOfWeek;
			return formattedDateString;
		}
    }
    function getslotdetails(doctor, dat, enq_id) {
        $('#allvilable_unavi_slot').html('');
        $('#jhfhf').html('');
        var div_data = '';
        $.ajax({
            type: 'POST',
            url: "{{ Route('opd.get-timeslot') }}",
            data: {
                _token: '{{ csrf_token() }}',
                doctor_id: doctor,
                date: dat,
            },
            success: function(response) {
                if (response.success && (response.uniqueDates_withtiming.length > 0)) {
                    $('#jhfhf').html(response.p_date + ' ( ' + response.p_day + ' ) ');
                    $.each(response.uniqueDates_withtiming, function(key, value) {
                        div_data += `<div class="col-xl-3 col-lg-3 col-md-12 my-2">
                            ${value.booked < value.patient_per_slot && value.is_active == '1' ?
                                `<form method="post" action="{{Route('opd.change-timeslot')}}">
                                    @csrf
                                    <input type="hidden" name="a_date" value="${response.a_date}" />
                                    <input type="hidden" name="from_time" value="${value.from_time}" />
                                    <input type="hidden" name="id" value="${value.id}" />
                                    <input type="hidden" name="enq_id" value="${enq_id}" />
                                    <button type="submit" class="btn btn-success">
                                            <h2 class="mb-1 font-weight-bold">${formatTime(value.from_time)} - ${formatTime(value.to_time)}</h2>
                                            <span><b>${value.booked}</b> </span> / <span><b>${value.patient_per_slot}</b></span>
                                    </button>
                                </form>` :
                                `<button type="button" class="btn btn-warning">
                                        <h2 class="mb-1 font-weight-bold">${formatTime(value.from_time)} - ${formatTime(value.to_time)}</h2>
                                        <span><b>${value.booked}</b></span> / <span><b>${value.patient_per_slot}</b> ${value.is_active != '1' ? `|| Deactive` : ``}</span>
                                </button>`
                            }
                        </div>`;
                    });
                    $('#allvilable_unavi_slot').append(div_data);
                }
            },
            error: function(error) {
                console.error(error);
            }
        });
        function formatTime(time) {
			var formattedTime = '';  // Convert the time string to a Date object
			var dateObj = new Date('1970-01-01T' + time + ':00');  // Get hours and minutes from the Date object
			var hours = dateObj.getHours();
			var minutes = dateObj.getMinutes();
			var amOrPm = hours >= 12 ? 'PM' : 'AM';  // Determine if it's AM or PM
			hours = hours % 12;  // Convert to 12-hour format
			hours = hours ? hours : 12; // Handle 0 hours (midnight)
			var formattedHours = hours < 10 ? '0' + hours : hours;  // Format hours and minutes as two digits (e.g., 08 instead of 8)
			var formattedMinutes = minutes < 10 ? '0' + minutes : minutes;
			formattedTime = formattedHours + ':' + formattedMinutes + ' ' + amOrPm;  // Construct the formatted time string
			return formattedTime;
		}
    }
</script>
<script type="text/javascript">
    var table;
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        table.draw();
    });
    $('#todayBtn').on('click', function () {
        const today = moment().format('DD-MM-YYYY');
        $('#fromDate').val(today);
        $('#toDate').val(today);
        table.draw();
    });
    $('#resetBtn').on('click', function () {
        // Clear all filters
        $('#fieldName').val('');
        $('#fieldValue').val('');
        $('#selectValue').val('');
        $('#fromDate').val('');
        $('#toDate').val('');

        // Show text input, hide section select (if needed)
        $('#textInput').removeClass('d-none');
        $('#selcetInput').addClass('d-none');

        // Redraw the DataTable (will trigger serverSide AJAX reload)
        table.draw();
    });
    function setDefaultDatesIfBlank() {
        let fromDate = $('#fromDate').val();
        let toDate = $('#toDate').val();
        if (!fromDate && !toDate) {
            let today = moment();
            $('#fromDate').val(today.format('DD-MM-YYYY'));
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
                url: "{{ route('opd.appointments') }}",
                data: function(d) {
                    d.field_name = $('#fieldName').val();
                    d.field_value = $('#fieldValue').val();
                    d.select_value = $('#selectValue').val();
                    d.from_date = $('#fromDate').val();
                    d.to_date = $('#toDate').val();

                    // override field_value if section is selected
                    if (d.field_name === 'opd_enquiries.doctor_id') {
                        d.field_value = d.select_value;
                    }
                }
            },
            columns: [
                {
                    data: null,
                    name: 'sl_no',
                    title: 'SN',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'id',
                    name: 'opd_enquiries.id',
                    title: 'Enq No.',
                    orderable: false,
                },
                {
                    data: 'booking_time',
                    name: 'uhid',
                    title: 'Booking Time',
                    render: function(data, type, row) {
                        return `${formatDateTime(row.booking_time)}`.trim();
                    },
                    orderable: false,
                    searchable: true
                },
                {
                    data: null,
                    name: 'booking_name',
                    title: 'Booking By',
                    render: function(data, type, row) {
                        return `${row.bs || ''} ${row.booking_name}`.trim();
                    },
                    orderable: false,
                    searchable: true
                },
                {
                    data: null,
                    name: 'name',
                    title: 'Patient',
                    render: function(data, type, row) {
                        return `
                            <span>${row.name.trim()}
                                <span class="badge badge-gradient-success mt-2">${row.uhid ? 'Old' : 'New'} Patient</span>
                                <br>
                                <i class="fas fa-yin-yang text-primary"></i> UHID: ${row.uhid || '--'},
                                <i class="fa fa-calendar-alt text-primary"></i> Age: ${row.dob_year || '--'},
                                <i class="fa fa-phone-alt text-primary"></i> Mobile: ${row.phone || '--'}
                            </span>
                        `;
                    },
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'doctor_name',
                    name: 'doctor_name',
                    title: 'Doctor',
                    render: function(data, type, row) {
                        return `${row.ds || ''} ${row.doctor_name}`.trim();
                    },
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'app_date',
                    name: 'phone',
                    title: 'App. Date & time',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: null,
                    name: 'gender',
                    title: 'Re-Schedule',
                    render: function(data, type, row) {
                        const acurl = `<a href="#" class="btn btn-primary btn-sm" onclick="slotChangeModal(${row.doctor_id},${row.id})" data-placement="left" data-toggle="tooltip" title="Click here for Slot Change"><i class="fa fa-plus"></i></a>`;
                        return `${acurl}`;
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    title: 'Action',
                    orderable: false,
                },
            ],
            rowCallback: function(row, data) {
                if (data.is_register == 1) {
                    $(row).css('background-color', '#d3fdf7');
                }else{
                    $(row).css('background-color', '#ffff9b');
                }
            }
        });
    });
    changeField();
    function changeField() {
        var field = $('#fieldName').val();
        if (field == 'opd_enquiries.doctor_id') {
            $('#selcetInput').removeClass('d-none');
            $('#textInput').addClass('d-none');
        } else {
            $('#textInput').removeClass('d-none');
            $('#selcetInput').addClass('d-none');
        }
    }
</script>
@endpush
