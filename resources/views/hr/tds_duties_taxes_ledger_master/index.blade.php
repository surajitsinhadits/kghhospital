@extends('layouts.structure')

@push('title')
    <title>TDS Duties & Taxes Ledger Master</title>
@endpush

@section('main-content')
<style>
    .tds-ledger-table th,
    .tds-ledger-table td {
        vertical-align: middle;
        text-align: center;
    }
    .tds-ledger-table td.text-left {
        text-align: left !important;
    }
    .status-yes {
        background: #d4edda;
        color: #155724;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-no {
        background: #f8d7da;
        color: #721c24;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card_hearder_mimi d-flex justify-content-between align-items-center">
                <h4 class="card-title card_hearder_mimi_text mb-0">TDS Duties & Taxes Ledger Master List</h4>
                <a href="{{ route('tds-duties-taxes-ledger-master.create') }}" class="btn btn-primary">Add New</a>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0 tds-ledger-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>TDS Ledger Name</th>
                                <th>Under Group</th>
                                <th>Section Code</th>
                                <th>Deductee Type</th>
                                <th>TDS Rate</th>
                                <th>TDS Type</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-left">{{ $item->tds_ledger_name }}</td>
                                    <td class="text-left">{{ $item->under_group }}</td>
                                    <td class="text-left">{{ $item->tds_section_code }}</td>
                                    <td class="text-left">{{ $item->deductee_type }}</td>
                                    <td>{{ number_format((float)$item->tds_rate, 2) }}</td>
                                    <td>{{ $item->tds_type }}</td>
                                    <td>
                                        <a href="{{ route('tds-duties-taxes-ledger-master.show', $item->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('tds-duties-taxes-ledger-master.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                        <form action="{{ route('tds-duties-taxes-ledger-master.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this record?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
