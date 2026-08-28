@extends('layouts.structure')
@push('title')
    <title>Return Processing to {{ ucwords($type) }}</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="card">
        <div class="card-header d-block card_hearder_mimi">
            <div class="row">
                <div class="col-md-6 card-title card_hearder_mimi_text">
                    Return Processing to {{ ucwords($type) }}
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="GET">
                @if ($type == 'store')
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5 mt-3">
                                <label class="form-label">Department <span class="text-danger">*</span></label>
                                <select name="dept" class="form-control select2-show-search" required>
                                        <option value="">Select Department</option>
                                        @foreach ($department as $value)
                                            <option value="{{ @$value->id }}" {{ @$_GET['dept'] ?? @$edit->dept_id ? ((@$_GET['dept'] ?? @$edit->dept_id) == $value->id ? 'selected' : 'disabled') : '' }}>{{ @$value->department_name }}</option>
                                        @endforeach
                                </select>
                                @error('dept')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @if(!@$edit->dept_id)
                            <div class="col-md-2 mt-3">
                                <button type="submit" class="btn btn-primary mt-4">Find Items</button>
                                <a href="{{ route('store.add-return', $type) }}" class="btn btn-warning mt-4">Reset</a>
                            </div>
                            @endif
                            <div class="col-md-5 mt-3 px-4 text-center">
                                <div class="text-danger">** Only <b>NON - CONSUMABLES & SEMI - CONSUMABLES</b> type of Items returnable.</div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5 mt-3">
                                <label class="form-label">Vendor <span class="text-danger">*</span></label>
                                <select name="vendor" class="form-control select2-show-search" required>
                                        <option value="">Select Vendor</option>
                                        @foreach ($vendors as $val)
                                            <option value="{{ @$val->id }}" {{ @$_GET['vendor'] ?? @$edit->vendor_id ? ((@$_GET['vendor'] ?? @$edit->vendor_id) == $val->id ? 'selected' : 'disabled') : '' }}>{{ @$val->vendor_name }}</option>
                                        @endforeach
                                </select>
                                @error('vendor')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @if(!@$edit->vendor_id)
                            <div class="col-md-2 mt-3">
                                <button type="submit" class="btn btn-primary mt-4">Find Items</button>
                                <a href="{{ route('store.add-return', $type) }}" class="btn btn-warning mt-4">Reset</a>
                            </div>
                            @endif
                        </div>
                    </div>
                @endif
            </form>
            @if ($type == 'store')
                @if(@$_GET['dept'] ?? @$edit->dept_id)
                <form method="POST" action="{{route('store.update-return', @$edit->id ?? 0)}}" id="yourFormId">
                    @csrf
                    <input type="hidden" name="return_type" value="{{ @$type }}">
                    <input type="hidden" name="dept_id" value="{{ @$_GET['dept'] ?? @$edit->dept_id }}">
                    <div class="card-body" style="margin:-6px;">
                        <div class="row">
                            <div class="col-md-2 mt-3">
                                <label class="form-label" style="margin: 3px 0px 0px 0px">Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control dateTimePickr" name="date" value="{{ dateFor(@$edit->return_date, true) ?? date('d-m-Y h:i A') }}" placeholder="Date" required>
                            </div>
                            <div class="col-md-10 mt-3">
                                <label class="form-label" style="margin: 3px 0px 0px 0px">Remarks</label>
                                <input type="text" class="form-control" name="remarks" value="{{ @$edit->remarks }}" placeholder="Remarks">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap border" id="data-table">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="text-white" style="width: 25%">Item Name <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 8%">Type <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 20%">Note <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 12%">Batch No <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 7%">Unit Qty <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 9%">Unit <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 7%">Sub Unit Qty <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 9%">Sub Unit <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 3%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="chargeTable">
                                        <tr>
                                            <td>
                                                <select class="form-control select2-show-search issue_id" onchange="getItemDetails(this.value, this)">
                                                    <option value="">Select Issue Item</option>
                                                    @foreach ($item_list as $value)
                                                        <option value="{{ $value->issue_id }}"
                                                            data-itemid="{{ $value->item_id }}"
                                                            data-partno="{{ $value->part_no }}"
                                                            data-unitqty="{{ $value->unit_qty }}"
                                                            data-subunitqty="{{ $value->sub_unit_qty }}"
                                                            data-unit="{{ $value->unit }}"
                                                            data-subunit="{{ $value->sub_unit }}"
                                                        >{{ $value->item_name }} ({{ $value->part_no }})</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control type">
                                                    <option value="return">Return</option>
                                                    <option value="repair">Repair</option>
                                                    <option value="damage">Damage</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control note" value="">
                                            </td>
                                            <td>
                                                <input class="form-control part_no" type="text" value="" readonly />
                                            </td>
                                            <td>
                                                <input class="form-control unit_qty" type="number" min="0" value="0" step="0.1" />
                                            </td>
                                            <td>
                                                <input class="form-control unit" readonly type="text" value="0" />
                                            </td>
                                            <td>
                                                <input class="form-control sub_unit_qty" type="number" min="0" value="0" step="0.1" />
                                            </td>
                                            <td>
                                                <input class="form-control sub_unit" readonly type="text" value="0" />
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-sm" type="button" onclick="validation()">+</button>
                                            </td>
                                        </tr>
                                        @foreach(@$edit_info ?? [] as $key => $item)
                                            <input type="hidden" name="uppid[]" value="{{ $item->id }}">
                                            <tr>
                                                <td>
                                                    <select class="form-control" name="issue_id[]">
                                                        <option value="">Select Item</option>
                                                        @foreach ($item_list as $value)
                                                            <option value="{{ $value->issue_id }}" {{ @$item->issue_id == $value->issue_id ? 'selected' : 'disabled' }}>
                                                                {{ @$value->item_name }} ({{ @$value->part_no }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="type[]">
                                                        <option value="return" {{ @$item->type == 'return' ? 'selected' : '' }}>Return</option>
                                                        <option value="repair" {{ @$item->type == 'repair' ? 'selected' : '' }}>Repair</option>
                                                        <option value="damage" {{ @$item->type == 'damage' ? 'selected' : '' }}>Damage</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="note[]" value="{{ @$item->note }}" />
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="part_no[]" value="{{ @$item->part_no }}" readonly />
                                                </td>
                                                <td><input class="form-control" name="unit_qty[]" type="number" min="0" value="{{ @$item->unit_qty }}" step="0.1" /></td>
                                                <td><input class="form-control" name="unit_name[]" type="text" readonly value="{{ @$item->unit }}" /></td>
                                                <td><input class="form-control" name="sub_unit_qty[]" type="number" min="0" max="{{ @$item->sub_unit_no - 1 }}" value="{{ @$item->sub_unit_qty }}" step="0.1" /></td>
                                                <td><input class="form-control" name="sub_unit_name[]" type="text" readonly value="{{ @$item->sub_unit }}" /></td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm" type="button" onclick="removeRow(this)">X</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-4">
                        <input type="submit" name="save" style="width: 85px" value="Save" class="btn btn-primary px-5">
                        @if(@$edit)
                        <input type="submit" name="save" style="width: 170px" value="Save & Approved" class="btn btn-success px-5">
                        <input type="submit" name="save" style="width: 100px" value="Reject" class="btn btn-danger px-5">
                        @isok('STORE RETURN APPROVE')
                        @endisok
                        @endif
                    </div>
                </form>
                @endif
            @else
                @if(@$_GET['vendor'] ?? @$edit->vendor_id)
                <form method="POST" action="{{route('store.update-return', @$edit->id ?? 0)}}" id="yourFormId">
                    @csrf
                    <input type="hidden" name="return_type" value="{{ @$type }}">
                    <input type="hidden" name="vendor_id" value="{{ @$_GET['vendor'] ?? @$edit->vendor_id }}">
                    <div class="card-body" style="margin:-6px;">
                        <div class="row">
                            <div class="col-md-2 mt-3">
                                <label class="form-label" style="margin: 3px 0px 0px 0px">Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control dateTimePickr" name="date" value="{{ dateFor(@$edit->return_date, true) ?? date('d-m-Y h:i A') }}" placeholder="Date" required>
                            </div>
                            <div class="col-md-10 mt-3">
                                <label class="form-label" style="margin: 3px 0px 0px 0px">Remarks</label>
                                <input type="text" class="form-control" name="remarks" value="{{ @$edit->remarks }}" placeholder="Remarks">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap border" id="data-table">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="text-white" style="width: 28%">Item Name <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 25%">Note <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 12%">Batch No <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 7%">Unit Qty <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 9%">Unit <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 7%">Sub Unit Qty <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 9%">Sub Unit <span class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 3%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="chargeTable">
                                        <tr>
                                            <td>
                                                <select class="form-control select2-show-search issue_id" onchange="getItemDetails(this.value, this)">
                                                    <option value="">Select Issue Item</option>
                                                    @foreach ($item_list as $value)
                                                        <option value="{{ $value->issue_id }}"
                                                            data-itemid="{{ $value->item_id }}"
                                                            data-partno="{{ $value->part_no }}"
                                                            data-unitqty="{{ $value->unit_qty }}"
                                                            data-subunitqty="{{ $value->sub_unit_qty }}"
                                                            data-unit="{{ $value->unit }}"
                                                            data-subunit="{{ $value->sub_unit }}"
                                                        >{{ $value->item_name }} ({{ $value->part_no }})</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control note" value="">
                                            </td>
                                            <td>
                                                <input class="form-control part_no" type="text" value="" readonly />
                                            </td>
                                            <td>
                                                <input class="form-control unit_qty" type="number" min="0" value="0" step="0.1" />
                                            </td>
                                            <td>
                                                <input class="form-control unit" readonly type="text" value="0" />
                                            </td>
                                            <td>
                                                <input class="form-control sub_unit_qty" type="number" min="0" value="0" step="0.1" />
                                            </td>
                                            <td>
                                                <input class="form-control sub_unit" readonly type="text" value="0" />
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-sm" type="button" onclick="validation()">+</button>
                                            </td>
                                        </tr>
                                        @foreach(@$edit_info ?? [] as $key => $item)
                                            <input type="hidden" name="uppid[]" value="{{ $item->id }}">
                                            <tr>
                                                <td>
                                                    <select class="form-control" name="issue_id[]">
                                                        <option value="">Select Item</option>
                                                        @foreach ($item_list as $value)
                                                            <option value="{{ $value->issue_id }}" {{ @$item->issue_id == $value->issue_id ? 'selected' : 'disabled' }}>
                                                                {{ @$value->item_name }} ({{ @$value->part_no }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="note[]" value="{{ @$item->note }}">
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="part_no[]" value="{{ @$item->part_no }}" readonly />
                                                </td>
                                                <td><input class="form-control" name="unit_qty[]" type="number" min="0" value="{{ @$item->unit_qty }}" step="0.1" /></td>
                                                <td><input class="form-control" name="unit_name[]" type="text" readonly value="{{ @$item->unit }}" /></td>
                                                <td><input class="form-control" name="sub_unit_qty[]" type="number" min="0" max="{{ @$item->sub_unit_no - 1 }}" value="{{ @$item->sub_unit_qty }}" step="0.1" /></td>
                                                <td><input class="form-control" name="sub_unit_name[]" type="text" readonly value="{{ @$item->sub_unit }}" /></td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm" type="button" onclick="removeRow(this)">X</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-4">
                        <input type="submit" name="save" style="width: 170px" value="Save & Approved" class="btn btn-success px-5">
                    </div>
                </form>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    function getItemDetails(item_id, element) {
        let selectedOption = element.options[element.selectedIndex];
        let row = $(element).closest('tr');
        row.find('.unit').val(selectedOption.getAttribute('data-unit') || '');
        row.find('.sub_unit').val(selectedOption.getAttribute('data-subunit') || '');
        row.find('.part_no').val(selectedOption.getAttribute('data-partno') || '');
        row.find('.unit_qty').attr('max', selectedOption.getAttribute('data-unitqty'));
        if (selectedOption.getAttribute('data-itemid')) {
            $.ajax({
                url: "{{ route('store.get-item-unit-and-sub-unit') }}",
                type: "POST",
                data: {
                    itemId: selectedOption.getAttribute('data-itemid'),
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(res) {
                    let row2 = $(element).closest('tr');
                    row2.find('.sub_unit_qty').attr('max', res.sub_unit_no - 1);
                }
            });
        }
    }

    function validation() {
        var row = $('#chargeTable').find('tr:first');
        var itemSelect = row.find('.issue_id').val();
        var unitQtyInput = row.find('.unit_qty');
        var subUnitQtyInput = row.find('.sub_unit_qty');
        var unitQty = parseFloat(unitQtyInput.val());
        var maxUnitQty = parseFloat(unitQtyInput.attr('max'));
        var subUnitQty = parseFloat(subUnitQtyInput.val());
        var maxSubUnitQty = parseFloat(subUnitQtyInput.attr('max'));

        if (itemSelect === '') {
            alert('Please Select an Item & Unit!');
        } else if (unitQty <= 0 && subUnitQty <= 0) {
            alert('Please Select Unit or Subunit!');
        } else if (unitQty > maxUnitQty) {
            alert('Unit Qty cannot exceed the maximum allowed value (' + maxUnitQty + ')!');
        } else if (!isNaN(maxSubUnitQty) && (subUnitQty > maxSubUnitQty)) {
            alert('Sub Unit Qty cannot exceed the maximum allowed value (' + maxSubUnitQty + ')!');
        } else {
            addNewrow();
        }
    }

    function addNewrow() {
        let type = @json($type);
        let firstRow = $('#chargeTable').find('tr:first');
        let item_id = firstRow.find('.issue_id').val();
        let item_text = firstRow.find('.issue_id option:selected').text();
        let type_value = firstRow.find('.type').val();
        let type_text = firstRow.find('.type option:selected').text();
        let part_no = firstRow.find('.part_no').val();
        let note = firstRow.find('.note').val();
        let unit_qty = firstRow.find('.unit_qty').val();
        let unit = firstRow.find('.unit').val();
        let sub_unit_qty = firstRow.find('.sub_unit_qty').val();
        let sub_unit = firstRow.find('.sub_unit').val();
        let unit_id = firstRow.find('.unit_id').val();
        let sub_unit_id = firstRow.find('.sub_unit_id').val();
        let newRow = `<tr>
            <td>
                <select class="form-control" name="issue_id[]">
                    <option value="${item_id}" selected>${item_text}</option>
                </select>
            </td>`;

        if(type == 'store'){
            newRow += `<td>
                <select class="form-control" name="type[]">
                    <option value="${type_value}" selected>${type_text}</option>
                </select>
            </td>
            <td>
                <input type="text" name="note[]" class="form-control" value="${note}">
            </td>`;
        }else{
            newRow += `<td>
                <input type="text" name="note[]" class="form-control" value="${note}">
            </td>`;
        }
        newRow += `<td>
                <input type="text" name="part_no[]" class="form-control" readonly value="${part_no}">
            </td>
            <td>
                <input type="text" name="unit_qty[]" class="form-control" readonly value="${unit_qty}">
            </td>
            <td>
                <input type="text" name="unit_name[]" class="form-control" readonly value="${unit}">
            </td>
            <td>
                <input type="text" name="sub_unit_qty[]" class="form-control" readonly value="${sub_unit_qty}">
            </td>
            <td>
                <input type="text" name="sub_unit_name[]" class="form-control" readonly value="${sub_unit}">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>
            </td>
        </tr>`;
        $('#chargeTable').append(newRow);

        // Reset first row
        firstRow.find('.issue_id').val('').trigger('change');
        firstRow.find('.type').val('return').trigger('change');
        firstRow.find('.note').val('');
        firstRow.find('.unit_qty').val('0');
        firstRow.find('.unit').val('');
        firstRow.find('.sub_unit_qty').val('0');
        firstRow.find('.sub_unit').val('');
        firstRow.find('.unit_id').val('');
        firstRow.find('.sub_unit_id').val('');
    }

    function removeRow(button) {
        let row = button.closest('tr');
        row.remove();
    }

    // $('#yourFormId').submit(function (e) {
    //     e.preventDefault();
    //     if ($('#chargeTable').find('tr').length <= 1) {
    //         alert('Please add at least one item.');
    //         return false;
    //     }
    //     this.submit(); // <-- Fix: call native DOM submit
    // });
</script>
@endpush

