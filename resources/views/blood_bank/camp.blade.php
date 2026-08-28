@extends('layouts.structure')

@push('title')
    <title>CAMP</title>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">CAMP LIST</h4>
                    <div>
                        <a class="btn btn-sm btn-warning" href="{{ route('bl.camp-register') }}">NEW CAMP REGISTER</a>
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
                url: "{{ route('bl.donation-camps') }}"
            },
            columns: [
                {
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
                    data: 'camp_name',
                    name: 'camp_name',
                    title: 'Camp Name'
                },
                {
                    data: 'organized_by',
                    name: 'organized_by',
                    title: 'Organized By'
                },
                {
                    data: 'organized_date',
                    name: 'organized_date',
                    title: 'Organized Date'
                },
                {
                    data: 'location',
                    name: 'location',
                    title: 'Location'
                },
                {
                    data: 'contact_person',
                    name: 'contact_person',
                    title: 'Contact Person'
                },
                {
                    data: 'contact_phone',
                    name: 'contact_phone',
                    title: 'Contact Person No'
                },
                {
                    data: 'status',
                    name: 'status',
                    title: 'Status',
                    render: function(data) {
                        return data;
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
