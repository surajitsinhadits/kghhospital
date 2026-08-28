@extends('layouts.structure')

@push('title')
    <title>Create TDS Duties & Taxes Ledger Master</title>
@endpush

@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card_hearder_mimi d-flex justify-content-between align-items-center">
                <h4 class="card-title card_hearder_mimi_text mb-0">Create TDS Duties & Taxes Ledger Master</h4>
                <a href="{{ route('tds-duties-taxes-ledger-master.index') }}" class="btn btn-secondary btn-sm">Back</a>
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

                <form action="{{ route('tds-duties-taxes-ledger-master.store') }}" method="POST">
                    @csrf
                    @include('hr.tds_duties_taxes_ledger_master.form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
