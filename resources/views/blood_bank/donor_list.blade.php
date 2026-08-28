@extends('layouts.structure')
@push('title')
    <title>DONOR</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">DONOR LIST</h4>
                    <div>
                        <a class="btn btn-sm btn-warning" href="{{ Route('bl.doner-register') }}">ADD NEW DONOR</a>
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
        var table;
        $(function() {
            let table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('bl.doners') }}"
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
                        title: 'Donor Name'
                    },
                    {
                        data: 'contact_number',
                        name: 'contact_number',
                        title: 'Contact Number'
                    },
                    {
                        data: 'gender',
                        name: 'gender',
                        title: 'Gender'
                    },
                    {
                        data: 'blood_group',
                        name: 'blood_group',
                        title: 'Blood Group'
                    },
                    {
                        data: 'dob',
                        name: 'dob',
                        title: 'Date Of Birth',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ldd',
                        name: 'ldd',
                        title: 'Last Donation Date',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });
        });
    </script>
@endpush
