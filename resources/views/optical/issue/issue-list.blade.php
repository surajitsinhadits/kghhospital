@extends('layouts.structure')
@push('title')
    <title>Optical Billing</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">
                    Optical Billing
                </h4>
                <div><a class="btn btn-sm btn-warning" href="{{ route('optical.add-billing') }}">CREATE BILL</a></div>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-responsive">
                    <table class="table table-borderless text-nowrap data-table">
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
    $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('optical.optical-billing') }}",
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
                    name: 'op_registers.id',
                    title: 'Optical ID',
                },
                {
                    data: 'patient',
                    name: 'p.name',
                    title: 'Patient Details',
                },
                {
                    data: 'billing_id',
                    name: 'b.id',
                    title: 'Bill ID',
                },
                {
                    data: 'bill_date',
                    name: 'bill_date',
                    title: 'Bill Date',
                },
                {
                    data: 'bill_amount',
                    name: 'bill_amount',
                    title: 'Bill Amount',
                },
                {
                    data: 'status',
                    name: 'status',
                    title: 'Status',
                    render: function(data, type, row) {
                        return row.status == 0 ? '<span class="badge badge-warning">Pending</span>' :
                               row.status == 1 ? '<span class="badge badge-primary">Confirm</span>' :
                               row.status == 2 ? '<span class="badge badge-info">Processing</span>' :
                               row.status == 3 ? '<span class="badge badge-success">Completed</span>' :
                               '<span class="badge badge-primary">Delivered</span>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    title: 'Action',
                    searchable: true
                },
            ],
            rowCallback: function(row, data) {
                if (data.color_status == 1) {
                    $(row).css('background-color', '#ffffb6');
                }else if (data.color_status == 2) {
                    $(row).css('background-color', '#d3fdf7');
                }else if (data.color_status == 3) {
                    $(row).css('background-color', '#d5ffd5');
                }else if (data.color_status == 4) {
                    $(row).css('background-color', '#9af0a4');
                }else if (data.color_status == 5) {
                    $(row).css('background-color', '#e6978cff');
                }
            }
        });
    });
</script>
@endpush
