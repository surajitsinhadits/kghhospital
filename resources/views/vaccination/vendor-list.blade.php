@extends('layouts.structure')
@push('title')
    <title>Vendor List</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">
                    VENDOR LIST
                </h4>
                <div>
                    <a class="btn btn-sm btn-warning" href="{{Route('vc.add-vendor')}}">ADD NEW VENDOR</a>
                </div>
            </div>
            <div class="card-body p-0" style="margin-bottom: 32px;">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered data-table w-100">
                            <thead>
                                <tr role="row">
                                    <th>Sl. No</th>
                                    <th>Vendor Name</th>
                                    <th>Phone No</th>
                                    <th>Vendor GST</th>
                                    <th>Contact Person Name</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($response as $item)
                                <tr role="row" class="odd">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->vendor_name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->gstin }}</td>
                                    <td>{{ $item->contact_person_name }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox"
                                                @if($item->is_active == 1) checked @endif
                                                onchange="toggleStatus('{{ $item->id }}', 'vc_vendors','is_active', this)">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <a href="{{route('vc.edit-vendor')}}/{{ed($item->id, true)}}" class="btn btn-sm btn-outline-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    function toggleStatus(id, table, col, element) {
        let url = "{{ route('is-active', ['id' => '__id__', 'table' => '__table__', 'col' => '__col__']) }}"
                    .replace('__id__', id)
                    .replace('__table__', table)
                    .replace('__col__', col);
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
        .then(data => {
            console.log("Status Updated!");
        }).catch(error => {
            console.error('Error:', error);
            element.checked = !element.checked; 
        });
    }
    </script>
@endpush
