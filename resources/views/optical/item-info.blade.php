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
                                <div class="options text-center mt-5">
                                    <h3 class="text-secondary">{{ $itemDetails['unit_qty'].' '.$itemDetails['unit'].' '.$itemDetails['sub_unit_qty'].' '.$itemDetails['sub_unit'] }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
