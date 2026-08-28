@extends('layouts.structure')
@push('title')
    <title>Stock Report</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">ITEM STOCK REPORT</h4>
            </div>
            <div class="card-body">
                <div class="card-header d-block">
                    <form method="POST" id="filterForm">
                        @csrf
                        <div class="row justify-content-center mb-2">
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
                                    <button type="submit" class="btn btn-primary px-3 mr-2">Filter</button>
                                    <button type="button" class="btn btn-success px-3 mr-2" id="todayBtn">Today</button>
                                    <button type="button" class="btn btn-warning px-3" id="resetBtn">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered data-table">
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
    var itemInfoUrl = "{{ route('store.item-info', ':id') }}";

    function renderItemInfoLink(data, type, row) {
        if (type !== 'display' || !row.item_id) {
            return data;
        }

        var url = itemInfoUrl.replace(':id', btoa(row.item_id));
        var itemName = $('<div>').text(data || '').html();

        return '<a href="' + url + '">' + itemName + '</a>';
    }

    function reloadStockTable() {
        if (table) {
            table.ajax.reload();
        }
    }

    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        reloadStockTable();
    });
    $('#todayBtn').on('click', function () {
        const today = moment().format('DD-MM-YYYY');
        $('#fromDate').val(today);
        $('#toDate').val(today);
        reloadStockTable();
    });
    $('#resetBtn').on('click', function () {
        $('#fromDate').val('');
        $('#toDate').val('');
        reloadStockTable();
    });

    $(function() {
        table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('store.stock-reports') }}",
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
                    data: 'item_name',
                    name: 'si.item_name',
                    title: 'Item',
                    render: renderItemInfoLink,
                },
                {
                    data: 'issue_date',
                    name: 'st_stocks.date',
                    title: 'Date',
                },
                // {
                //     data: 'exp_date',
                //     name: 'st_stocks.exp_date',
                //     title: 'Exp Date',
                // },
                {
                    data: 'created_by',
                    name: 'u.name',
                    title: 'Updated By',
                },
                {
                    data: 'part_no',
                    name: 'st_stocks.part_no',
                    title: 'Batch No',
                },
                {
                    data: 'qty',
                    name: 'st_stocks.unit_qty',
                    title: 'QTY',
                },
                {
                    data: 'unit_mrp',
                    name: 'st_stocks.unit_mrp',
                    title: 'MRP/Unit',
                },
                {
                    data: 'unit_rate',
                    name: 'st_stocks.unit_rate',
                    title: 'Rate/Unit',
                },
                {
                    data: 'sub_total',
                    name: 'st_stocks.sub_total',
                    title: 'Sub Total',
                },
                // {
                //     data: 'cgst_value',
                //     name: 'st_stocks.cgst_value',
                //     title: 'CGST',
                // },
                // {
                //     data: 'sgst_value',
                //     name: 'st_stocks.sgst_value',
                //     title: 'SGST',
                // },
                // {
                //     data: 'igst_value',
                //     name: 'st_stocks.igst_value',
                //     title: 'IGST',
                // },
                {
                    data: 'total',
                    name: 'st_stocks.total',
                    title: 'Total',
                }
            ],
            rowCallback: function(row, data) {
                $(row).css('background-color', '#d3fdf7');
            }
        });
    });
</script>
@endpush
