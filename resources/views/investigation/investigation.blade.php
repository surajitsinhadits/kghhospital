@extends('layouts.structure')
@push('title')
    <title>Investigation</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">INVESTIGATION LIST</h4>
                <div>
                    <a class="btn btn-sm btn-outline-warning" href="{{Route('investigation.investigation-register')}}"><i class="fa fa-money-bill-alt text-warning"></i> CREATE BILL</a>
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
                                    <option value="p.name">PATIENT NAME</option>
                                    <option value="p.uhid">UHID</option>
                                    <option value="p.phone">Phone No</option>
                                    <option value="investigation_registers.referred_by">Referrel</option>
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
                                    <option value="{{ $doc->id }}">{{ $doc->referral_name }}</option>
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
@endsection
@push('js')
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
            pageLength: 20,
            lengthMenu: [
                [20, 50, 100, 500],
                [20, 50, 100, 500]
            ],
            ajax: {
                url: "{{ route('investigation.investigation') }}",
                data: function(d) {
                    const today = new Date().toISOString().split('T')[0];
                    d.field_name = $('#fieldName').val();
                    d.field_value = $('#fieldValue').val();
                    d.select_value = $('#selectValue').val();
                    if($('#fieldName').val()){
                        d.from_date = $('#fromDate').val();
                        d.to_date = $('#toDate').val();
                    }else{
                        d.from_date = $('#fromDate').val() || today;
                        d.to_date = $('#toDate').val() || today;
                    }

                    // override field_value if section is selected
                    if (d.field_name === 'investigation_registers.referred_by') {
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
                    data: 'billing',
                    name: 'b.uid',
                    title: 'Bill NO',
                },
                {
                    data: 'patient_uhid',
                    name: 'p.uhid',
                    title: 'UHID',
                },
                {
                    data: 'patient',
                    name: 'p.name',
                    title: 'Patient',
                },
                {
                    data: 'phone',
                    name: 'p.phone',
                    title: 'Mobile',
                },
                {
                    data: 'referral_name',
                    name: 'r.referral_name',
                    title: 'Ref. Doctor',
                },
                {
                    data: 'appointment_date',
                    name: 'investigation_registers.appointment_date',
                    title: 'Date & Time',
                    render: function(data, type, row) {
                        return `${formatDateTime(row.appointment_date)}`;
                    },
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'due',
                    name: 'b.due_amount',
                    title: 'Due',
                    render: function(data, type, row) {
                        return `${row.due_amount}`.trim();
                    },
                },
                {
                    data: 'action',
                    name: 'action',
                    title: 'Action'
                },
            ],
            rowCallback: function(row, data) {
                if(data.bill_status == 3){
                    $(row).css('background-color', '#eabbbb');
                }else{
                    if(data.due_amount > 0){
                        $(row).css('background-color', '#ffff9b');
                    }else{
                        $(row).css('background-color', '#d3fdf7');
                    }
                }
            }
        });
    });
    changeField();
    function changeField() {
        var field = $('#fieldName').val();
        if (field == 'investigation_registers.referred_by') {
            $('#selcetInput').removeClass('d-none');
            $('#textInput').addClass('d-none');
        } else {
            $('#textInput').removeClass('d-none');
            $('#selcetInput').addClass('d-none');
        }
    }
</script>
@endpush
