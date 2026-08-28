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
                            Medicine List with Stock
                        </div>

                        <div class="col-md-6 text-right">
                            <div class="d-block">

                                <a href="{{ route('pharmacy.add-medicine') }}" class="btn btn-primary btn-sm"><i
                                        class="fa fa-tablets"></i> Add new Medicine</a>

                            </div>
                        </div>
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

    {{-- <script>
        function getmedicine_name(Medicine_name) {
            var div_data = '';
            $('#search_result').attr('style', 'display:none', true);
            $('#search_result_row').html('');
            if (Medicine_name != '') {
                $.ajax({
                    url: "{{ route('medicine-list-search') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        MedicineName: Medicine_name,
                    },

                    success: function(response) {
                        console.log(response);
                        if ((response != '')) {
                            $('#search_result').removeAttr('style', true);
                            $.each(response, function(key, value) {
                                console.log(response);
                                div_data += `<tr class="color_hover_change" style="cursor: pointer;">
                <td><a href="{{ url('medicine-details') }}/${value.id}">${value.medicine_name}</a></td>
            </tr>`;

                            });
                            console.log(div_data);
                            $('#search_result_row').html(div_data);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }
    </script> --}}
@endsection

@push('js')
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('pharmacy.medicine-lists') }}",
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
                        data: 'medicine_name',
                        name: 'medicine_name',
                        title: 'Medicine Name'
                    },
                    {
                        data: 'catagory_name',
                        name: 'med_medicines.medicine_catagory',
                        title: 'Medicine Category'
                    },
                    {
                        data: 'medicine_composition',
                        name: 'med_medicines.medicine_composition',
                        title: 'Medicine Composition'
                    },

                    {
                        data: 'unit_name',
                        name: 'med_medicines.unit',
                        title: 'Unit'
                    },
                    {
                        data: 'sub_unit_name',
                        name: 'med_medicines.sub_unit',
                        title: 'Sub Unit'
                    },
                    // {
                    //     data: 'stock',
                    //     name: 'stock',
                    //     title: 'Stock',
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        data: 'stock_status',
                        name: 'stock_status',
                        title: 'Status',
                        orderable: false,
                        searchable: false
                    },
                    // {
                    //     data: 'converted_stock',
                    //     name: 'converted_stock',
                    //     title: 'Stock'
                    // },
                    // {
                    //     data: 'tax',
                    //     name: 'tax',
                    //     title: 'GST(%)'
                    // },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Action'
                    },
                ],
                rowCallback: function(row, data) {
                    const qty = parseInt(data.total_qty || 0);
                    const minLevel = parseInt(data.min_level || 0);
                    const unitSize = parseInt(data.unit_details || 1);

                    if (qty < minLevel * unitSize) {
                        $(row).css('background-color', '#FFB3B5');
                    } else {
                        $(row).css('background-color', '#d3fdf7');
                    }
                }
            });
        });
    </script>
@endpush
