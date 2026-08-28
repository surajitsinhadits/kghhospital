@extends('layouts.structure')
@push('title')
    <title>Department Stock Report</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">DEPARTMENT STOCK REPORT</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    @csrf
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5 mt-3">
                                <label class="form-label">Department <span class="text-danger">*</span></label>
                                <select name="dept" class="form-control select2-show-search" required>
                                        <option value="">Select Department</option>
                                        @foreach ($department as $value)
                                            <option value="{{ @$value->id }}" {{ $request->dept && $request->dept == $value->id ? 'selected' : '' }}>{{ @$value->department_name }}</option>
                                        @endforeach
                                </select>
                                @error('dept')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @if( @$request->dept )
                            <div class="col-sm-2 mt-3">
                                <label class="form-label">Item Name </label>
                                <div class="form-group">
                                    <input type="text" value="{{ $request->item_name ?? '' }}" class="form-control" id="item_name" name="item_name" placeholder="Search Item By Name">
                                </div>
                            </div>
                            @endif
                            <div class="col-md-2 mt-3">
                                <button type="submit" class="btn btn-primary mt-4">Find Items</button>
                                <a href="{{ route('store.department-stock-reports') }}" class="btn btn-warning mt-4">Reset</a>
                                @if( @$request->dept )
                                    <a href="{{ route('store.department-stock-reports.export', ['format' => 'excel', 'dept' => $request->dept, 'item_name' => $request->item_name]) }}"
                                        class="btn btn-success mt-4">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
                @if(@$request->dept)
                <div class="table-responsive mt-4">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th>Sl. No.</th>
                                <th>Item Name</th>
                                <th>Unit Type</th>
                                <th>Issue QTY</th>
                                <th>Return QTY</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( $pasent_stock )
                                @php $total = 0; @endphp
                                @foreach ($pasent_stock as $stock)
                                @php
                                    $t_arr = explode(' ', $stock['total_qty']);
                                    $r_arr = explode(' ', $stock['return_qty']);
                                    $amount = $stock['amount'] - (($stock['amount'] / $t_arr[0]) * $r_arr[0]);
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('store.item-info', ed($stock['id'], true)) }}">
                                            {{ $stock['item'] }}
                                        </a>
                                    </td>
                                    <td>{{ $stock['relation'] }}</td>
                                    <td>{{ $stock['qty'] }} ({{ $stock['total_qty'] }})</td>
                                    <td>{{ $stock['return_qty'] }}</td>
                                    <td>₹{{ $amount }}</td>
                                    @php
                                        $total = $total + $amount;
                                    @endphp
                                </tr>
                                @endforeach
                                <tr style="font-size: 18px">
                                    <td class="text-center" colspan="5">Total Amount</td>
                                    <td>₹{{$total}}</td>
                                </tr>
                            @else
                            <tr style="font-size: 18px">
                                <td class="text-center" colspan="6">No Record Found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')

@endpush
