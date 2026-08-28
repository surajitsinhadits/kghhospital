@extends('layouts.structure')
@push('title')
    <title>{{ $title }}</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-header card_hearder_mimi">
                <h4 class="card-title card_hearder_mimi_text">{{ $t1 }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ $btn['action'] }}">
                    @csrf
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-1 addchargedesign">
                                        <div class="form-group">
                                            <label for="charge_type">#</label>
                                            <select id="charge_type" class="form-control" name="charge_type">
                                                <option value="other-services"
                                                    {{ isset($edit['data']) && $edit['data']->charge_type == 'other-services' ? 'selected' : '' }}>
                                                    OTHER SERVICES</option>
                                                <option value="investigation"
                                                    {{ isset($edit['data']) && $edit['data']->charge_type == 'investigation' ? 'selected' : '' }}>
                                                    INVESTIGATION</option>
                                            </select>
                                            @error('charge_type')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2 addchargedesign">
                                        <div class="form-group">
                                            <label for="charge_section"># (Profile / Non-profile)</label>
                                            <select id="charge_section" class="form-control" name="charge_section">
                                                <option value="profile"
                                                    {{ isset($edit['data']) && $edit['data']->charge_section == 'profile' ? 'selected' : '' }}>
                                                    Profile</option>
                                                <option value="non_profile"
                                                    {{ isset($edit['data']) && $edit['data']->charge_section == 'non_profile' ? 'selected' : '' }}>
                                                    Non-Profile</option>
                                            </select>
                                            @error('charge_section')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2 addchargedesign">
                                        <div class="form-group">
                                            <label for="category_id">Charge Category <span
                                                    class="text-danger">*</span></label>
                                            <select id="category_id" class="form-control select2-show-search"
                                                name="category_id" onchange="getCategory(this.value)">
                                                <option value=" ">Select Category</option>
                                                @foreach ($charge_category as $list)
                                                    <option value="{{ $list->id }}"
                                                        {{ isset($edit['data']) && $edit['data']->category_id == $list->id ? 'selected' : '' }}>
                                                        {{ $list->charges_catagories_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2 addchargedesign">
                                        <div class="form-group">
                                            <label for="sub_category_id">Charges Sub Category <span
                                                    class="text-danger">*</span></label>
                                            <select id="sub_category_id" class="form-control select2-show-search"
                                                name="sub_category_id">
                                                {{-- @foreach ($charge_subcategory as $list)
                                                    <option value="{{ $list->id }}"
                                                        {{ isset($edit['data']) && $edit['data']->sub_category_id == $list->id ? 'selected' : '' }}>
                                                        {{ $list->charges_catagories_name }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                            @error('sub_category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 addchargedesign">
                                        <div class="form-group">
                                            <label for="charge_name">Charges Name <span class="text-danger">*</span></label>
                                            <input type="text" id="charge_name" name="charge_name" class="form-control"
                                                value="{{ @$edit['data'] ? $edit['data']->charge_name : '' }}">
                                            @error('charge_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2 addchargedesign">
                                        <div class="form-group">
                                            <label for="requisition_section_id">Requisition Section</label>
                                            <select id="requisition_section_id" class="form-control select2-show-search"
                                                name="requisition_section_id">
                                                <option value=" ">Select Requisition</option>
                                                @foreach ($requisition as $list)
                                                    <option value="{{ $list->id }}"
                                                        {{ isset($edit['data']) && $edit['data']->requisition_section_id == $list->id ? 'selected' : '' }}>
                                                        {{ $list->requisition_section_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('requisition_section_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="row mb-5">
                                            @php
                                                if ($edit) {
                                                    $ids = array_column($edit['section'], 'id');
                                                } else {
                                                    $ids = null;
                                                }
                                            @endphp
                                            @foreach ($section as $list)
                                                <div class="col-md-2 addchargedesign">
                                                    <div class="input-group">
                                                        <label>{{ $list->charges_section_name }}</label>
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <input name="charge_section_id[]" type="checkbox"
                                                                    class="form-check-input section-checkbox"
                                                                    value="{{ $list->id }}"
                                                                    {{ $ids ? (in_array($list->id, $ids) ? 'checked' : '') : '' }}>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $amount = 0;
                                                            if ($edit) {
                                                                $index = array_search(
                                                                    $list->id,
                                                                    array_column($edit['section'], 'id')
                                                                );
                                                                $amount = $index !== false ? $edit['section'][$index]['amount'] : 0;
                                                            }
                                                        @endphp
                                                        <input type="text" name="charge_amount[]" class="form-control charge-amount"
                                                            value="{{ $amount }}" placeholder="Enter Amount"
                                                            {{ $ids && in_array($list->id, $ids) ? '' : 'disabled' }}>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="h">
                            <details>
                                <summary>Normal</summary>
                                <div class="content12">
                                    <div class="col-md-12">
                                        <div class="container1"
                                            style="
                                               overflow: hidden; ">
                                            <table
                                                style="overflow-x: auto;
                                                  display: block; "
                                                class="table-bordered" id="data-table">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 30px; padding-right:30px;">Lebel</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 36px; padding-right:36px;">Grp.Cd</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 120px; padding-right:120px;">Test Parameter
                                                        </th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 30px; padding-right:30px;">Seq No.</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 30px; padding-right:30px;">#</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 40px; padding-right:40px;">Comments</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 30px; padding-right:30px;">Unit</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 30px; padding-right:30px;">M/LL</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 30px; padding-right:30px;">M/UL</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 30px; padding-right:30px;">F/LL</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 30px; padding-right:30px;">F/UL</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 30px; padding-right:30px;">C/LL</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 30px; padding-right:30px;">C/UL</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 30px; padding-right:30px;">Method</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 30px; padding-right:30px;">Instrument Used
                                                        </th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 30px; padding-right:30px;">LISCd</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 140px; padding-right:140px;">Formula</th>
                                                        <th class="border-bottom-0 text-white"
                                                            style="padding-left: 15px; padding-right:15px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <select id="test_for" class="form-control">
                                                                    <option value="">Select</option>
                                                                    <option value="Child">CHLd </option>
                                                                    <option value="Group">Grp. </option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group ">
                                                                <input type="text" class="form-control"
                                                                    id="grp_cd">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group ">
                                                                <input type="text" class="form-control"
                                                                    id="test">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group ">
                                                                <input type="number" class="form-control"
                                                                    id="seq_no">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button type="button" onclick="validation()"
                                                                style="margin: -16px 0px 0px 17px;"
                                                                class="btn btn-primary btn-sm"><i
                                                                    class="fas fa-plus"></i></button>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                style="margin: -16px 0px 0px 0px;" id="comments">
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    id="unit">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    id="m_ll">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    id="m_ul">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    id="f_ll">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    id="f_ul">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    id="c_ll">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    id="c_ul">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    id="methode">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    id="ins_used">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    id="liscd">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    id="formula">
                                                            </div>
                                                        </td>
                                                        <td><button type="button" style="margin: -16px 0px 0px 17px;"
                                                                onclick="validation()" class="btn btn-primary btn-sm"><i
                                                                    class="fas fa-plus"></i></button></td>
                                                    </tr>
                                                    @if (@$edit['normal'])
                                                        @foreach ($edit['normal'] as $key => $value)
                                                            <tr style="background-color: #d5ffe8">
                                                                <input type="hidden" name="test_id[]" value="{{ @$value->id }}">
                                                                <td>
                                                                    <div class="form-group">
                                                                        <select id="test_for" name="test_for[{{ $key }}]" class="form-control">
                                                                            <option value="">Select</option>
                                                                            <option value="Child"
                                                                                {{ @$value->lebel == 'Child' ? 'selected' : '' }}>
                                                                                CHLd </option>
                                                                            <option value="Group"
                                                                                {{ @$value->lebel == 'Group' ? 'selected' : '' }}>
                                                                                Grp. </option>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group ">
                                                                        <input type="text" class="form-control" name="grp_cd[{{ $key }}]"
                                                                            id="grp_cd" value="{{ @$value->grp_cd }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group ">
                                                                        <input type="text" class="form-control"
                                                                            id="test" name="test[{{ $key }}]"
                                                                            value="{{ @$value->test_parameter }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group ">
                                                                        <input type="number" class="form-control" name="seq_no[{{ $key }}]"
                                                                            id="seq_no" value="{{ @$value->seq_no }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        style="margin: 2px 0px 0px 17px;"
                                                                        onclick="removeRow(this)">X</button>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ @$value->comments }}" name="comments[{{ $key }}]"
                                                                        style="margin: -16px 0px 0px 0px;" id="comments">
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="unit[{{ $key }}]"
                                                                            id="unit" value="{{ @$value->unit }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="m_ll[{{ $key }}]"
                                                                            id="m_ll" value="{{ @$value->m_ll }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="m_ul[{{ $key }}]"
                                                                            id="m_ul" value="{{ @$value->m_ul }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="f_ll[{{ $key }}]"
                                                                            id="f_ll" value="{{ @$value->f_ll }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="f_ul[{{ $key }}]"
                                                                            id="f_ul" value="{{ @$value->f_ul }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="c_ll[{{ $key }}]"
                                                                            id="c_ll" value="{{ @$value->c_ll }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="c_ul[{{ $key }}]"
                                                                            id="c_ul" value="{{ @$value->c_ul }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="methode[{{ $key }}]"
                                                                            id="methode" value="{{ @$value->method }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control"
                                                                            id="ins_used" name="ins_used[{{ $key }}]"
                                                                            value="{{ @$value->ins_used }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="liscd[{{ $key }}]"
                                                                            id="liscd" value="{{ @$value->lis_cd }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control"
                                                                            id="formula" name="formula[{{ $key }}]"
                                                                            value="{{ @$value->formula }}">
                                                                    </div>
                                                                </td>
                                                                <td><button type="button" class="btn btn-danger btn-sm"
                                                                        style="margin: 2px 0px 0px 17px;"
                                                                        onclick="removeRow(this)">X</button></td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </details>
                            <details>
                                <summary>Template</summary>
                                <div class="content12">
                                    <div class="content12">
                                        <div class="col-md-12 mt-3">
                                            <div class="col-md-12">
                                                <textarea class="text" rows="10" name="template">{{ isset($edit['data']) ? $edit['data']->template : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </details>
                            <div class="content12 mt-2">
                                <div class="col-md-12 mt-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="charge_type">Note</label>
                                            <textarea name="note" class="form-control" rows="4" cols="38">{{ isset($edit['data']) ? $edit['data']->note : '' }}</textarea>
                                            <br>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="instrument_used">Instrument Used</label>
                                            <textarea class="form-control" name="instrument_used" rows="4" cols="38">{{ isset($edit['data']) ? $edit['data']->instrument_used : '' }}</textarea>
                                            <br>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="sample_id">Sample</label>
                                                <select id="sample_id" class="form-control" name="sample_id">
                                                    <option value="">Select Sample</option>
                                                    @foreach ($sample as $list)
                                                        <option value="{{ $list->id }}"
                                                            {{ isset($edit['data']) && $edit['data']->sample_id == $list->id ? 'selected' : '' }}>
                                                            {{ $list->sample_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="sample_required">Sample Required</label>
                                                <input id="sample_required" class="form-control" name="sample_required"
                                                    value="{{ isset($edit['data']) ? $edit['data']->sample_required : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="vial_id">Vial</label>
                                                <select id="vial_id"
                                                    class="form-control select2-show-search select2-hidden-accessible"
                                                    name="vial_id">
                                                    <option value="">Select Vial</option>
                                                    @foreach ($vial as $list)
                                                        <option value="{{ $list->id }}"
                                                            {{ isset($edit['data']) && $edit['data']->vial_id == $list->id ? 'selected' : '' }}>
                                                            {{ $list->vial_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="submitBtn" class="btn btn-secondary mt-4 mb-0">SAVE CHARGE</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".section-checkbox").forEach(function (checkbox) {
                checkbox.addEventListener("change", function () {
                    let amountInput = this.closest(".input-group").querySelector(".charge-amount");
                    amountInput.disabled = !this.checked;
                    if (!this.checked) {
                        amountInput.value = '';
                    }
                });
            });
        });
        const cat = @json(@$edit['data']->category_id ?? old('category_id'));
        const subCat = @json(@$edit['data']->sub_category_id ?? old('sub_category_id'));
        if(subCat){
            getCategory(cat, subCat);
        }
        function validation() {
            var testName = $('#test').val(); // Get value from test input

            if (testName == '') {
                alert('Please Enter Test Name !!!');
            } else {
                addNewrow();
            }
        }
        function addNewrow() {

            var table = document.getElementById("data-table");
            var newRow = table.insertRow(table.rows.length);
            newRow.style.backgroundColor = "#d5ffe8"; // Add background color

            var TestSelect = $('#test_for'); // Get the select element
            var selectedOption = TestSelect.find('option:selected'); // Get the selected option

            var test_typeValue = selectedOption.val(); // Get the value of the selected option
            var test_typeText = selectedOption.text(); // Get the text of the selected option

            var grp_cdValue = $('#grp_cd').val();
            var testValue = $('#test').val();
            var seq_noValue = $('#seq_no').val();
            var commentsValue = $('#comments').val();
            var unitValue = $('#unit').val();
            var m_llValue = $('#m_ll').val();
            var m_ulValue = $('#m_ul').val();
            var f_llValue = $('#f_ll').val();
            var f_ulValue = $('#f_ul').val();
            var c_ulValue = $('#c_ul').val();
            var c_llValue = $('#c_ll').val();

            var methodeValue = $('#methode').val();
            var instrument_usedValue = $('#ins_used').val();
            var liscdValue = $('#liscd').val();
            var formulaValue = $('#formula').val();

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);
            var cell7 = newRow.insertCell(6);
            var cell8 = newRow.insertCell(7);
            var cell9 = newRow.insertCell(8);
            var cell10 = newRow.insertCell(9);
            var cell11 = newRow.insertCell(10);
            var cell12 = newRow.insertCell(11);
            var cell13 = newRow.insertCell(12);
            var cell14 = newRow.insertCell(13);
            var cell15 = newRow.insertCell(14);
            var cell16 = newRow.insertCell(15);
            var cell17 = newRow.insertCell(16);
            var cell18 = newRow.insertCell(17);


            var selectHTML =
                '<select class="form-control" style="background-color: #e9e9eb;" name="test_for[]"><option value="' +
                test_typeValue + '">' + test_typeText + '</option></select>';
            cell1.innerHTML = selectHTML;

            var inputHTML1 = '<input type="text" name="grp_cd[]" readonly class="form-control" value="' + grp_cdValue +
            '">';
            cell2.innerHTML = inputHTML1;

            var inputHTML2 = '<input type="text" name="test[]" readonly class="form-control" value="' + testValue + '">';
            cell3.innerHTML = inputHTML2;

            var inputHTML3 = '<input type="number" name="seq_no[]" readonly class="form-control" value="' + seq_noValue +
            '">';
            cell4.innerHTML = inputHTML3;

            var blankCellHTML = ''; // Leave the cell blank
            cell5.innerHTML = blankCellHTML; // Add the blank cell after "Rate"

            var inputHTML4 = '<input type="text" name="comments[]" readonly class="form-control" value="' + commentsValue +
                '">';
            cell6.innerHTML = inputHTML4;

            var inputHTML5 = '<input type="text" name="unit[]" readonly class="form-control" value="' + unitValue + '">';
            cell7.innerHTML = inputHTML5;

            var inputHTML6 = '<input type="text" name="m_ll[]" readonly class="form-control" value="' + m_llValue + '">';
            cell8.innerHTML = inputHTML6;

            var inputHTML7 = '<input type="text" name="m_ul[]" readonly class="form-control" value="' + m_ulValue + '">';
            cell9.innerHTML = inputHTML7;

            var inputHTML8 = '<input type="text" name="f_ll[]" readonly class="form-control" value="' + f_llValue + '">';
            cell10.innerHTML = inputHTML8;

            var inputHTML9 = '<input type="text" name="f_ul[]" readonly class="form-control" value="' + f_ulValue + '">';
            cell11.innerHTML = inputHTML9;

            var inputHTML10 = '<input type="text" name="c_ll[]" readonly class="form-control" value="' + c_llValue + '">';
            cell12.innerHTML = inputHTML10;

            var inputHTML11 = '<input type="text" name="c_ul[]" readonly class="form-control" value="' + c_ulValue + '">';
            cell13.innerHTML = inputHTML11;

            var inputHTML12 = '<input type="text" name="methode[]" readonly class="form-control" value="' + methodeValue +
                '">';
            cell14.innerHTML = inputHTML12;

            var inputHTML13 = '<input type="text" name="ins_used[]" readonly class="form-control" value="' +
                instrument_usedValue + '">';
            cell15.innerHTML = inputHTML13;

            var inputHTML14 = '<input type="text" name="liscd[]" readonly class="form-control" value="' + liscdValue + '">';
            cell16.innerHTML = inputHTML14;

            var inputHTML15 = '<input type="text" name="formula[]" readonly class="form-control" value="' + formulaValue +
                '">';
            cell17.innerHTML = inputHTML15;


            var inputHTML16 =
                '<button type="button" class="btn btn-danger btn-sm" style="margin: 2px 0px 0px 17px;" onclick="removeRow(this)">X</button>';
            cell18.innerHTML = inputHTML16;

            const selectElement = document.getElementById("test_for");
            selectElement.selectedIndex = 0; // Reset the selected index
            $('#test_for').val('').trigger('change');

            $('#grp_cd').val('');
            $('#test').val('');
            $('#seq_no').val('');
            $('#comments').val('');
            $('#unit').val('');
            $('#m_ll').val('');
            $('#m_ul').val('');
            $('#f_ll').val('');
            $('#f_ul').val('');
            $('#c_ul').val('');
            $('#c_ll').val('');

            $('#methode').val('');
            $('#ins_used').val('');
            $('#liscd').val('');
            $('#formula').val('');
        }
        function removeRow(button) {
            var table = document.getElementById("data-table");
            var row = button.parentNode.parentNode;
            table.deleteRow(row.rowIndex);
        }
        function getCategory(parent_id, subid = 0) {
            if (parent_id) {
                $.ajax({
                    url: "{{Route('get-sub-category')}}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        parent_id: parent_id,
                    },
                    success: function(response) {
                        if (response.success && (response.category.length > 0)) {
                            $.each(response.category, function(key, value) {
                                $('#sub_category_id').append(`<option value="${value.id}" ${subid == value.id ? 'selected' : ''}>${value.charges_catagories_name}</option>`);
                            });
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }
    </script>
@endpush
