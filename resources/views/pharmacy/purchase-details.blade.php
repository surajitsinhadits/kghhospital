@extends('layouts.structure')
@push('title')
    <title>Purchase Details</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-block card_hearder_mimi">
                        <div class="row">
                            <div class="col-md-6 card-title card_hearder_mimi_text">
                                <h4 class="card-title">PURCHASE DETAILS </h4>
                            </div>
                            <div class="col-md-6 card-title card_hearder_mimi_text text-right">
                            @if ($purchase->is_updated_in_stock == 0)
                                <a onclick="confirmUpdate('{{ route('medicine-stock-update-from-purchase',ed($purchase->id, true)) }}')" class="btn btn-primary btn-sm" id="btn_update">Stock Update</a>
                            @endif
                        </div>
                        </div>
                    </div>
                    {{-- @include('message.notification') --}}

                    <div class="card-body" style="background-color:#c2e3b4">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row" style="font-size: 16px">
                                        <div class="col-md-3">
                                            <span>Purchase No : </span><span>{{ @$purchase->id }}
                                            </span>
                                        </div>
                                        <div class="col-md-3">
                                            <span>Purchase Date : </span><span>
                                                <?= date('d-m-Y h:i A', strtotime($purchase->date)) ?>
                                            </span>
                                        </div>
                                        <div class="col-md-3">
                                            <span>Purchase Created By :
                                            </span><span>{{ @$purchase->generated_by_name }}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span>Vendor : </span><span>{{ @$purchase->vendor_name }}
                                            </span>
                                        </div>
                                        <div class="col-md-3">
                                            <span>Total : </span><span>{{ @$purchase->total }}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span>CGST : </span><span>{{ @$purchase->total_cgst_amount }}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span>SGST : </span><span>{{ @$purchase->total_sgst_amount }}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span>Note : </span><span>{{ @$purchase->note }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table table-bordered text-nowrap key-buttons border-left border-right border-bottom">
                                <thead class="bg-primary text-white">
                                    <tr class="border-left">
                                        <th class="text-white" style="text-align: center;">Sl No. </th>
                                        <th class="text-white" style="text-align: center;">Medicine </th>
                                        <th class="text-white" style="text-align: center;">Qty </th>
                                        {{-- <th class="text-white" style="text-align: center;">Unit </th> --}}
                                        <th class="text-white" style="text-align: center;">Exp Date(d/m/Y) </th>
                                        <th class="text-white" style="text-align: center;">Batch No </th>
                                        <th class="text-white" style="text-align: center;">P. Rate/QTY(₹) </th>
                                        <th class="text-white" style="text-align: center;">S. Rate/QTY(₹) </th>
                                        <th class="text-white" style="text-align: center;">Net Amt.(₹) </th>
                                        <th class="text-white" style="text-align: center;">Dis(%) </th>
                                        <th class="text-white" style="text-align: center;">Dis(₹) </th>
                                        <th class="text-white" style="text-align: center;">CGST </th>
                                        <th class="text-white" style="text-align: center;">SGST </th>
                                        <th class="text-white" style="text-align: center;">IGST </th>
                                        <th class="text-white" style="text-align: center;">Amount(₹) </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($purchase_details) && $purchase_details != '')
                                        @foreach ($purchase_details as $value)
                                            <tr>
                                                <td scope="row">{{ $loop->iteration }}</td>
                                                <td style="text-align: center;">{{ @$value->medicine_name }}({{ @$value->medicine_catagory_name }})
                                                </td>
                                                <td>{{ @$value->unit_qty }} {{ @$value->unit }}
                                                    {{ @$value->sub_unit_qty }} {{ @$value->sub_unit }}</td>
                                                {{-- <td>{{ @$value->unit }}</td> --}}
                                                <td style="text-align: center;">{{ date('d/m/Y', strtotime($value->expiry_date)) }}</td>
                                                <td style="text-align: center;">{{ @$value->batch_no }}</td>
                                                <td style="text-align: center;">{{ @$value->rate }}</td>
                                                <td style="text-align: center;">{{ @$value->mrp }}</td>
                                                <td style="text-align: center;">{{ @$value->net_amount }}</td>
                                                <td style="text-align: center;">{{ @$value->discount_amount }}</td>
                                                <td style="text-align: center;">{{ @$value->discount_per }}</td>
                                                <td style="text-align: center;">{{ @$value->cgst }}</td>
                                                <td style="text-align: center;">{{ @$value->sgst }}</td>
                                                <td style="text-align: center;">{{ @$value->igst }}</td>
                                                <td style="text-align: center;">{{ @$value->amount }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <h3 style="text-align: center;">Free Medicine Details</h3>

                            <table
                                class="table table-bordered text-nowrap key-buttons border-left border-right border-bottom">
                                <thead class="bg-primary text-white">
                                    <tr class="border-left">
                                        <th class="text-white" style="text-align: center;">Sl No. </th>
                                        <th class="text-white" style="text-align: center;">Medicine </th>
                                        <th class="text-white" style="text-align: center;">Qty </th>
                                        {{-- <th class="text-white" style="text-align: center;">Unit </th> --}}
                                        <th class="text-white" style="text-align: center;">Exp Date(d/m/Y) </th>
                                        <th class="text-white" style="text-align: center;">Batch No </th>
                                        <th class="text-white" style="text-align: center;">S. Rate/QTY(₹) </th>
                                        <th class="text-white" style="text-align: center;">P. Rate/QTY(₹) </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($free_purchase_details) && $free_purchase_details != '')
                                        @foreach ($free_purchase_details as $value)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td style="text-align: center;">{{ @$value->medicine_name }}({{ @$value->medicine_catagory_name }})
                                                </td>
                                                <td style="text-align: center;">{{ @$value->qty }} {{ @$value->unit }}</td>
                                                {{-- <td style="text-align: center;">{{ @$value->unit }}</td> --}}
                                                <td style="text-align: center;">{{ date('d/m/Y', strtotime($value->expiry_date)) }}</td>
                                                <td style="text-align: center;">{{ @$value->batch_no }}</td>
                                                <td style="text-align: center;">{{ @$value->mrp }}</td>
                                                <td style="text-align: center;">{{ @$value->rate }}</td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- bd -->
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
@push('js')
    <script>
        function confirmUpdate(updateUrl) {
            var isConfirmed = confirm(
                "Are you sure you want to Update this Purchase medicine in Stock and If You Update this stock then you can not update this Purchase Before update Stock Please check all !!"
            );
            if (isConfirmed) {
                $('#btn_update').disabled = true;
                window.location.href = updateUrl;
            } else {

            }
        }
    </script>
@endpush
