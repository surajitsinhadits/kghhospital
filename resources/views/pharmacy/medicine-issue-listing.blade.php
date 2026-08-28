@extends('layouts.structure')

@push('title')
    <title>{{ $title }} - {{ hospital('title') }}</title>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header d-block card_hearder_mimi">
                    <div class="row">
                        <div class="col-md-6 card-title card_hearder_mimi_text">
                            Medicine Issue Report
                        </div>

                        {{-- <div class="col-md-6 text-right">
                            <div class="d-block">

                                <a href="{{ route('pharmacy.add-requisition') }}" class="btn btn-primary btn-sm">Create
                                    Requisition</a>

                            </div>
                        </div> --}}
                    </div>
                </div>


                <div class="card-bodyp hospital_allcardbodydesign border" style="display:none" id="search_result">
                    <div class="table-responsive">
                        <table class="table table-hover card-table table-vcenter text-nowrap border"
                            style="background-color:#d9d9d9;border:1px solid black !important;    width: 50%;">
                            <thead class="text-white" style="background-color:#5e6545">
                                <tr class="border-left">
                                    <th class="text-white">Medicine Name</th>
                                </tr>
                            </thead>
                            <tbody id="search_result_row">

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-body">
                    <div class="">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered data-table w-100">
                                <thead>

                                </thead>
                                <tbody>

                                </tbody>
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
                ajax: "{{ route('pharmacy.issue-report') }}",
                columns: [{
                        data: null,
                        name: 'sl_no',
                        title: 'Sl. No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: 'id',
                        title: 'Issue No',

                    },
                    {
                        data: 'issue_date',
                        name: 'issue_date',
                        title: 'Issue Date',
                        // render: function(data, type, row) {
                        //     return `${formatDateTime(row.issue_date)}`;
                        // },
                        // orderable: false,
                        // searchable: true
                    },
                    {
                        data: 'issued_by_name',
                        name: 'issued_by_name',
                        title: 'Issued By'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name',
                        title: 'Department',

                    },

                    {
                        data: 'edit_by_name',
                        name: 'edit_by_name',
                        title: 'Edit By'
                    },

                    {
                        data: 'is_issued',
                        name: 'is_issued',
                        title: 'Status',
                        render: function(data, type, row) {
                            if (data == '0') {
                                return '<span class="badge badge-primary">Not Completed</span>';
                            } else {
                                return '<span class="badge badge-primary">Completed</span>';
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Action'
                    },
                    //  {
                    //     data: 'issue',
                    //     name: 'issue',
                    //     title: 'Issue Medicine',
                    // },
                ],

            });
        });
    </script>
@endpush
