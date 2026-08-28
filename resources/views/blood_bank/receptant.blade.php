@extends('layouts.structure')
@push('title')
    <title>RECEPTANT</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">RECEPTANT LIST</h4>
                    <div>
                        <a class="btn btn-sm btn-warning" href="{{ route('bl.receptant-register') }}">NEW RECEPTANT REGISTER</a>
                    </div>
                </div>
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
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('bl.get-receptant') }}", // This should point to your get_receptant() route
                    data: function(d) {
                        const today = new Date().toISOString().split('T')[0];

                        // You can add filters here if you have inputs on your page, e.g.:
                        d.section_id = $('#sectionId').val(); // if you add a filter for section_id
                        d.from_date = $('#fromDate').val() || today;
                        d.to_date = $('#toDate').val() || today;
                    }
                },
                columns: [{
                        data: null,
                        name: 'sl_no',
                        title: 'SN',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        title: 'Patient Name'
                    },
                    {
                        data: 'donated_date',
                        name: 'donated_date',
                        title: 'Donated Date'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        title: 'Quantity'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        title: 'Added On',
                        render: function(data) {
                            return formatDateTime(data);
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Action',
                        orderable: false,
                        searchable: false
                    }
                ],
                rowCallback: function(row, data) {
                    // You can optionally style rows if needed, e.g. no status field now, so remove
                }
            });
        });
    </script>
@endpush
