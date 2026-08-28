@extends('layouts.structure')
@push('title')
    <title>Item Details</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-header d-block card_hearder_mimi">
                <div class="row">
                    <div class="col-md-6 card-title card_hearder_mimi_text">
                        Item Details
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="card-body" style="border-bottom: none">
                    <div class="card-body p-0">
                        <div class="row no-gutters">
                            <div class="col-lg-8 col-xl-8 border-right">
                                <div class="options px-5 pt-2 pb-1">
                                    <table class="table table_border_none">
                                        <tbody>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Item Category Name :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$item_details->category_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Item Name :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$item_details->item_name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Item Unit :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$item_details->unit }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4">
                                <div class="options px-5 pt-2 pb-1">
                                    <table
                                        class="table table-bordered text-nowrap key-buttons border-left border-right border-bottom">
                                        <thead class="bg-success text-white text-center">
                                            <tr class="border-left">
                                                <th class="text-white">Pasent Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr>
                                                <td style="font-size: 20px">{{$pasent_stock}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-green">ITEM STOCK DETAILS</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap key-buttons">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="text-white">#</th>
                                    <th class="text-white">Purchase ID</th>
                                    <th class="text-white">Date</th>
                                    <th class="text-white">Invoice No</th>
                                    <th class="text-white">Unit QTY</th>
                                    <th class="text-white">Rate/Unit</th>
                                    <th class="text-white">MRP/Unit</th>
                                    <th class="text-white">Net Amount</th>
                                    <th class="text-white">GST</th>
                                    <th class="text-white">Discount</th>
                                    <th class="text-white">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$stocks ?? [] as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>KTP#{{ $item->id }}</td>
                                        <td>{{dateFor($item->date, true)}}</td>
                                        <td>{{ $item->invoice_no }}</td>
                                        <td>{{ @$item->unit_qty ?? 0 }} {{ @$item->unit }}</td>
                                        <td>{{ @$item->rate }}</td>
                                        <td>{{ @$item->mrp }}</td>
                                        <td>{{ @$item->net_amount }}</td>
                                        <td>{{ @$item->gst_amount }}</td>
                                        <td>{{ @$item->discount_amount }}</td>
                                        <td>{{ @$item->amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <h4 class="text-green">ITEM EXPENSES DETAILS</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap key-buttons">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="text-white">#</th>
                                    <th class="text-white">Expenses ID</th>
                                    <th class="text-white">Date</th>
                                    <th class="text-white">Approximate Meal</th>
                                    <th class="text-white">Generated By</th>
                                    <th class="text-white">QTY</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$issues ?? [] as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>KTE#{{ @$item->id }}</td>
                                        <td>{{ dateFor($item->date, true) }}</td>
                                        <td>{{ @$item->total_meal }}</td>
                                        <td>{{ @$item->created_by }}</td>
                                        <td>{{ @$item->unit_qty }} {{ @$item->unit }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
