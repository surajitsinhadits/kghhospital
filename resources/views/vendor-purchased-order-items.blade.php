@extends('layouts.structure')
@push('title')
    <title>Dashboard</title>
@endpush
@push('css')
@endpush
@section('main-content')
<form action="{{ route('vendor-purchased-order-items-save', @$edit->id) }}" method="POST">
    @csrf
    <input type="hidden" name="po_id" value="{{ $purchaseOrder->id }}">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="container mt-4">
                    <h4 class="mb-3">PO#{{ $purchaseOrder->id }} (Published : {{ dateFor($purchaseOrder->po_date, true) }})</h4>
                    <table class="table table-bordered table-striped">
                        <thead class="bg-success text-white">
                            <tr>
                                <th>#</th>
                                <th>Item Name</th>
                                <th>QTY</th>
                                <th>Set Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($purchase_order_items->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">No items found</td>
                                </tr>
                            @else
                                @foreach ($purchase_order_items as $key => $purchase_order_item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $purchase_order_item->item_name }}</td>
                                        <td>{{ $purchase_order_item->unit_qty }} {{ $purchase_order_item->unit_name }} {{ $purchase_order_item->sub_unit_qty }} {{ $purchase_order_item->sub_unit_name }}</td>
                                        <td>
                                            <input value="{{ @$edit ? $edit_items->where('item_id', $purchase_order_item->item_id)->first()->unit_price : '' }}" type="text" name="item_price[{{ $purchase_order_item->id }}]" class="form-control unit-price" placeholder="Set Price" required>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3" class="text-center">Total Price</th>
                                    <td>
                                        <span id="total-price">{{ @$edit->total_price }}</span>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <input type="hidden" id="totalPrice" name="total_price" value="{{ @$edit->total_price }}">
                <div class="text-center mb-4">
                    <button type="submit" class="btn btn-primary"> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        // Calculate total price on input change
        $('.unit-price').on('input', function() {
            calculateTotalPrice();
        });
    });

    function calculateTotalPrice() {
        let total = 0;
        $('.unit-price').each(function() {
            const price = parseFloat($(this).val()) || 0;
            total += price;
        });
        $('#total-price').text(total);
        $('#totalPrice').val(total);
    }
</script>
@endpush
