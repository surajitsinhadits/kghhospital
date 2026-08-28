@extends('layouts.structure')
@push('title')
    <title>Approval and Stock</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">APPROVAL & STOCK LIST</h4>
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
                    url: "{{ route('bl.get-approval-stock') }}",
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
                        name: 'bl_donations.bag_barcode',
                        title: 'Bag Barcode',
                    },
                    {
                        data: 'blood_group',
                        name: 'bl_donations.blood_group',
                        title: 'Blood Group',
                    },
                    {
                        data: 'donation_date',
                        name: 'bl_donations.donation_date',
                        title: 'Collected',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return formatDateTime(row.donation_date,'date');
                        }
                    },
                    {
                        data: 'test_user',
                        name: 'u1.name',
                        title: 'Tested By',
						render: function(data, type, row) {
                            return row.test_user + ' (' + formatDateTime(row.test_at) + ')';
                        }
                    },
					{
                        data: 'approved_user',
                        name: 'u2.name',
                        title: 'Approved By',
                    },
                    {
                        data: 'approved_at',
                        name: 'bl_donations.approved_at',
                        title: 'Approved',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return row.approved_at ? formatDateTime(row.approved_at) : '';
                        }
                    },
                    {
                        data: 'expiry_date',
                        name: 'bl_donations.expiry_date',
                        title: 'Expiry Date',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return formatDateTime(row.expiry_date, 'date');
                        }
                    },
                    {
                        data: 'status',
                        name: 'bl_donations.status',
                        title: 'Status',
                        render: function(data, type, row, meta) {
                            let badgeClass = '';
                            let label = '';
                            switch (data) {
                                case 'tested':
                                    badgeClass = 'badge bg-warning text-dark';
                                    label = 'Tested';
                                    break;
                                case 'approved':
                                    badgeClass = 'badge bg-success';
                                    label = 'Approved';
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
