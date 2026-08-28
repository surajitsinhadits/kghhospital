@extends('layouts.structure')

@push('title')
    <title>General Stock Report</title>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">GENERAL STOCK REPORT</h4>
                </div>

                <div class="card-body">

                    @php
                        $exportParams = request()->except(['page', 'format']);
                        $exportParams['format'] = 'excel';
                    @endphp

                    <form method="GET" class="mb-3">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-3 mt-3">
                                    <label class="form-label">Item Name</label>
                                    <div class="form-group">
                                        <input type="text" value="{{ request('item_name') }}" class="form-control"
                                            id="item_name" name="item_name" placeholder="Search Item By Name">
                                    </div>
                                </div>

                                <div class="col-sm-2 mt-3">
                                    <label class="form-label">Filter By Status</label>
                                    <select name="status" class="form-control" onchange="this.form.submit()">
                                        <option value="">All</option>
                                        <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>
                                            Available</option>
                                        <option value="Low Stock" {{ request('status') == 'Low Stock' ? 'selected' : '' }}>
                                            Low Stock</option>
                                        <option value="Out Of Stock"
                                            {{ request('status') == 'Out Of Stock' ? 'selected' : '' }}>Out Of Stock
                                        </option>
                                    </select>
                                </div>

                                <div class="col-sm-2 mt-3">
                                    <label class="form-label">Per Page</label>
                                    <select name="per_page" class="form-control" onchange="this.form.submit()">
                                        @foreach ([10, 25, 50, 100] as $pp)
                                            <option value="{{ $pp }}"
                                                {{ (int) request('per_page', 10) === $pp ? 'selected' : '' }}>
                                                {{ $pp }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mt-3">
                                    <button type="submit" class="btn btn-primary mt-4">Find Items</button>
                                    <a href="{{ route('store.present-stock-reports') }}"
                                        class="btn btn-warning mt-4">Reset</a>
                                    <a href="{{ route('store.present-stock-reports.export', $exportParams) }}"
                                        class="btn btn-success mt-4">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Item Name</th>
                                    <th>Unit Type</th>
                                    <th>Total QTY</th>
                                    <th>Return QTY</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($pasent_stock as $stock)
                                    @php
                                        $statusClass = 'badge badge-gradient-secondary mt-2';
                                        if ($stock['status'] == 'Available') {
                                            $statusClass = 'badge badge-gradient-success mt-2';
                                        }
                                        if ($stock['status'] == 'Low Stock') {
                                            $statusClass = 'badge badge-gradient-warning mt-2';
                                        }
                                    @endphp

                                    <tr>
                                        <td>{{ $pasent_stock->firstItem() + $loop->index }}</td>
                                        <td>
                                            <a href="{{ route('store.item-info', ed($stock['id'], true)) }}">
                                                {{ $stock['item'] }}
                                            </a>
                                        </td>
                                        <td>{{ $stock['relation'] }}</td>
                                        <td>{{ $stock['check_qty'] > 0 ? $stock['qty'] . ' (' . $stock['total_qty'] . ')' : $stock['total_qty'] }}
                                        </td>
                                        <td>{{ $stock['return_qty'] }}</td>
                                        <td>₹{{ number_format($stock['amount'], 2) }}</td>
                                        <td><span class="{{ $statusClass }}">{{ $stock['status'] }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No data found.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <tfoot>
                                <tr style="font-size: 18px">
                                    <th class="text-end" colspan="5">Per Page Total Amount</th>
                                    <th colspan="2">₹{{ number_format($pageTotal ?? 0, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $pasent_stock->firstItem() ?? 0 }} to {{ $pasent_stock->lastItem() ?? 0 }}
                            of {{ $pasent_stock->total() }} entries
                        </div>
                        <div>{{ $pasent_stock->links() }}</div>
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection
