@extends('layouts.structure')

@push('title')
    <title>Expense Ledger Master</title>
@endpush

@section('main-content')
<style>
    .expense-ledger-table th,
    .expense-ledger-table td {
        vertical-align: middle;
    }
    .expense-ledger-table th {
        white-space: nowrap;
    }
    .page-card .card-header {
        padding: 14px 20px;
    }
    .page-card .card-body {
        padding: 20px;
    }
    .badge-soft-success {
        background: #d4edda;
        color: #155724;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 12px;
    }
    .badge-soft-danger {
        background: #f8d7da;
        color: #721c24;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 12px;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card page-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Expense Ledger Master List</h4>
                <a href="{{ route('expense-ledger-master.create') }}" class="btn btn-primary">
                    Add New
                </a>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0 expense-ledger-table">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Ledger Name</th>
                                <th>Ledger Group</th>
                                <th>TDS Applicable</th>
                                <th>GST Applicable</th>
                                <th>Opening Balance</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->ledger_name }}</td>
                                    <td>{{ $item->ledger_group }}</td>
                                    <td>
                                        @if($item->tds_applicable)
                                            <span class="badge-soft-success">Y</span>
                                        @else
                                            <span class="badge-soft-danger">N</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->gst_applicable)
                                            <span class="badge-soft-success">Y</span>
                                        @else
                                            <span class="badge-soft-danger">N</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format((float)$item->opening_balance, 2) }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href="{{ route('expense-ledger-master.show', $item->id) }}" class="btn btn-info btn-sm">
                                                View
                                            </a>
                                            <a href="{{ route('expense-ledger-master.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                Edit
                                            </a>
                                            <a href="{{ route('expense-ledger-master.delete', $item->id) }}"
                                               onclick="return confirm('Delete this record?')"
                                               class="btn btn-danger btn-sm">
                                                Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($items, 'links'))
                    <div class="mt-3">
                        {{ $items->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
