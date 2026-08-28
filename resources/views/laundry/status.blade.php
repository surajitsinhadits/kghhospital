@extends('layouts.structure')
@push('title')
    <title>Dashboard</title>
@endpush
@push('css')
@endpush
@section('main-content')
<h2>Your Laundry Requests</h2>
<ul>
    @foreach($requests as $req)
        <li>{{ $req->clothes_description }} - {{ $req->status }}</li>
    @endforeach
</ul>

@endsection
@push('js')
@endpush
