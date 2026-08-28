@extends('layouts.structure')
@push('title')
    <title>{{$title}}</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">

        <div class="col-md-8 py-2 px-3">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <div class="card-title card_hearder_mimi_text">{{$t1}}</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-borderless text-nowrap key-buttons dataTable no-footer" role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr role="row">
                                    <th>Sl. No</th>
                                    <th>Head Name</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($response as $index => $item)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">{{$index + 1}}</td>
                                    <td>{{ $item->header_name }} </td>
                                    <td>
                                        @if(!empty($item->logo) && file_exists(public_path('assets/images/header/' . $item->logo)))
                                            <img src="{{ asset('public/assets/images/header/'. $item->logo) }} " alt="Logo" width="50" height="50">
                                        @else
                                            Null
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-primary" href="{{$edit['url']}}/{{ed($item->id, true)}}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 py-2 px-3">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <h4 class="card-title card_hearder_mimi_text">{{$t2}}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{$btn['action']}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="Head" class="medicinelabel">Head Name <span class="text-danger">*</span></label>
                            <input type="text" id="Head" name="header_name" value="{{ old('header_name', @$edit['data']->header_name) }}" placeholder="Head Name">
                            @error('header_name')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <td>
                            <label for="logo">Logo <small>(245px x 48px)</small> <span class="text-danger">*</span></label>
                            <input type="file" name="logo" id="logo" class="form-control" accept=".jpeg,.png,.jpg">
                            @if( @$edit['data']->logo)
                                <input type="hidden" name="old_logo" value="{{$edit['data']->logo}}">
                                <img src="{{ asset('public/assets/images/header/' . @$edit['data']->logo) }}" alt="Logo" width="100">
                            @endif
                            @error('logo')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </td>
                        <br>
                        <button type="submit" class="btn btn-primary mt-4 mb-0">{{$btn['name']}}</button>
                        @if (@$edit['data'])
                        <a href="{{@$edit['reset']}}" class="btn btn-warning mt-4 mb-0">Reset</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
