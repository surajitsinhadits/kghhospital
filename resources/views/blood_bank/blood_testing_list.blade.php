@extends('layouts.structure')
@push('title')
    <title>Blood Testing</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">BLOOD TESTING LIST</h4>
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
                    url: "{{route('bl.get-blood-testing')}}"
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
                        data: 'bag_barcode',
                        name: 'bag_barcode',
                        title: 'Bag Barcode',
                    },
                    {
                        data: 'name',
                        name: 'd.name',
                        title: 'Donor Name',
                    },
                    {
                        data: 'blood_group',
                        name: 'blood_group',
                        title: 'Blood Group',
                    },
                    {
                        data: 'donationDate',
                        name: 'donationDate',
                        title: 'Donation Date',
                    },
                    {
                        data: 'expDate',
                        name: 'expDate',
                        title: 'Expiry Date',
                    },
                    {
                        data: 'status',
                        name: 'status',
                        title: 'Status',
                        render: function(data, type, row, meta) {
                            let badgeClass = '';
                            let label = '';
                            switch (data) {
                                case 'collected':
                                    badgeClass = 'badge bg-warning text-dark';
                                    label = 'Collected';
                                    break;
                                case 'tested':
                                    badgeClass = 'badge bg-success';
                                    label = 'Tested';
                                    break;
                            }

                            return `<span class="${badgeClass}">${label}</span>`;
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
            });
        });
    </script>
@endpush
