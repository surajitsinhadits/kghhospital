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
                        <table id="example1" class="table table-borderless text-nowrap datatable" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr role="row">
                                    @foreach ($head as $th)
                                        <th>{{ $th }}</th>
                                    @endforeach
                                    @if ($title != 'Permission')
                                    <th>Inactive</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($response as $index => $item)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">{{ $index + 1 }}</td>
                                        @foreach ($form as $td)
                                            <th>{{ data_get($item, $td == 'charges_categories_name' ? 'charges_catagories_name' : $td) }}</th>
                                        @endforeach
                                        @if ($t1 != 'Charges Section List')
                                            <td>
                                                @if ($t1 == 'Charges Category List' && @$edit['suburl'])
                                                    <a class="btn btn-sm btn-outline-info"
                                                        href="{{ @$edit['suburl'] }}/{{ ed($item->id, true) }}">
                                                        <i class="fa fa-eye"></i> Sub-Category
                                                    </a>
                                                @endif
                                                @if ($title !== 'Charges Section' && $title != 'Permission')
                                                    <a class="btn btn-sm btn-outline-primary"
                                                        href="{{ $edit['url'] }}/{{ ed($item->id, true) }}">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                @endif
                                                @if ($title == 'Salary Master')
                                                    <a class="btn btn-sm btn-outline-info"
                                                        href="{{ $edit['salary_structure'] }}/{{ ed($item->id, true) }}">
                                                        <i class="fa fa-edit"></i> Set Structure
                                                    </a>
                                                @endif
                                                @if ($title == 'Salary Type')
                                                    <a class="btn btn-sm btn-outline-info"
                                                        href="{{ $edit['rule'] }}/{{ ed($item->id, true) }}">
                                                        <i class="fa fa-info"></i> Rules
                                                    </a>
                                                @endif
                                            </td>
                                        @endif
                                        @if ($title != 'Permission')
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" @if ($item->status == 1) checked @endif
                                                    onchange="toggleStatus('{{ $item->id }}', '{{ $table }}','status', this)">
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        @endif
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
                                <label for="{{ $item }}"
                                    class="medicinelabel">{{ ucwords(str_replace('_', ' ', $item)) }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="{{ $item }}" name="{{ $item }}"
                                    value="{{ old($item, data_get($edit['data'] ?? null, $item === 'charges_categories_name' ? 'charges_catagories_name' : $item)) }}"
                                    placeholder="{{ ucwords(str_replace('_', ' ', $item)) }}">
                                @error($item)
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @if ($t1 == 'Bed List') @break @endif
                        @endforeach
                        @if ($t1 == 'Bed List')
                            <div class="form-group">
                                <label for="ward">Ward <span class="text-danger">*</span></label>
                                <select id="ward" name="ward_id" class="form-control">
                                    <option value="">Select Ward</option>
                                    @foreach ($ward as $list)
                                        <option value="{{ @$list->id }}"
                                            {{ @$edit['data']->ward_id == $list->id ? 'selected' : '' }}>
                                            {{ @$list->ward_name }}</option>
                                    @endforeach
                                </select>
                                @error('ward_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @elseif($t1 == 'Charges Category List' || $t1 == 'Charges Sub-Category List')
                            <div class="form-group">
                                <label for="category">Parent Category</label>
                                <select id="category" name="parent_id" class="form-control">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                        @elseif($t1 == 'Salary Structure List')
                            <div class="form-group">
                                <label for="salary_type_id">Type</label>
                                <select id="salary_type_id" name="salary_type_id" class="form-control"
                                    onchange="getSalaryRules(this)">
                                    <option value="">Select Type</option>
                                    @foreach (@$extra['salary_type'] as $item)
                                        <option value="{{ $item->id }}">{{ $item->salary_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="salary_rule">Rule</label>
                                <select id="salary_rule" name="salary_rules_id" class="form-control">

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
@endsection
@push('js')
    @if ($t1 == 'Charges Category List' || $t1 == 'Charges Sub-Category List')
        <script>
            $(document).ready(function() {
                $.ajax({
                    url: "{{ route('hr.categories') }}",
                    type: "GET",
                    success: function(response) {
                        $('#category').empty().append('<option value="">Select Category</option>');
                        $.each(response, function(key, value) {
                            let selected = "{{ @$edit['data']->parent_id }}" == value.id ?
                                'selected' : '';
                            $('#category').append('<option value="' + value.id + '" ' + selected +
                                '>' + value.charges_catagories_name + '</option>');
                        });
                    },
                    error: function() {
                        $('#category').empty().append('<option value="">Failed to load</option>');
                    }
                });
            });
        </script>
    @elseif($t1 == 'Salary Structure List')
        <script>
            function getSalaryRules(e) {
                let id = e.value;
                if(id){
                    $.ajax({
                        url: "{{route('payroll.get-salary-rules-by-type')}}/" + id, // Ensure correct Laravel route syntax
                        type: "GET",
                        dataType: "json", // Ensure response is parsed as JSON
                        success: function(response) {

                            $('#salary_rule').empty().append('<option value="">Select Rule</option>');

                            $.each(response, function(key, value) {
                                let selected = "{{ @$edit['data']->id }}" == value.id ? 'selected' : '';

                                $('#salary_rule').append('<option value="' + value.id + '" ' + selected +
                                    '>' + value.rule + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX Error:", status, error); // Debugging errors
                            $('#salary_rule').empty().append('<option value="">Failed to load</option>');
                        }
                    });
                }
            }
        </script>
    @endif
@endpush
