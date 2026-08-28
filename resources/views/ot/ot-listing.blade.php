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
                            OT List
                        </div>

                        {{-- <div class="col-md-6 text-right">
                            <div class="d-block">

                                <a href="{{ route('pharmacy.create-purchase') }}" class="btn btn-primary btn-sm"><i
                                        class="fa fa-tablets"></i>Create Purchase</a>

                            </div>
                        </div> --}}
                    </div>
                </div>


                {{-- <div class="card-bodyp hospital_allcardbodydesign border" style="display:none" id="search_result">
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
                </div> --}}

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
                ajax: "{{ route('ot.all-ot-listing') }}",
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
                        data: 'id',
                        name: 'id',
                        title: 'OT No',
                    },
                    {
                        data: 'patient',
                        name: 'patients.name',
                        title: 'Patient Details',

                    },
                    {
                        data: 'details',
                        name: 'departments.department_name',
                        title: 'Details',

                    },
                    {
                        data: 'doctor_name',
                        name: 'users.name',
                        title: 'Consultation Doctor',

                    },
                    {
                        data: 'operation_name',
                        name: 'operation_name',
                        title: 'Operation Name',

                    },

                     {
                        data: 'status',
                        name: 'status',
                        title: 'OT Status',

                    },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Action',

                    }
                ],
                rowCallback: function(row, data) {
                    if (data.is_admitted == 'no') {
                        $(row).css('background-color', '#FFFF9B');
                    } else {
                        $(row).css('background-color', '#d3fdf7');
                    }
                }
            });
        });
    </script>
@endpush
