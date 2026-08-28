@extends('layouts.structure')
@push('title')
    <title>Dashboard</title>
@endpush
@push('css')
    <style>
        .pricing-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
        }

        .pricing-card {
            background: #ddeef1;
            border: 1px solid #333;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .pricing-card:hover {
            transform: translateY(-6px);
        }

        .pricing-card h3 {
            margin-top: 0;
            font-size: 1.4rem;
            margin-bottom: 10px;
        }

        .price {
            font-size: 1.8rem;
            color: #000;
            margin-bottom: 20px;
        }

        .pricing-card ul {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }

        .pricing-card ul li {
            margin: 8px 0;
            font-size: 0.95rem;
            color: #000;
        }

        button {
            background: #00ffd5;
            color: #111;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
        }

        .highlighted {
            border: 2px solid #00ffd5;
            background: #282828;
        }
    </style>
@endpush
@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="container mt-4">
                    <div class="pricing-container">
                        @foreach ($purchaseOrders as $key => $purchaseOrder)
                            <div class="pricing-card">
                                <p class="price">PO#{{ $purchaseOrder->id }}</p>
                                <ul>
                                    <li>Publish Date : {{ dateFor($purchaseOrder->po_date, true) }}</li>
                                    <li>No of Items : {{ $purchaseOrderItems[$key] }}</li>
                                    <li>My Pricing : {{ $purchaseOrder->total_price ? $purchaseOrder->total_price : 0 }}
                                    </li>
                                </ul>
                                @if ($purchaseOrder->vendor_price_id)
                                    <a href="{{ route('vendor-purchased-order-items-edit', ed($purchaseOrder->vendor_price_id, true)) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit Items Set price">Edit
                                        Price</a>
                                @else
                                    <a href="{{ route('vendor-purchased-order-items', ed($purchaseOrder->id, true)) }}"
                                        class="btn btn-sm btn-outline-primary" title="Items Set price">Set Price</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
