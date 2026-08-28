@extends('layouts.structure')
@push('title')
    <title>IVF Couple Registration</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">IVF Couple Registration</h4>
                    <div>
                        <a class="btn btn-sm btn-warning" href="{{ Route('ivf.couple-registration') }}">REGISTER NEW COUPLE</a>
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
                    url: "{{route('ivf.ivf-couple-list')}}",
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
                        data: 'female_name',
                        name: 'female_name',
                        title: 'Female Name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'male_name',
                        name: 'male_name',
                        title: 'Male Name',
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
