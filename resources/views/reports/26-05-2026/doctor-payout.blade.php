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
                <div class="card-title card_hearder_mimi_text"> {{ $title }} Report</div>
            </div>
            <div class="card-body p-0">
                <div class="col-md-12 border-right">
                    <form method="POST" action="{{ $action }}">
                        @csrf
                        <div class="whitebackground">
                            <div class="row ">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select name="section" id="section" class="form-control">
                                            @foreach (['OPD'] as $sec)
                                                <option value="{{ $sec }}"
                                                    {{ @$request_data['section'] == $sec ? 'selected' : '' }}>
                                                    {{ $sec }}</option>
                                            @endforeach
                                        </select>
                                        @error('section')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select name="doctor[]" id="doctor" class="form-control select2-show-search"
                                            multiple>
                                            <option value="">Select Doctor</option>
                                            @foreach ($doctors as $doc)
                                                <option value="{{ $doc->charge_id }}"
                                                    @if (count($request_data['doctor']) < 5) {{ in_array($doc->charge_id, $request_data['doctor']) ? 'selected' : '' }} @endif>
                                                    Dr. {{ $doc->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('doctor')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control datePickr"
                                            value="{{ dateFor(@$request_data['from_date']) }}" id="fromDate"
                                            name="from_date" placeholder="Choose From Date">
                                        @error('from_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control datePickr"
                                            value="{{ dateFor(@$request_data['to_date']) }}" id="toDate" name="to_date"
                                            placeholder="Choose To Date">
                                        @error('to_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group d-flex">
                                        <button type="submit" class="btn btn-primary px-3 mr-2"><i
                                                class="fas fa-search"></i> Search</button>
                                        <a href="{{ $action }}" class="btn btn-warning px-3 mr-2"><i
                                                class="fas fa-history"></i> Reset</a>
                                        <button type="button" onclick="window.print()" class="btn btn-info px-3"><i
                                                class="fas fa-print"></i> Print</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END GRAPHS SECTION -->
            <div class="whitebackground">
                <div class="card-body">
                    {{-- <div class="table-responsive" id="table-responsive" style="max-height: 400px; overflow-y: auto; border: 1px solid #ccc;"> --}}
                    <div class="table-responsive" id="table-responsive">
                        <table class="table table-bordered text-nowrap"
                            style="width:100%; border-collapse: separate; border-spacing: 0;">
                            <thead style="background-color: #007bff; color: white;">
                                <tr>
                                    <th style="position: sticky; top: 0; background-color: #007bff; z-index: 2;">#</th>
                                    <th style="position: sticky; top: 0; background-color: #007bff; z-index: 2;">Billing ID</th>
                                    <th style="position: sticky; top: 0; background-color: #007bff; z-index: 2;">Date</th>
                                    <th style="position: sticky; top: 0; background-color: #007bff; z-index: 2;">Section</th>
                                    <th style="position: sticky; top: 0; background-color: #007bff; z-index: 2;">Patient</th>
                                    <th style="position: sticky; top: 0; background-color: #007bff; z-index: 2;">Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($request_data['doctor'] as $charge_id)
                                    @php
                                        $doctor = $doctors->firstWhere('charge_id', $charge_id);
                                        $doctorItems = $response->where('charge_id', $charge_id);
                                        $patientCount = $doctorItems->count();
                                        $total = $doctorItems->sum('commission_amount');
                                    @endphp

                                    @if ($doctor)
                                        <tr style="background-color: #d1cbcb;">
                                            <th colspan="6" class="text-center">
                                                <strong style="color: #0000ff;">Dr. {{ $doctor->name }}</strong><br>
                                                <small style="color: #080808;">
                                                    <strong style="padding: 0 5px;">Doctor Rate:
                                                        ₹{{ $doctor->doctor_fees }}</strong> |
                                                    <strong style="padding: 0 5px;">Total Patients:
                                                        {{ $patientCount }}</strong> |
                                                    <strong style="padding: 0 5px;">Section:
                                                        {{ @$request_data['section'] }}</strong> |
                                                    <strong style="padding: 0 5px;">Date:
                                                        {{ dateFor(@$request_data['from_date']) }} to
                                                        {{ dateFor(@$request_data['to_date']) }}</strong>
                                                </small>
                                            </th>
                                        </tr>

                                        @if ($patientCount > 0)
                                            @foreach ($doctorItems as $loopIndex => $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><a href="{{ route('bill.billing-details', [strtolower($item->section), ed($item->billing_id, true)]) }}">{{ $item->uid }}</a></td>
                                                    <td>{{ dateFor($item->bill_date, true) }}</td>
                                                    <td>{{ $item->section }}</td>
                                                    <td>{{ strtoupper($item->name) }} ({{ $item->patient_id }})</td>
                                                    <td>{{ $item->commission_amount }}</td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <th colspan="5" class="text-right text-center">Total Amount</th>
                                                <td>₹ {{ number_format($total, 2) }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <th colspan="6" class="text-center">No Data Found</th>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('.data-table').DataTable({
            "pageLength": 50, // Default number of rows per page
            "lengthMenu": [10, 25, 50, 100, 200], // Dropdown options for rows per page
            "language": {
                "emptyTable": "No data available in table" // Custom message when table is empty
            }
        });
    </script>
@endpush
