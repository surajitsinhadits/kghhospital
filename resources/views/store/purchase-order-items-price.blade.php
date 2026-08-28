@extends('layouts.structure')
@push('title')
    <title>Purchase Order Details</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="card">
        <div class="card-header d-block card_hearder_mimi">
            <div class="row">
                <div class="col-md-6 card-title card_hearder_mimi_text">
                    Purchase Order Details
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12" style="float: left;">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <span class="requisition_header"><i class="fas fa-yin-yang text-danger"></i> Purchase Order No : </span><span
                            class="requisition_text">PO#{{@$purchaseOrder->id}}
                        </span>
                    </div>
                    <div class="col-md-4">
                        <span class="requisition_header"><i class="fas fa-yin-yang text-danger"></i> Purchase Order Date : </span><span
                            class="requisition_text">
                            {{dateFor($purchaseOrder->po_date, true)}}
                        </span>
                    </div> 
                </div>

            </div>
            <div class="table-responsive mt-4">
                <table class="table table-striped card-table table-vcenter text-nowrap border">
                    <thead class="bg-primary text-white">
                        <tr class="border">
                            <th  class="text-white border">#</th>
                            <th  class="text-white border">Items Name</th>
                            <th  class="text-white border">Items Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( $purchase_order_items->count() > 0)
                            @foreach($purchase_order_items as $purchase_order_item)
                            <tr>
                                <th scope="row" class="border">{{ $loop->iteration }}</th>
                                <td class="border">{{ $purchase_order_item->item_name }} </td>
                                <td class="border">{{ number_format($purchase_order_item->unit_price, 2) }} </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center">No items found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
@endpush

