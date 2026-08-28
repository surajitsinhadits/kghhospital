@extends('layouts.structure')
@push('title')
    <title>Manage Orders</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">
                        Manage Orders
                    </h4>
                </div>
                <div class="card-body p-0" style="margin-bottom: 32px;">
                    <div class="row">
                        <div class="col-md-8 py-1 pl-2">
                            <div class="cardmain_innerdashboardareanew" style="min-height: 80vh;background-color: #049df81f">
                                <h5 class="cardinnerhdng_textdesign">CANTEEN ORDERS</h5>
                                <form id="filterForm" method="POST" action="{{ route('kt.save-orders') }}">
                                    @csrf
                                    <div class="whitebackground">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="form-group align-items-center">
                                                    <div class="row p-0 m-0">
                                                        <div class="col-auto col-md-12">
                                                            <label class="sr-only" for="name">Name</label>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text" style="width: 150px;">Name
                                                                        <span class="text-danger">*</span>
                                                                    </div>
                                                                </div>
                                                                <input type="text" class="form-control" id="name"
                                                                    name="name" tabindex="1" required>
                                                            </div>
                                                            @error('name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-auto col-md-7">
                                                            <label class="sr-only" for="phone">Mobile</label>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text" style="width: 90px;">
                                                                        Mobile</div>
                                                                </div>
                                                                <input type="text" class="form-control" id="phone"
                                                                    name="phone" tabindex="2">
                                                            </div>
                                                            @error('phone')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-auto col-md-5">
                                                            <label class="sr-only" for="sub_total">Sub Total</label>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text" style="width: 100px;">Sub
                                                                        Total <span class="text-danger">*</span></div>
                                                                </div>
                                                                <input type="text" class="form-control" id="sub_total"
                                                                    name="sub_total" readonly>
                                                            </div>
                                                            @error('sub_total')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-auto col-md-6">
                                                            <label class="sr-only" for="gst">GST</label>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text" style="width: 100px;">GST
                                                                    </div>
                                                                </div>
                                                                <input type="number" class="form-control" id="gst"
                                                                    name="gst" tabindex="3" onkeyup="Caluculate()">
                                                                <div class="input-group-prepend" style="width: 50px">
                                                                    <div class="input-group-text" style="width: 100px;">%
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto col-md-6">
                                                            <label class="sr-only" for="discount">Discount</label>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text" style="width: 100px;">
                                                                        Discount</div>
                                                                </div>
                                                                <input type="number" class="form-control" id="discount"
                                                                    name="discount" tabindex="4" onkeyup="Caluculate()">
                                                                <div class="input-group-prepend" style="width: 70px;">
                                                                    <div class="w-100">
                                                                        <select name="discount_type" id="discount_type"
                                                                            class="form-control" style="margin-top: 3px;"
                                                                            onchange="Caluculate()">
                                                                            <option value="percentage">%</option>
                                                                            <option value="flat">RS</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto col-md-6">
                                                            <label class="sr-only" for="total">Total</label>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text" style="width: 100px;">
                                                                        Total <span class="text-danger">*</span></div>
                                                                </div>
                                                                <input type="text" class="form-control" id="total"
                                                                    name="total" readonly>
                                                            </div>
                                                            @error('total')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-auto col-md-6">
                                                            <label class="sr-only" for="payment">Payment</label>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text" style="width: 100px;">
                                                                        Payment <span class="text-danger">*</span></div>
                                                                </div>
                                                                <input type="number" class="form-control" id="payment"
                                                                    name="payment" tabindex="5" required>
                                                            </div>
                                                            @error('payment')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-12 text-conter mt-2">
                                                            <button type="submit" id="submitBtn"
                                                                class="btn btn-primary px-4 mr-2"></i> Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <table class="table card-table table-vcenter text-nowrap border"
                                                    id="data-table">
                                                    <thead class="bg-primary text-white">
                                                        <tr>
                                                            <th class="text-white" style="width: 50%">Meal <span
                                                                    class="text-danger">*</span></th>
                                                            <th class="text-white" style="width: 20%">Qty <span
                                                                    class="text-danger">*</span></th>
                                                            <th class="text-white" style="width: 20%">Rate <span
                                                                    class="text-danger">*</span></th>
                                                            <th class="text-white" style="width: 10%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="chargeTable">
                                                        <tr>
                                                            <td>
                                                                <select class="form-control select2-show-search meal"
                                                                    name="meal"
                                                                    onchange="getMealDetails(this.value, this)">
                                                                    <option value="">Select Meal</option>
                                                                    @foreach ($meals as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->meal_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control qty" type="text"
                                                                    name="qty" id="i_qty" value="0"
                                                                    onkeyup="qtyUpdate(this)" />
                                                            </td>
                                                            <td>
                                                                <input class="form-control rate" type="text"
                                                                    name="rate" id="i_rate" value="0"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-success btn-sm" type="button"
                                                                    onclick="validation()">+</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Meal</th>
                                            <th>Sub Total</th>
                                            <th>GST</th>
                                            <th>Discount</th>
                                            <th>Total</th>
                                            <th>Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ dateFor($item->date) }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    @foreach ($item->meals as $it)
                                                        <span
                                                            class="badge badge-gradient-primary mr-1">{{ $it }}</span>
                                                    @endforeach
                                                </td>
                                                <td>{{ $item->sub_total }}</td>
                                                <td>{{ $item->gst_amount }}</td>
                                                <td>{{ $item->discount_amount }}</td>
                                                <td>{{ $item->total }}</td>
                                                <td>{!! $item->total_due > 0
                                                    ? '<a  href="' .
                                                        route('kt.due-collection', ed($item->id, true)) .
                                                        '" onclick="return confirm(\'Are you sure you want to collect this due?\')"><span class="badge badge-gradient-danger mr-1">Due : ' .
                                                        $item->total_due .
                                                        '</span></a>'
                                                    : '<span class="badge badge-gradient-success">Done</span>' !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4 py-1 pr-2">
                            <div class="cardmain_innerdashboardareanew1" style="height: 80vh;background-color: #f5dc4f57">
                                <h5 class="cardinnerhdng_textdesign">ONLINE ORDERS</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Meals</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        function getMealDetails(meal_id, element) {
            if (meal_id) {
                $.ajax({
                    url: "{{ route('kt.meal-price') }}",
                    type: "POST",
                    data: {
                        mealId: meal_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status) {
                            let row = $(element).closest('tr');
                            row.find('.qty').val(1);
                            row.find('.rate').val(res.meal_price || 0);
                        }
                    },
                    error: function() {
                        let row = $(element).closest('tr');
                        row.find('.rate').val(0);
                    }
                });
            } else {
                row.find('.qty').val(0);
                row.find('.rate').val(0);
            }
        }

        function Caluculate() {
            var rate = 0;
            var t_m = 0;
            var t_g = 0;
            var t_d = 0;
            $("input[name='rate[]']").each(function() {
                rate += parseFloat($(this).val()) || 0;
            });

            var discount = $('#discount').val() || 0;
            var discountType = $('#discount_type').val();
            if (discount > 0) {
                if (discountType === 'percentage') {
                    t_d = (rate * (parseFloat(discount) / 100));
                } else {
                    t_d = parseFloat(discount);
                }
            }

            var gst = $('#gst').val() || 0;
            if (gst > 0) {
                t_g = ((rate - t_d) * (parseFloat(gst) / 100));
            }

            t_m = rate + t_g - t_d;
            $('#sub_total').val(rate);
            $('#total').val(t_m);
            $('#payment').val(t_m);
        }

        function validation() {
            var itemSelect = $('#chargeTable').find('tr:first .meal').val();
            if (itemSelect === '') {
                alert('Please Select a Meal!');
            } else {
                addNewrow();
            }
        }

        function addNewrow() {
            let firstRow = $('#chargeTable').find('tr:first');
            let meal_id = firstRow.find('.meal').val();
            let meal_text = firstRow.find('.meal option:selected').text();
            let qty = firstRow.find('.qty').val();
            let rate = firstRow.find('.rate').val();

            let newRow = `
            <tr>
                <td>
                    <select class="form-control" name="meal[]">
                        <option value="${meal_id}" selected>${meal_text}</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="qty[]" class="form-control" readonly value="${qty}">
                </td>
                <td>
                    <input type="text" name="rate[]" class="form-control" readonly value="${rate}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>
                </td>
            </tr>
        `;
            $('#chargeTable').append(newRow);
            Caluculate();

            // Reset first row
            firstRow.find('.meal').val('').trigger('change');
            firstRow.find('.i_qty').val(0);
            firstRow.find('.rate').val(0);
        }

        function qtyUpdate(e) {
            var i_rate = $('#i_rate').val();
            $('#i_rate').val(e.value * i_rate);
        }

        function removeRow(button) {
            let row = button.closest('tr');
            row.remove();
        }
    </script>

    <script>
        $(document).ready(function() {
            // Utility: Show error (toastr if available, else alert)
            function showError(msg) {
                if (typeof toastr !== 'undefined') {
                    toastr.error(msg);
                } else {
                    alert(msg);
                }
            }

            // Restrict name to alphabets and spaces only
            $('#name').on('input', function() {
                this.value = this.value.replace(/[^A-Za-z\s]/g, '');
            });

            // Restrict phone to digits only, max 10 digits
            $('#phone').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
            });

            // Restrict GST, Discount, Payment to numbers and one dot
            $('#gst, #discount, #payment').on('input', function() {
                this.value = this.value.replace(/[^0-9.]/g, '');
                let parts = this.value.split('.');
                if (parts.length > 2) {
                    this.value = parts[0] + '.' + parts.slice(1).join('');
                }
            });

            // Live validation function
            function validateForm(showToastr = false) {
                let valid = true;

                // Remove previous error highlights
                $('#filterForm input, #filterForm select').removeClass('border-danger border-primary').css(
                    'border-color', '');

                // Name: required, alphabets and spaces only
                let $name = $('#name');
                let nameVal = $name.val().trim();
                if (!nameVal) {
                    if (showToastr) showError('Name is required.');
                    $name.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else if (!/^[A-Za-z\s]+$/.test(nameVal)) {
                    if (showToastr) showError('Name can only contain alphabets and spaces.');
                    $name.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else {
                    $name.removeClass('border-danger').addClass('border-primary').css('border-color', '#007bff');
                }

                // Phone: optional, but if filled must be exactly 10 digits
                let $phone = $('#phone');
                let phoneVal = $phone.val().trim();
                if (phoneVal && !/^\d{10}$/.test(phoneVal)) {
                    if (showToastr) showError('Phone number must be exactly 10 digits.');
                    $phone.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else if (phoneVal) {
                    $phone.removeClass('border-danger').addClass('border-primary').css('border-color', '#007bff');
                }

                // Sub Total: required, must be a number >= 0
                let $sub_total = $('#sub_total');
                let subTotalVal = $sub_total.val().trim();
                if (!subTotalVal || isNaN(subTotalVal) || Number(subTotalVal) < 0) {
                    if (showToastr) showError('Sub Total is required and must be a valid number.');
                    $sub_total.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else {
                    $sub_total.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }

                // GST: optional, must be a number >= 0
                let $gst = $('#gst');
                let gstVal = $gst.val().trim();
                if (gstVal && (isNaN(gstVal) || Number(gstVal) < 0)) {
                    if (showToastr) showError('GST must be a valid non-negative number.');
                    $gst.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else if (gstVal) {
                    $gst.removeClass('border-danger').addClass('border-primary').css('border-color', '#007bff');
                }

                // Discount: optional, must be a number >= 0
                let $discount = $('#discount');
                let discountVal = $discount.val().trim();
                if (discountVal && (isNaN(discountVal) || Number(discountVal) < 0)) {
                    if (showToastr) showError('Discount must be a valid non-negative number.');
                    $discount.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else if (discountVal) {
                    $discount.removeClass('border-danger').addClass('border-primary').css('border-color',
                    '#007bff');
                }

                // Total: required, must be a number >= 0
                let $total = $('#total');
                let totalVal = $total.val().trim();
                if (!totalVal || isNaN(totalVal) || Number(totalVal) < 0) {
                    if (showToastr) showError('Total is required and must be a valid number.');
                    $total.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else {
                    $total.removeClass('border-danger').addClass('border-primary').css('border-color', '#007bff');
                }

                // Payment: required, must be a number >= 0
                let $payment = $('#payment');
                let paymentVal = $payment.val().trim();
                if (!paymentVal || isNaN(paymentVal) || Number(paymentVal) < 0) {
                    if (showToastr) showError('Payment is required and must be a valid number.');
                    $payment.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else {
                    $payment.removeClass('border-danger').addClass('border-primary').css('border-color', '#007bff');
                }

                // Meal Table: at least one meal row required
                let mealRows = 0;
                $('#chargeTable tr').each(function() {
                    let $mealSelect = $(this).find('select[name="meal"], select[name="meal[]"], .meal');
                    let $qty = $(this).find('input[name="qty"], input[name="qty[]"], .qty');
                    let $rate = $(this).find('input[name="rate"], input[name="rate[]"], .rate');
                    if ($mealSelect.length && $mealSelect.val() && $mealSelect.val() !== '') {
                        mealRows++;
                        // Qty: required, number > 0
                        if (!$qty.val() || isNaN($qty.val()) || Number($qty.val()) <= 0) {
                            if (showToastr) showError(
                            'Quantity is required and must be a positive number.');
                            $qty.addClass('border-danger').css('border-color', '#dc3545');
                            valid = false;
                        } else {
                            $qty.removeClass('border-danger').addClass('border-primary').css('border-color',
                                '#007bff');
                        }
                        // Rate: required, number >= 0
                        if (!$rate.val() || isNaN($rate.val()) || Number($rate.val()) < 0) {
                            if (showToastr) showError(
                            'Rate is required and must be a non-negative number.');
                            $rate.addClass('border-danger').css('border-color', '#dc3545');
                            valid = false;
                        } else {
                            $rate.removeClass('border-danger').addClass('border-primary').css(
                                'border-color', '#007bff');
                        }
                    }
                });
                if (mealRows === 0) {
                    if (showToastr) showError('Please add at least one meal.');
                    $('#chargeTable .meal').first().addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                }

                return valid;
            }

            // Live validation on input/change for all relevant fields
            $('#name, #phone, #sub_total, #gst, #discount, #total, #payment').on('input change keyup', function() {
                validateForm(false);
            });
            $(document).on('input change keyup', '#chargeTable select, #chargeTable input', function() {
                validateForm(false);
            });

            // On submit, show toastr for first error and prevent submit if invalid
            $('#filterForm').on('submit', function(e) {
                if (!validateForm(true)) {
                    e.preventDefault();
                    // Focus first invalid field
                    let $firstInvalid = $('#filterForm .border-danger:visible').first();
                    if ($firstInvalid.length) $firstInvalid.focus();
                }
            });

            // Remove error highlight on input/change if valid
            $('#filterForm input, #filterForm select').on('input change', function() {
                if (!$(this).hasClass('border-danger')) return;
                validateForm(false);
            });
        });
        $(document).ready(function() {
            // Utility: Show error (toastr if available, else alert)
            function showError(msg) {
                if (typeof toastr !== 'undefined') {
                    toastr.error(msg);
                } else {
                    alert(msg);
                }
            }

            // Restrict name to alphabets and spaces only
            $('#name').on('input', function() {
                this.value = this.value.replace(/[^A-Za-z\s]/g, '');
            });

            // Restrict phone to digits only, max 10 digits
            $('#phone').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
            });

            // Restrict GST, Discount, Payment to numbers and one dot
            $('#gst, #discount, #payment').on('input', function() {
                this.value = this.value.replace(/[^0-9.]/g, '');
                let parts = this.value.split('.');
                if (parts.length > 2) {
                    this.value = parts[0] + '.' + parts.slice(1).join('');
                }
            });

            // Live validation function
            function validateForm(showToastr = false) {
                let valid = true;

                // Remove previous error highlights
                $('#filterForm input, #filterForm select').removeClass('border-danger border-primary').css(
                    'border-color', '');

                // Name: required, alphabets and spaces only
                let $name = $('#name');
                let nameVal = $name.val().trim();
                if (!nameVal) {
                    if (showToastr) showError('Name is required.');
                    $name.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else if (!/^[A-Za-z\s]+$/.test(nameVal)) {
                    if (showToastr) showError('Name can only contain alphabets and spaces.');
                    $name.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else {
                    $name.removeClass('border-danger').addClass('border-primary').css('border-color', '#007bff');
                }

                // Phone: optional, but if filled must be exactly 10 digits
                let $phone = $('#phone');
                let phoneVal = $phone.val().trim();
                if (phoneVal && !/^\d{10}$/.test(phoneVal)) {
                    if (showToastr) showError('Phone number must be exactly 10 digits.');
                    $phone.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else if (phoneVal) {
                    $phone.removeClass('border-danger').addClass('border-primary').css('border-color', '#007bff');
                }

                // Sub Total: required, must be a number >= 0
                let $sub_total = $('#sub_total');
                let subTotalVal = $sub_total.val().trim();
                if (!subTotalVal || isNaN(subTotalVal) || Number(subTotalVal) < 0) {
                    if (showToastr) showError('Sub Total is required and must be a valid number.');
                    $sub_total.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else {
                    $sub_total.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }

                // GST: optional, must be a number >= 0
                let $gst = $('#gst');
                let gstVal = $gst.val().trim();
                if (gstVal && (isNaN(gstVal) || Number(gstVal) < 0)) {
                    if (showToastr) showError('GST must be a valid non-negative number.');
                    $gst.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else if (gstVal) {
                    $gst.removeClass('border-danger').addClass('border-primary').css('border-color', '#007bff');
                }

                // Discount: optional, must be a number >= 0
                let $discount = $('#discount');
                let discountVal = $discount.val().trim();
                if (discountVal && (isNaN(discountVal) || Number(discountVal) < 0)) {
                    if (showToastr) showError('Discount must be a valid non-negative number.');
                    $discount.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else if (discountVal) {
                    $discount.removeClass('border-danger').addClass('border-primary').css('border-color',
                    '#007bff');
                }

                // Total: required, must be a number >= 0
                let $total = $('#total');
                let totalVal = $total.val().trim();
                if (!totalVal || isNaN(totalVal) || Number(totalVal) < 0) {
                    if (showToastr) showError('Total is required and must be a valid number.');
                    $total.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else {
                    $total.removeClass('border-danger').addClass('border-primary').css('border-color', '#007bff');
                }

                // Payment: required, must be a number >= 0
                let $payment = $('#payment');
                let paymentVal = $payment.val().trim();
                if (!paymentVal || isNaN(paymentVal) || Number(paymentVal) < 0) {
                    if (showToastr) showError('Payment is required and must be a valid number.');
                    $payment.addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                } else {
                    $payment.removeClass('border-danger').addClass('border-primary').css('border-color', '#007bff');
                }

                // Meal Table: at least one meal row required
                let mealRows = 0;
                $('#chargeTable tr').each(function() {
                    let $mealSelect = $(this).find('select[name="meal"], select[name="meal[]"], .meal');
                    let $qty = $(this).find('input[name="qty"], input[name="qty[]"], .qty');
                    let $rate = $(this).find('input[name="rate"], input[name="rate[]"], .rate');
                    if ($mealSelect.length && $mealSelect.val() && $mealSelect.val() !== '') {
                        mealRows++;
                        // Qty: required, number > 0
                        if (!$qty.val() || isNaN($qty.val()) || Number($qty.val()) <= 0) {
                            if (showToastr) showError(
                            'Quantity is required and must be a positive number.');
                            $qty.addClass('border-danger').css('border-color', '#dc3545');
                            valid = false;
                        } else {
                            $qty.removeClass('border-danger').addClass('border-primary').css('border-color',
                                '#007bff');
                        }
                        // Rate: required, number >= 0
                        if (!$rate.val() || isNaN($rate.val()) || Number($rate.val()) < 0) {
                            if (showToastr) showError(
                            'Rate is required and must be a non-negative number.');
                            $rate.addClass('border-danger').css('border-color', '#dc3545');
                            valid = false;
                        } else {
                            $rate.removeClass('border-danger').addClass('border-primary').css(
                                'border-color', '#007bff');
                        }
                    }
                });
                if (mealRows === 0) {
                    if (showToastr) showError('Please add at least one meal.');
                    $('#chargeTable .meal').first().addClass('border-danger').css('border-color', '#dc3545');
                    valid = false;
                }

                return valid;
            }

            // Live validation on input/change for all relevant fields
            $('#name, #phone, #sub_total, #gst, #discount, #total, #payment').on('input change keyup', function() {
                validateForm(false);
            });
            $(document).on('input change keyup', '#chargeTable select, #chargeTable input', function() {
                validateForm(false);
            });

            // On submit, show toastr for first error and prevent submit if invalid
            $('#filterForm').on('submit', function(e) {
                if (!validateForm(true)) {
                    e.preventDefault();
                    // Focus first invalid field
                    let $firstInvalid = $('#filterForm .border-danger:visible').first();
                    if ($firstInvalid.length) $firstInvalid.focus();
                }
            });

            // Remove error highlight on input/change if valid
            $('#filterForm input, #filterForm select').on('input change', function() {
                if (!$(this).hasClass('border-danger')) return;
                validateForm(false);
            });
        });
    </script>
@endpush
