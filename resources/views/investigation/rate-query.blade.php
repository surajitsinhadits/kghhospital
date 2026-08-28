@extends('layouts.structure')
@push('title')
    <title>RATE QUERY ?</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="card">
        <div class="card-header card_hearder_mimi justify-content-between">
            <h4 class="card-title card_hearder_mimi_text">
                RATE QUERY ?
            </h4>
        </div>
        <div class="mt-3">
            <form method="POST" action="{{ route('investigation.print-clear-page') }}">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered border-left border-bottom border-right" id="data-table" style="width: 98%;margin-left:1%;">
                        <thead class="bg-primary">
                            <tr>
                                <th scope="col" style="width: 44%" class="text-white">Charge Name <span class="text-danger">*</span></th>
                                <th scope="col" style="width: 10%" class="text-white">Rate(₹) <span class="text-danger">*</span></th>
                                <th scope="col" style="width: 2%" class="text-white">#</th>
                                <th scope="col" style="width: 10%" class="text-white">Qty <span class="text-danger">*</span></th>
                                <th scope="col" style="width: 10%" class="text-white">Dis(%) <span class="text-danger">*</span></th>
                                <th scope="col" style="width: 10%" class="text-white">Dis Amount(₹) <span class="text-danger">*</span></th>
                                <th scope="col" style="width: 10%" class="text-white">Amount(₹) <span class="text-danger">*</span></th>
                                <th scope="col" style="width: 2%" class="text-white"></th>
                            </tr>
                        </thead>
                        <tbody id="chargeTable">
                            <tr id="row">
                                <td>
                                    <select class="form-control select2-show-search" id="charge_name" onchange="getRateByCharge(this)" tabindex="13">
                                        <option value="">Select</option>
                                        @foreach ($charges as $ch)
                                        <option value="{{$ch->charge_name}}" data-amount="{{$ch->charge_amount}}">{{$ch->charge_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" name="" id="rate" onkeyup="updateCalculations('')" value="0" />
                                </td>
                                <td>
                                    <button class="btn btn-success btn-sm" id="myInputbtn" tabindex="14" onclick="validation()" type="button"><i class="fa fa-plus"></i></button>
                                </td>
                                <td>
                                    <input class="form-control" id="qty" onkeyup="updateCalculations('')" value="1" />
                                </td>
                                <td>
                                    <input class="form-control" onkeyup="updateCalculations('')" id="discount_in_per" value="0" />
                                </td>
                                <td>
                                    <input class="form-control" onkeyup="updateCalculations('')" id="discount_amount" value="0" />
                                </td>
                                <td>
                                    <input class="form-control" id="amount" value="0" />
                                </td>
                                <td>
                                    <button class="btn btn-success btn-sm" id="buttonId" onclick="validation()" type="button"><i class="fa fa-plus"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @error('charge_name')
                    <span class="text-danger ml-4">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row" style="border: 1px solid #ebecf1;margin-left: 17px;margin-right: 10px;margin-bottom: 10px;">
                    <div class="col-md-6">

                    </div>
                    <div class="col-md-6">
                        <div class="options px-1 pt-1 pb-1">
                            <div class="container mt-5">
                                <div class="d-flex justify-content-end">
                                    <span class="biltext">Total</span>
                                    <input type="text" value="" name="total" readonly id="total_am" class="form-control myfld" style="width: 170px;">
                                </div>
                                <div class="d-flex justify-content-end mt-2" id="discount_section">
                                    <span class="biltext">Dis.(%/Rs)</span>
                                    <input type="text" name="total_discount" onkeyup="gettotal()" value="0" id="total_discount" class="form-control myfld" style="width: 101px;">
                                    <select name="discount_type" onchange="gettotal()" id="discount_type" class="form-control myfld" style="width: 75px">
                                        <option value="flat" selected>Rs.</option>
                                        <option value="percentage">%</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-end thrdarea">
                                    <span class="biltext">G. Total</span>
                                    <input type="text" name="grand_total" readonly id="grnd_total" value="" class="form-control myfld" style="width: 170px;">
                                    @error('grand_total')
                                    <br><span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" type="button" onclick="reloadPage()"><i class="fa fa-file text-success"></i> Clear</button>
                    <button class="btn btn-primary btn-sm" type="submit" name="save" value="print"><i class="fa fa-print text-danger"></i> Print</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    function reloadPage(){
        location.reload(true);
    }
     function validation() {
        var chargeSelect = $('#charge_name'); // Get the select element
        var selectedOption = chargeSelect.find('option:selected'); // Get the selected option
        var chargeValue = selectedOption.val(); // Get the value of the selected option
        var chargeText = selectedOption.text(); // Get the text of the selected option
        var rateValue = $('#rate').val(); // Get value from rate input
        var qtyValue = $('#qty').val(); // Get value from qty input

        if (qtyValue == '') {
            toastr.error("Please Enter QTY !!!");
        } else if (rateValue == '') {
            toastr.error("Please Enter Rate !!!");
        } else if (chargeValue == '') {
            toastr.error("Please Select Charge Name !!!");
        } else {
            addNewrow();
        }
    }

    function addNewrow() {
        var table = document.getElementById("data-table");
        var newRow = table.insertRow(table.rows.length);
        newRow.style.backgroundColor = "#d5ffe8"; // Add background color
        var table_id = table.rows.length;

        var chargeSelect = $('#charge_name'); // Get the select element
        var selectedOption = chargeSelect.find('option:selected'); // Get the selected option

        var chargeValue = selectedOption.val(); // Get the value of the selected option
        var chargeText = selectedOption.text(); // Get the text of the selected option

        var rateValue = $('#rate').val(); // Get value from rate input
        var qtyValue = $('#qty').val(); // Get value from qty input
        var discountInPerValue = $('#discount_in_per').val(); // Get value from discount_in_per input
        var discountAmountValue = $('#discount_amount').val(); // Get value from discount_amount input
        var amountValue = $('#amount').val(); // Get value from amount input

        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);
        var cell4 = newRow.insertCell(3);
        var cell5 = newRow.insertCell(4);
        var cell6 = newRow.insertCell(5);
        var cell7 = newRow.insertCell(6);
        var cell8 = newRow.insertCell(7);

        var selectHTML = '<select class="form-control" style="background-color: #e9e9eb;" name="charge_name[]"><option value="' + chargeValue + '">' + chargeText + '</option></select>';
        cell1.innerHTML = selectHTML;

        var inputHTML1 = '<input type="text" name="rate[]" onkeyup="updateCalculations('+table_id+')"  id="rate'+table_id+'"  class="form-control" value="' + rateValue + '">';
        cell2.innerHTML = inputHTML1;

        var blankCellHTML = ''; // Leave the cell blank
        cell3.innerHTML = blankCellHTML; // Add the blank cell after "Rate"

        var inputHTML2 = '<input type="text" name="qty[]" onkeyup="updateCalculations('+table_id+')" id="qty'+table_id+'"  class="form-control" value="' + qtyValue + '">';
        cell4.innerHTML = inputHTML2;

        var inputHTML3 = '<input type="text" name="discount_in_per[]" onkeyup="updateCalculations('+table_id+')" id="discount_in_per'+table_id+'"  class="form-control" value="' + discountInPerValue + '">';
        cell5.innerHTML = inputHTML3;

        var inputHTML4 = '<input type="text" name="discount_amount[]" onkeyup="updateCalculations('+table_id+')" id="discount_amount'+table_id+'"  class="form-control" value="' + discountAmountValue + '">';
        cell6.innerHTML = inputHTML4;

        var inputHTML5 = '<input type="text" name="amount[]" id="amount'+table_id+'" readonly class="form-control" readonly value="' + amountValue + '">';
        cell7.innerHTML = inputHTML5;

        var inputHTML6 = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
        cell8.innerHTML = inputHTML6;

        const selectElement = document.getElementById("charge_name");
        selectElement.selectedIndex = 0; // Reset the selected index
        $('#charge_name').val('').trigger('change');

        $('#rate').val(0); // Get value from rate input
        $('#qty').val(1); // Get value from qty input
        $('#discount_in_per').val(0); // Get value from discount_in_per input
        $('#discount_amount').val(0); // Get value from discount_amount input
        $('#amount').val(0); // Get value from amount input
        gettotal();
        $('#myInputbtn').prop('autofocus', false);
        $('#charge_name').prop('autofocus', true);

    }

    function removeRow(button) {
        var table = document.getElementById("data-table");
        var row = button.parentNode.parentNode;
        table.deleteRow(row.rowIndex);
        gettotal();
    }
    function getRateByCharge(selectElement) {
        let chargeAmount = selectElement.options[selectElement.selectedIndex].getAttribute("data-amount");
        $('#rate').val(chargeAmount == '' ? 0 : chargeAmount);
        updateCalculations('');
    }
    function updateCalculations(row_id) {
        const rateInput = $('#rate'+row_id).val();
        const qtyInput = $('#qty'+row_id).val();
        const discountInPerInput = $('#discount_in_per'+row_id).val();
        const discountAmountInput = $('#discount_amount'+row_id).val();
        var discountAmount = 0;
        const rate = parseFloat(rateInput);
        const qty = parseFloat(qtyInput);
        const discountInPer = parseFloat(discountInPerInput);
        const discountInAmount = parseFloat(discountAmountInput);

        if (discountInPer != 0 || discountInPer != '') {
            var discountAmount = (rate * qty * discountInPer) / 100;
        }

        if ((discountInPer == 0 || discountInPer == '') && (discountInAmount != 0 || discountInAmount != '')) {
            var discountAmount = discountInAmount;
        }
        const amount = (rate * qty) - parseFloat(discountAmount);
        $('#amount'+row_id).val(amount.toFixed(2));
        gettotal();
    }
    function gettotal() {
        var t = 0;
        var m = 0;
        var m_a = 0;
        $("input[name='amount[]']").each(function() {
            t += parseFloat($(this).val()) || 0;
        });

        var t_m = (parseFloat(t) + parseFloat(m_a));
        $('#total_am').val(t_m.toFixed(2));

        var total_discount = $('#total_discount').val() || 0;
        var discountType = $('#discount_type').val();

        var r;
        if (discountType === 'percentage') {
            r = t_m - (t_m * (parseFloat(total_discount) / 100));
        } else {
            r = t_m - parseFloat(total_discount);
        }

        var grnd_total = r;

        $('#grnd_total').val(parseInt(grnd_total));

    }

    function getDoctorCharges(doctor_id) {
        var div_data = '';
        if (doctor_id != '') {
            $.ajax({
                url: "{{ route('emg.find-doctor-charge-by-doctor') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    doctorId: doctor_id,
                },

                success: function(response) {
                    console.log(response);
                    if ((response != '')) {
                        $('#charge_name').val(response.charge_details_id).trigger('change');
                        $('#rate').val(response.charge_amount_details);
                        $('#amount').val(response.charge_amount_details);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        gettotal();
    }
</script>
@endpush
