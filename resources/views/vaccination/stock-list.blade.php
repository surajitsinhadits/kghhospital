@extends('layouts.structure')
@push('title')
    <title>Vaccine Stock List</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">
                    Vaccine Stock List
                </h4>
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
    $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('vc.stock-details') }}",
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
                    data: 'vaccine_info',
                    name: 'vaccine_name',
                    title: 'Vaccine Name',
                },
                {
                    data: 'unit_relation',
                    name: 'unit_relation',
                    title: 'Units'
                },
                {
                    data: 'total_qty',
                    name: 'total_qty',
                    title: 'Available Stock',
                    render: function(data, type, row) {
                        let badgeClass = '';
                        if (data == 0) {
                            badgeClass = 'badge-gradient-secondary';
                        } else if (data <= 20) {
                            badgeClass = 'badge-gradient-warning';
                        } else {
                            badgeClass = 'badge-gradient-success';
                        }
                        return `<span class="badge ${badgeClass} mt-2">${data} ${row.sub_unit}</span>`;
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    title: 'Status',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    });
</script>
@endpush
