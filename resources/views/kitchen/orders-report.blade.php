@extends('layouts.structure')
@push('title')
    <title>Orders Report</title>
@endpush
@push('css')
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto);

        body {
            font-family: Roboto, sans-serif;
        }

        #chart1 {
            max-width: 100%;
            margin: 5px auto;
        }

        #chart2 {
            max-width: 100%;
            margin: 5px auto;
        }
    </style>
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">ORDERS REPORT</h4>
                </div>
                <div class="">
                    <div class="">
                        <form method="POST" id="filterForm">
                            @csrf
                            <div class="whitebackground">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select class="form-control mt-1" name="order_type" id="order_type">
                                            <option value="">Select Order Mode</option>
                                            <option value="canteen">Canteen</option>
                                            <option value="online">Online</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select class="form-control select2-show-search" name="payment_status" id="payment_status">
                                            <option value="">Select Payment Status</option>
                                            <option value="completed">Completed</option>
                                            <option value="due">Due</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select class="form-control select2-show-search" name="order_status" id="order_status">
                                            <option value="">Select Order Status</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Processing</option>
                                            <option value="2">Delivered</option>
                                            <option value="3">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" value="" class="form-control datePickr" id="fromDate"
                                            name="from_date" placeholder="Choose From Date">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" value="" class="form-control datePickr" id="toDate"
                                            name="to_date" placeholder="Choose To Date">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group d-flex">
                                        <button type="submit" class="btn btn-primary px-2 mr-1"><i
                                            class="fas fa-filter"></i> Filter</button>
                                        <button type="button" class="btn btn-success px-2 mr-1"
                                            id="todayBtn"><i
                                            class="fas fa-calendar-week"></i> Today</button>
                                        <button type="button" class="btn btn-warning px-2" id="resetBtn"><i
                                            class="fas fa-history"></i> Reset</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                    <div class="whitebackground">
                        <div class="table-responsive" id="table-responsive">
                            <table class="table table-bordered data-table">
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
        var table;
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            table.draw();
        });
        $('#todayBtn').on('click', function() {
            const today = moment().format('DD-MM-YYYY');
            $('#fromDate').val(today);
            $('#toDate').val(today);
            table.draw();
        });
        $('#resetBtn').on('click', function() {
            // Clear all filters
            $('#order_type').val('').trigger('change');
            $('#payment_status').val('').trigger('change');
            $('#order_status').val('').trigger('change');
            $('#fromDate').val('');
            $('#toDate').val('');

            // Redraw the DataTable (will trigger serverSide AJAX reload)
            table.draw();
        });
        $(function() {
            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                lengthMenu: [
                    [50, 100, 200, 300, 400],
                    [50, 100, 200, 300, 400]
                ],
                ajax: {
                    url: "{{ route('kt.orders-report') }}",
                    data: function(d) {
                        d.order_type = $('#order_type').val();
                        d.payment_status = $('#payment_status').val();
                        d.order_status = $('#order_status').val();
                        d.from_date = $('#fromDate').val();
                        d.to_date = $('#toDate').val();
                    }
                },
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
                        data: 'order_date',
                        name: 'order_date',
                        title: 'Date',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        title: 'Name',
                        render: function(data, type, row, meta) {
                            return `${row.name} <br> <small>Mobile : ${row.phone ? '' : 'NA'}</small>`;
                        },
                    },
                    {
                        data: 'meals',
                        name: 'meals',
                        title: 'Meals',
                        render: function(data, type, row, meta) {
                            let meals = JSON.parse(data);
                            if (Array.isArray(meals) && meals.length > 0) {
                                return meals.map(meal => `<span class="badge badge-gradient-primary mr-1">${meal}</span>`).join('');
                            }else{
                                return 'hi';
                            }
                        },
                    },
                    {
                        data: 'sub_total',
                        name: 'sub_total',
                        title: 'Sub Total',
                    },
                    {
                        data: 'gst',
                        name: 'gst',
                        title: 'GST',
                    },
                    {
                        data: 'discount',
                        name: 'discount',
                        title: 'Discount',
                    },
                    {
                        data: 'total',
                        name: 'total',
                        title: 'Total',
                    },
                    {
                        data: 'total_due',
                        name: 'total_due',
                        title: 'Due',
                    },
                    {
                        data: 'order_mode',
                        name: 'order_mode',
                        title: 'Order Type',
                        render: function(data, type, row, meta) {
                            return data ? data.toUpperCase() : '';
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        title: 'Status',
                        render: function(data, type, row, meta) {
                            return row.status == 0 ? 'Pending' : ( row.status == 1 ? 'Processing' : ( row.status == 2 ? 'Delivered' : 'Cancelled'));
                        }
                    }
                ],
                rowCallback: function(row, data) {
                    $(row).css('background-color', '#d3fdf7');
                }
            });
        });
    </script>
@endpush
