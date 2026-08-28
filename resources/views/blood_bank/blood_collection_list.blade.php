@extends('layouts.structure')
@push('title')
    <title>Blood Collection</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">BLOOD COLLECTION LIST</h4>
                    <div>
                        <a class="btn btn-sm btn-warning" href="{{ Route('bl.blood-collection') }}">COLLECTION NEW BLOOD</a>
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
                    url: "{{route('bl.get-blood-collection')}}",
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
                        data: 'donation_date',
                        name: 'donation_date',
                        title: 'Donation Date',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return formatDateTime(row.donation_date, 'date');
                        }
                    },
                    {
                        data: 'bag_barcode',
                        name: 'bag_barcode',
                        title: 'Bag Barcode'
                    },
                   {
                        data: 'name',
                        name: 'd.name',
                        title: 'Donor Name'
                    },
                    {
                        data: 'contact_number',
                        name: 'd.contact_number',
                        title: 'Donor Mobile No.'
                    },
                    {
                        data: 'blood_group',
                        name: 'blood_group',
                        title: 'Blood Group'
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
