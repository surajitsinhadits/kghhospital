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
                            <div class="col-lg-4 col-xl-4 border-right">
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
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Item Sub Unit :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$item_details->sub_unit }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                {{-- ================== patient information ====================== --}}
                            </div>
                            <div class="col-lg-4 col-xl-4 border-right">
                                <div class="options px-5 pt-2 pb-1">
                                    <table class="table table_border_none">
                                        <tbody>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Unit-SubUnit :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    1 {{ @$item_details->unit }} = {{ @$item_details->sub_unit_no }} {{ @$item_details->sub_unit }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Stored :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$item_details->store_name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Company Name :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$item_details->company_name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Loworder Level :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$item_details->low_level }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 px-2">
                                <h5 class="text-green">AVAILABLE STOCK</h5>
                                <div class="options pt-1 pb-1">
                                    <table
                                        class="table table-bordered text-nowrap key-buttons border-left border-right border-bottom">
                                        <thead class="bg-success text-white">
                                            <tr class="border-left">
                                                <th class="text-white">Batch No </th>
                                                <th class="text-white">Rate/Unit </th>
                                                <th class="text-white">Exp Date </th>
                                                <th class="text-white">QTY </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $total_avi_unit = $total_avi_sub = 0; @endphp
                                            @foreach (@$pasent_stock ?? [] as $value)
                                                @php
                                                    $total_avi_unit = $total_avi_unit + @$value['unit_qty'];
                                                    $total_avi_sub = $total_avi_sub + @$value['sub_unit_qty'];
                                                @endphp
                                                @if ((@$value['unit_qty'] > 0) || (@$value['sub_unit_qty'] > 0))
                                                <tr>
                                                    <td>{{ @$value['part_no'] }}</td>
                                                    <td>{{ @$value['rate'] }}</td>
                                                    <td>{{ @$value['exp_date'] ? dateFor($value['exp_date']) : 'N/A' }}</td>
                                                    <td>{{ @$value['unit_qty'] }} {{ @$value['unit'] }} {{ @$value['sub_unit_qty'] }} {{ @$value['sub_unit'] }}</td>
                                                </tr>
                                                @endif
                                            @endforeach
                                            <tr class="border-left">
                                                <th colspan="3" class="text-center">Available </th>
                                                <th>{{ @$total_avi_unit }} {{ @$pasent_stock[0]['unit'] }} {{ @$total_avi_sub }} {{ @$pasent_stock[0]['sub_unit'] }}</th>
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
                                    <th class="text-white">Date</th>
                                    <th class="text-white">Batch No</th>
                                    <th class="text-white">Exp. Date</th>
                                    <th class="text-white">Vendor</th>
                                    <th class="text-white">Purchase By?</th>
                                    <th class="text-white">Buy QTY</th>
                                    <th class="text-white">Return QTY</th>
                                    <th class="text-white">Rate/Unit</th>
                                    <th class="text-white">MRP/Unit</th>
                                    <th class="text-white">CGST</th>
                                    {{-- <th class="text-white">CGST Value</th> --}}
                                    <th class="text-white">SGST</th>
                                    {{-- <th class="text-white">SGST Value</th> --}}
                                    <th class="text-white">IGST</th>
                                    {{-- <th class="text-white">IGST Value</th> --}}
                                    <th class="text-white">Sub Total</th>
                                    <th class="text-white">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = $total_unit = $total_sub = $total_return = 0; @endphp
                                @foreach (@$stocks ?? [] as $item)
                                    @php
                                        $total = $total + @$item->total;
                                        $total_unit = $total_unit + @$item->unit_qty;
                                        $total_sub = $total_sub + @$item->sub_unit_qty;
                                        $total_return = $total_return + @$item->return_qty;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{dateFor($item->date, true)}}</td>
                                        <td>{{ $item->part_no ? $item->part_no : 'N/A' }}</td>
                                        <td>{{ $item->exp_date ? dateFor($item->exp_date) : 'N/A' }}</td>
                                        <td>{{ @$item->vendor_name }}</td>
                                        <td>{{ @$item->created_by }}</td>
                                        <td>{{ @$item->unit_qty ?? 0 }} {{ @$item->unit }} {{ @$item->sub_unit_qty ?? 0 }} {{ @$item->sub_unit }}</td>
                                        <td class="text-danger">{{ @$item->return_qty }} {{ @$item->sub_unit }}</td>
                                        <td>{{ @$item->unit_rate }}</td>
                                        <td>{{ @$item->unit_mrp }}</td>
                                        {{-- <td>{{ @$item->cgst }}</td> --}}
                                        <td>{{ @$item->cgst_value }} ({{ @$item->cgst }})</td>
                                        {{-- <td>{{ @$item->sgst }}</td> --}}
                                        <td>{{ @$item->sgst_value }} ({{ @$item->sgst }})</td>
                                        {{-- <td>{{ @$item->igst }}</td> --}}
                                        <td>{{ @$item->igst_value }} ({{ @$item->igst }})</td>
                                        <td>{{ @$item->sub_total }}</td>
                                        <td>{{ @$item->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-center">Total QTY</td>
                                    <td>{{ $total_unit }} {{ @$stocks[0]->unit }} {{ $total_sub }} {{ @$stocks[0]->sub_unit }}</td>
                                    <td class="text-danger">{{ $total_return }} {{ @$item->sub_unit }}</td>
                                    <td colspan="6" class="text-center">Price</td>
                                    <td>{{ $total }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <hr>
                    <h4 class="text-green">ITEM ISSUE DETAILS</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap key-buttons">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="text-white">#</th>
                                    <th class="text-white">Issue No</th>
                                    <th class="text-white">Req No</th>
                                    <th class="text-white">Issue By?</th>
                                    <th class="text-white">Where ?</th>
                                    <th class="text-white">Date</th>
                                    <th class="text-white">Batch No</th>
                                    <th class="text-white">QTY</th>
                                    <th class="text-white">Rate/Unit</th>
                                    <th class="text-white">CGST</th>
                                    <th class="text-white">SGST</th>
                                    <th class="text-white">IGST</th>
                                    <th class="text-white">Sub Total</th>
                                    <th class="text-white">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $itotal = $itotal_unit = $itotal_sub = 0; @endphp
                                @foreach (@$issues ?? [] as $item)
                                    @php
                                        $itotal = $itotal + @$item->total;
                                        $itotal_unit = $itotal_unit + @$item->unit_qty;
                                        $itotal_sub = $itotal_sub + @$item->sub_unit_qty;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ @$item->id }}</td>
                                        <td>{{ @$item->requisition_id }}</td>
                                        <td>{{ @$item->created_by }}</td>
                                        <td>{{ @$item->department_name }}</td>
                                        <td>{{ dateFor($item->date, true) }}</td>
                                        <td>{{ @$item->part_no ? $item->part_no : 'N/A' }}</td>
                                        <td>{{ @$item->unit_qty }} {{ @$item->unit }} {{ @$item->sub_unit_qty }} {{ @$item->sub_unit }}</td>
                                        <td>{{ @$item->unit_rate }}</td>
                                        <td>{{ @$item->cgst_value }}</td>
                                        <td>{{ @$item->sgst_value }}</td>
                                        <td>{{ @$item->igst_value }}</td>
                                        <td>{{ @$item->sub_total }}</td>
                                        <td>{{ @$item->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="text-center">Total QTY</td>
                                    <td>{{ $itotal_unit }} {{ @$issues[0]->unit }} {{ $itotal_sub }} {{ @$issues[0]->sub_unit }}</td>
                                    <td colspan="5" class="text-center">Price</td>
                                    <td>{{ $itotal }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <hr>
                    <div class="row">
                        <dic class="col-md-7">
                            <h4 class="text-warning">ITEM RETURN DETAILS</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap key-buttons">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="text-white">#</th>
                                            <th class="text-white">Approved By?</th>
                                            <th class="text-white">Where ?</th>
                                            <th class="text-white">Date</th>
                                            <th class="text-white">Batch No</th>
                                            <th class="text-white">QTY</th>
                                            <th class="text-white">Total <small>(+GST)</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $rtotal = $rtotal_unit = $rtotal_sub = 0; @endphp
                                        @foreach (@$damage->where('type', 'return') ?? [] as $item)
                                            @php
                                                $rtotal = $rtotal + @$item->total;
                                                $rtotal_unit = $rtotal_unit + @$item->unit_qty;
                                                $rtotal_sub = $rtotal_sub + @$item->sub_unit_qty;
                                            @endphp
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ @$item->created_by }}</td>
                                                <td>{{ @$item->department_name ?? 'Vendor' }}</td>
                                                <td>{{ dateFor($item->return_date, true) }}</td>
                                                <td>{{ @$item->part_no ? $item->part_no : 'N/A' }}</td>
                                                <td>{{ @$item->unit_qty }} {{ @$item->unit }} {{ @$item->sub_unit_qty }} {{ @$item->sub_unit }}</td>
                                                <td>{{ @$item->total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-center">Total QTY & Price</td>
                                            <td>{{ $rtotal_unit }} {{ @$issues[0]->unit }} {{ $rtotal_sub }} {{ @$issues[0]->sub_unit }}</td>
                                            <td>{{ $rtotal }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </dic>
                        <dic class="col-md-5">
                            <h4 class="text-danger">ITEM DAMAGE DETAILS</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap key-buttons">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="text-white">#</th>
                                            <th class="text-white">Approved By?</th>
                                            <th class="text-white">Where ?</th>
                                            <th class="text-white">Date</th>
                                            <th class="text-white">Batch No</th>
                                            <th class="text-white">QTY</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $dtotal = $dtotal_unit = $dtotal_sub = 0; @endphp
                                        @foreach (@$damage->where('type', 'damage') ?? [] as $item)
                                            @php
                                                $dtotal = $dtotal + @$item->total;
                                                $dtotal_unit = $dtotal_unit + @$item->unit_qty;
                                                $dtotal_sub = $dtotal_sub + @$item->sub_unit_qty;
                                            @endphp
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ @$item->created_by }}</td>
                                                <td>{{ @$item->department_name }}</td>
                                                <td>{{ dateFor($item->return_date, true) }}</td>
                                                <td>{{ @$item->part_no ? $item->part_no : 'N/A' }}</td>
                                                <td>{{ @$item->unit_qty }} {{ @$item->unit }} {{ @$item->sub_unit_qty }} {{ @$item->sub_unit }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-center">Total QTY</td>
                                            <td>{{ $dtotal_unit }} {{ @$issues[0]->unit }} {{ $dtotal_sub }} {{ @$issues[0]->sub_unit }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </dic>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
