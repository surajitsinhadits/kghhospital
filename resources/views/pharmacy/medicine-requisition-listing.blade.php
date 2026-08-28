@extends('layouts.structure')

@push('title')
    <title>{{ $title }} - {{ hospital('title') }}</title>
@endpush

@push('css')
    <style>
        .requisition-header-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 5px;
            flex-wrap: wrap;
        }

        .requisition-header-tabs {
            display: inline-flex;
            align-items: center;
            gap: 5px !important;
            column-gap: 5px !important;
            row-gap: 0 !important;
            flex-wrap: wrap;
            font-size: 0;
        }

        .requisition-header-tabs .nav-item {
            display: inline-flex;
            margin: 0 !important;
            padding: 0 !important;
        }

        .requisition-header-tabs .nav-link,
        .requisition-add-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            min-height: 32px;
            padding: 6px 12px;
            border: 2px solid transparent;
            border-radius: 4px;
            color: #000;
            font-size: 14px;
            font-weight: 700;
            line-height: 1.2;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .35);
            text-transform: none;
            white-space: nowrap;
            margin: 0 !important;
        }

        .requisition-header-tabs .nav-item+.nav-item {
            margin-left: 0 !important;
        }

        .requisition-header-tabs .nav-item:not(:first-child) .nav-link {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .requisition-header-tabs .nav-item:not(:last-child) .nav-link {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .requisition-header-tabs .nav-link:hover,
        .requisition-header-tabs .nav-link:focus,
        .requisition-add-btn:hover,
        .requisition-add-btn:focus {
            color: #000;
            background: #f8fafc;
            text-decoration: none;
        }

        .requisition-add-btn {
            border-color: #f0a500;
            text-transform: uppercase;
        }

        .requisition-tab-created {
            border-color: #a855f7 !important;
        }

        .requisition-tab-verified {
            border-color: #2563eb !important;
        }

        .requisition-tab-approved {
            border-color: #16a34a !important;
        }

        .requisition-tab-others {
            border-color: #334155 !important;
        }

        .requisition-header-tabs .nav-link.active {
            background: #eef6ff;
        }

        @media (max-width: 767.98px) {
            .requisition-header-actions {
                justify-content: flex-start;
                margin: 10px 0;
            }
        }
    </style>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header d-block card_hearder_mimi">
                    <div class="row align-items-center">
                        <div class="col-md-4 card-title card_hearder_mimi_text mb-0">
                            {{ $title }}
                        </div>
                        @if ($title == 'Medicine Requisition List')
                            <div class="col-md-8">
                                <div class="requisition-header-actions">
                                    <a href="{{ route('pharmacy.add-requisition') }}" class="requisition-add-btn">ADD
                                        REQUISITION</a>
                                    <ul class="nav requisition-header-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link requisition-tab-created active" href="javascript:void(0);"
                                                role="tab" data-requisition-tab="created"><i class="fa fa-file-pdf"></i>
                                                Created</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link requisition-tab-verified" href="javascript:void(0);"
                                                role="tab" data-requisition-tab="verified"><i
                                                    class="fa fa-file-pdf"></i> Verified</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link requisition-tab-approved" href="javascript:void(0);"
                                                role="tab" data-requisition-tab="approved"><i
                                                    class="fa fa-file-pdf"></i> Approved</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif
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
                ajax: "{{ $action }}",
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
                        data: 'requisition_no',
                        name: 'requisition_no',
                        title: 'Requisition No',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'date',
                        name: 'date',
                        title: 'Requisition Date',
                        render: function(data, type, row) {
                            return `${formatDateTime(row.date)}`;
                        },
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'requested_by_name',
                        name: 'requested_by_name',
                        title: 'Generated By'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name',
                        title: 'Department',

                    },

                    {
                        data: 'is_given',
                        name: 'is_given',
                        title: 'Status',
                        render: function(data, type, row) {
                            if (data == '0') {
                                return '<span class="badge badge-danger">Not Issued</span>';
                            } else {
                                return '<span class="badge badge-primary">Issued</span>';
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

            $('.requisition-header-tabs .nav-link').on('click', function() {
                $('.requisition-header-tabs .nav-link').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
@endpush
