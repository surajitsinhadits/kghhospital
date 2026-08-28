@extends('layouts.structure')
@push('title')
    <title>Purchase List</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">
                    Purchase List
                </h4>
                <div>
                   <span><a class="btn btn-sm btn-warning" href="{{ route('kt.add-purchase') }}">ADD NEW PURCHASE</a></span>
                </div>
            </div>
            <div class="card-header d-block">
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
                            <div class="col-sm-2">
                                <div class="form-group d-flex">
                                    <button type="submit" class="btn btn-primary px-3 mr-2"><i
                                            class="fas fa-filter"></i> Filter</button>
                                    <button type="button" class="btn btn-warning px-3" id="resetBtn"><i
                                            class="fas fa-history"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body p-0" style="margin-bottom: 32px;">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered data-table w-100">
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
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        table.draw();
    });
    $('#todayBtn').on('click', function() {
        const today = moment().format('DD-MM-YYYY');
        $('#fromDate').val(today);
        $('#toDate').val(today);
        table.draw();
    });
    $('#resetBtn').on('click', function() {
        // Clear all filters
        $('#fromDate').val('');
        $('#toDate').val('');

        // Redraw the DataTable (will trigger serverSide AJAX reload)
        table.draw();
    });
    $(function() {
        table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('kt.purchase') }}",
                data: function(d) {
                    d.from_date = $('#fromDate').val();
                    d.to_date = $('#toDate').val();
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
                    name: 'id',
                    title: 'Purchase No.',
                    render: function (data, type, row) {
                        return `KTP#${row.id}`;
                    },
                },
                {
                    data: 'invoice_no',
                    name: 'kt_purchases.invoice_no',
                    title: 'Invoice No.',
                },
                {
                    data: 'po_id',
                    name: 'po_id',
                    title: 'PO No.',
                    render: function (data, type, row) {
                        return `${row.po_id ? 'KTPO#'+row.po_id : ''}`;
                    },
                },
                {
                    data: 'supplier',
                    name: 's.supplier',
                    title: 'Supplier',
                },
                {
                    data: 'created_by',
                    name: 'u.name',
                    title: 'Generated By',
                },
                {
                    data: 'date',
                    name: 'date',
                    title: 'Date',
                    render: function(data, type, row) {
                        return `${formatDateTime(row.date)}`;
                    },
                },
                {
                    data: 'purchase_info',
                    name: 'purchase_info',
                    title: 'Payment Terms',
                },
                {
                    data: 'sub_total',
                    name: 'sub_total',
                    title: 'Sub Total',
                },
                {
                    data: 'total_gst_amount',
                    name: 'total_gst_amount',
                    title: 'GST',
                },
                {
                    data: 'discount_amount',
                    name: 'discount_amount',
                    title: 'Discount',
                },
                {
                    data: 'total',
                    name: 'total',
                    title: 'Total',
                },
                {
                    data: 'action',
                    name: 'action',
                    title: 'Action',
                    searchable: true
                },
            ],
        });
    });
</script>
@endpush
