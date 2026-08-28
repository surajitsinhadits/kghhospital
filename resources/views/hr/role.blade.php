@extends('layouts.structure')
@push('title')
    <title>Dashboard</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header card_hearder_mimi">
                <h4 class="card-title card_hearder_mimi_text">Add Role</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('hr.insert-role') }}">
                    @csrf
                    <div class="">
                        <div class="form-group">
                            <label for="role" class="medicinelabel">Role</label>
                            <input type="text" id="role" name="role" required>
                            @error('role')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 mb-0">Add Role</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header card_hearder_mimi">
                <div class="card-title card_hearder_mimi_text">Role List</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-borderless text-nowrap key-buttons">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">Sl. No</th>
                                <th class="border-bottom-0">Role</th>
                                @isok('ROLE ASSIGN')<th class="border-bottom-0">Assign Permission</th>@endisok
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->role }}</td>
                                    @isok('ROLE ASSIGN')
                                    <td>
                                        <a href="{{ route('hr.permission-assign', ed($item->id, true)) }}"
                                            class="btn btn-info" data-toggle="tooltip-primary" data-bs-placement="top"
                                            title="Assign Permission To This Role"><i class="fa fa-check"></i></a>
                                    </td>
                                    @endisok
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
@endpush
