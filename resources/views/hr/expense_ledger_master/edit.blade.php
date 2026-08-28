@extends('layouts.structure')

@push('title')
    <title>Edit Expense Ledger Master</title>
@endpush

@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Edit Expense Ledger Master</h4>
                <a href="{{ route('expense-ledger-master.index') }}" class="btn btn-secondary btn-sm">
                    Back
                </a>
            </div>

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 pl-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('expense-ledger-master.update', $item->id) }}" method="POST">
                    @csrf
                    @include('hr.expense_ledger_master.form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
