@extends('layouts.structure')
@push('title')
    <title>Child Details</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">
                    Baby Listing
                </h4>
                <div>
                    <a href="{{ route('hr.child-register')}}" style="color:white;font-weight: 600;" class="btn btn-default btn-sm"><i  class="fa fa-edit"></i> New Registration</a>
                </div>
            </div>
            <div class="card-body p-0" style="margin-bottom: 32px;">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap data-table">
                            <thead></thead>
                            <tbody></tbody>
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
            ajax: "{{ route('hr.child-list') }}",
            columns: [
                {
                    data: null,
                    name: 'sl_no',
                    title: 'SN',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: null,
                    data: 'id',
                    name: 'id',
                    title: 'Baby Id',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'name',
                    name: 'name',
                    title: 'Baby Of',
                },
                {
                    data: 'guardian_name',
                    name: 'guardian_name',
                    title: 'Guardian Name',
                },
                {
                    data: 'date_of_birth',
                    name: 'date_of_birth',
                    title: 'DOB of Baby',
                },
                {
                    data: 'admission_date',
                    name: 'admission_date',
                    title: 'Admission Date',
                },
                {
                    data: 'action',
                    name: 'action',
                    title: 'Action'
                },
            ],
        });
    });
</script>
@endpush
