@extends('layouts.structure')
@push('title')
    <title>{{ $title }}</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-md-8 py-2 px-3">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <div class="card-title card_hearder_mimi_text">{{ $t1 }}</div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-borderless text-nowrap datatable" role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr role="row">
                                    @foreach ($head as $th)
                                        <th>{{ $th }}</th>
                                    @endforeach
                                    <th>Inactive</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($response as $index => $item)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">{{ $index + 1 }}</td>
                                        @foreach ($form as $td)
                                            <th>{{ $item->$td }}</th>
                                        @endforeach
                                        <td>
                                            @if ($t1 == 'Item Category List' && @$edit['suburl'])
                                            <a class="btn btn-sm btn-outline-info"
                                                href="{{ @$edit['suburl'] }}/{{ ed($item->id, true) }}">
                                                <i class="fa fa-eye"></i> Sub-Category
                                            </a>
                                            @endif
                                            <a class="btn btn-sm btn-outline-primary"
                                                        href="{{ $edit['url'] }}/{{ ed($item->id, true) }}">
                                                        <i class="fa fa-edit"></i> Edit
                                            </a>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" @if ($item->status == 1) checked @endif
                                                    onchange="toggleStatus('{{ $item->id }}', '{{ $table }}','status', this)">
                                                <span class="slider round"></span>
                                            </label>
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
                    <h4 class="card-title card_hearder_mimi_text">{{ $t2 }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ $btn['action'] }}">
                    @csrf
                    @foreach ($form as $item)
                        @if ($t1 == 'Salary Structure List') @break @endif
                        <div class="form-group">
                            <label for="{{ $item }}" class="medicinelabel">{{ ucwords(str_replace('_', ' ', $item)) }}
                                @if( $item != 'department_code' )
                                <span class="text-danger">*</span></label>
                                @endif
                            <input type="text" id="{{ $item }}" name="{{ $item }}" value="{{ old($item, @$edit['data']->$item) }}" placeholder="{{ ucwords(str_replace('_', ' ', $item)) }}">
                            @error($item)
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endforeach
                    @if($t1 == 'Item Category List' || $t1 == 'Item Sub-Category List')
                            <div class="form-group">
                                <label for="category">Item Category</label>
                                <select id="category" name="parent_id" class="form-control">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                    @endif
                    <button type="submit" class="btn btn-primary mt-4 mb-0">{{ $btn['name'] }}</button>
                    @if (@$edit['data'])
                        <a href="{{ @$edit['reset'] }}" class="btn btn-warning mt-4 mb-0">Reset</a>
                    @endif
                    </form>
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
     @if ($t1 == 'Item Sub-Category List' || $t1 == 'Item Category List')
     <script>
         $(document).ready(function() {
             $.ajax({
                 url: "{{ route('store.categories') }}",
                 type: "GET",
                 success: function(response) {
                     $('#category').empty().append('<option value="">Select Category</option>');
                     $.each(response, function(key, value) {
                         let selected = "{{ @$edit['data']->parent_id }}" == value.id ?
                             'selected' : '';
                         $('#category').append('<option value="' + value.id + '" ' + selected +
                             '>' + value.category_name + '</option>');
                     });
                 },
                 error: function() {
                     $('#category').empty().append('<option value="">Failed to load</option>');
                 }
             });
         });
     </script>
     @endif
@endpush
