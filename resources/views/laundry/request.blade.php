@extends('layouts.structure')
@push('title')
    <title>Dashboard</title>
@endpush
@push('css')
@endpush
@section('main-content')
<h2>Request Laundry</h2>
<form method="POST" action="{{ route('laundry.store') }}">
    @csrf
    <textarea name="clothes_description" required></textarea>
    <button type="submit">Submit</button>
</form>

@endsection
@push('js')
@endpush
