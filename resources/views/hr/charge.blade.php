@extends('layouts.structure')
@push('title')
    <title>{{$title}}</title>
@endpush
@push('css')

@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">Charges List</h4>
                <a class="btn btn-sm btn-warning" href="{{Route('hr.charges-add')}}">Add Charges</a>
            </div>
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
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                lengthMenu: [
                    [50, 100, 200, 300, 400],
                    [50, 100, 200, 300, 400]
                ],
                ajax: "{{ route('hr.charges') }}",
                columns: [
                    {
                        data: null,
                        name: 'sl_no',
                        title: 'Sl. No',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'charge_type',
                        name: 'charge_type',
                        title: 'Charges Type',
                        render: function (data) {
                            return data ? data.toUpperCase() : '';
                        }
                    },
                    {
                        data: 'charge_section',
                        name: 'charge_section',
                        title: 'Charges Section',
                        render: function (data) {
                            return data ? data.toUpperCase() : '';
                        }
                    },
                    {
                        data: 'category_name',
                        name: 'cc.charges_catagories_name',
                        title: 'Category',
                        render: function (data) {
                            return data ? data.toUpperCase() : '';
                        }
                    },
                    {
                        data: 'charge_name',
                        name: 'charge_name',
                        title: 'Charges Name'
                    },
                    {
                        data: 'statusBtn',
                        name: 'statusBtn',
                        title: 'Actived'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Action'
                    },
                ]
            });
        });
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
