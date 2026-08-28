@extends('layouts.structure')
@push('title')
    <title>Item List</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">
                    ITEM LIST
                </h4>
                <div>
                    <a class="btn btn-sm btn-warning" href="{{Route('store.add-item')}}">ADD NEW ITEM</a>
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
            ajax: "{{ route('store.listing-item') }}",
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
                    name: 'item_name',
                    title: 'Item Name',
                },
                {
                    data: 'category_name',
                    name: 'c.category_name',
                    title: 'Item Category',
                },
                {
                    data: 'unit',
                    name: 'u.unit',
                    title: 'Unit',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'sub_unit',
                    name: 'su.unit',
                    title: 'Sub-Unit',
                    orderable: false,
                    searchable: false
                },
                {
                    data: null,
                    name: 'sub_unit_combined',
                    title: 'Relation',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        if (row.unit && row.sub_unit_no && row.sub_unit) {
                            return `
                                <div style="text-align: left;">
                                    <strong>1 ${row.unit} = ${row.sub_unit_no} ${row.sub_unit}</strong><br>
                                </div>
                            `;
                        }
                        return '-';
                    }

                },
                {
                    data: 'hsn_sac_no',
                    name: 'hsn_sac_no',
                    title: 'HSN or SAC No',
                },
                {
                    data: 'store_name',
                    name: 's.store_name',
                    title: 'Stored',
                    orderable: false,
                },
                 {
                    data: 'activate',
                    name: 'activate',
                    title: 'Activated',
                    orderable: false,
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
<script>
    function toggleStatus(id, table, col, element) {
        let url = "{{ route('is-active', ['id' => '__id__', 'table' => '__table__', 'col' => '__col__']) }}"
                    .replace('__id__', id)
                    .replace('__table__', table)
                    .replace('__col__', col);
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
        .then(data => {
            console.log("Status Updated!");
        }).catch(error => {
            console.error('Error:', error);
            element.checked = !element.checked;
        });
    }
</script>
@endpush
