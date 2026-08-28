@extends('layouts.structure')
@push('title')
    <title>Present Kitchen Stock</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">PRESENT KITCHEN STOCK</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th>Sl. No.</th>
                                <th>Item Name</th>
                                <th>QTY</th>
                                {{-- <th>Amount</th> --}}
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($pasent_stock as $stock)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('kt.item-info', ed($stock['id'], true)) }}">{{ $stock['item'] }}</a></td>
                                <td>{{ $stock['qty'] }}</td>
                                {{-- <td>₹{{ $stock['amount'] }}</td> --}}
                                <td>
                                    @if($stock['check_qty'] <= 0)
                                    <span class="badge badge-gradient-secondary mt-2"> Out Of stock</span>
                                    @elseif ($stock['check_qty'] <= 20 && $stock['check_qty'] > 0)
                                    <span class="badge badge-gradient-primary mt-2"> Low Stock</span>
                                    @else
                                    <span class="badge badge-gradient-success mt-2"> Available</span>
                                    @endif
                                </td>
                                @php
                                    $total = $total + $stock['amount'];
                                @endphp
                            </tr>
                            @endforeach
                        </tbody>
                        <tfood>
                            {{-- <tr class="text-center" style="font-size: 18px">
                                <td colspan="5">Total Amount : ₹{{$total}}</td>
                            </tr> --}}
                        </tfood>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')

@endpush
