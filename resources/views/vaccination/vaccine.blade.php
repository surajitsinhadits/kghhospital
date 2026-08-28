@extends('layouts.structure')
@push('title')
    <title>Add New Vaccine</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">VACCINE LIST</h4>
                    <div>
                        <a class="btn btn-sm btn-warning" href="{{route('vc.vaccine-register')}}">ADD NEW VACCINE</a>
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
                    url: "{{route('vc.vaccine')}}",
                    // data: function(d) {
                    //     const today = new Date().toISOString().split('T')[0];

                    //     d.field_name = $('#fieldName').val();
                    //     d.field_value = $('#fieldValue').val();
                    //     d.select_value = $('#selectValue').val();

                    //     if ($('#fieldName').val()) {
                    //         d.from_date = $('#fromDate').val();
                    //         d.to_date = $('#toDate').val();
                    //     } else {
                    //         d.from_date = $('#fromDate').val() || today;
                    //         d.to_date = $('#toDate').val() || today;
                    //     }

                    // }
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
                        data: 'vaccine_name',
                        name: 'vaccine_name',
                        title: 'Vaccine Name'
                    },
                    {
                        data: 'brand_name',
                        name: 'brand_name',
                        title: 'Brand'
                    },
                    {
                        data: 'manufacturer',
                        name: 'manufacturer',
                        title: 'Manufacturer'
                    },
                    {
                        data: 'age_group',
                        name: 'age_group',
                        title: 'Age/Group'
                    },
                    {
                        data: 'injection_site',
                        name: 'injection_site',
                        title: 'Injection Site'
                    },
                    {
                        data: 'storage_temp',
                        name: 'storage_temp',
                        title: 'Storage Temperature'
                    },
                    {
                        data: 'no_of_doses',
                        name: 'no_of_doses',
                        title: 'No of Doses'
                    },
                    // {
                    //     data: 'interval_days',
                    //     name: 'interval_days',
                    //     title: 'Interval Days'
                    // },
                    {
                        data: 'relation',
                        name: 'relation',
                        title: 'Units'
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
