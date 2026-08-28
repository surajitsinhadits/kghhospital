@extends('layouts.structure')
@push('title')
    <title>Return Processing List</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">
                    Return Processing List
                </h4>
                <div>
                    <a class="btn btn-sm btn-warning" href="{{ route('store.add-return','store') }}">Return to Store</a>
                    @isok('STORE VENDOR RETURN')<a class="btn btn-sm btn-warning" href="{{ route('store.add-return','vendor') }}">Return to Vendor</a>@endisok
                </div>
            </div>
            <div class="card-body p-0" style="margin-bottom: 32px;">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap data-table">
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
    $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('store.return-list') }}",
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
                    title: 'Return ID',
                },
                {
                    data: 'return_type',
                    name: 'return_type',
                    title: 'Return Type',
                    render: function (data, type, row) {
                        return `${row.return_type == 'vendor' ? 'Vendor' : 'Department'}`;
                    },
                },
                {
                    data: 'department_name',
                    name: 'd.department_name',
                    title: 'Where ?',
                    render: function (data, type, row) {
                        return `${row.dept_id ? row.department_name : (row.vendor_id ? row.vendor_name : 'N/A')}`;
                    },
                },
                {
                    data: 'created_by',
                    name: 'u.name',
                    title: 'Request By',
                },
                {
                    data: 'return_date',
                    name: 'return_date',
                    title: 'Date',
                    render: function(data, type, row) {
                        return `${formatDateTime(row.return_date)}`;
                    },
                },
                {
                    data: 'remarks',
                    name: 'remarks',
                    title: 'Remark',
                },
                {
                    data: 'remarks',
                    name: 'remarks',
                    title: 'Status',
                    render: function(data, type, row) {
                        return `${row.status == 0 ? 'Pending' : (row.status == 1 ? 'Approved' : 'Rejected')}`;
                    },
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
