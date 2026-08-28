@php
    $totals = array_fill(1, 23, 0);
    $branchTitle = $branchTitle ?? null;
    $branchKey = $branchKey ?? null;
    $tableHeading = $branchTitle ?? $sectionTitle ?? null;
@endphp

@if (!empty($tableHeading))
    <h5 class="mb-3 text-uppercase text-secondary">{{ $tableHeading }}</h5>
@endif

<div class="table-responsive" id="{{ $tableId ?? 'table-responsive' }}">
                        <table class="table table-bordered text-nowrap data-table">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th scope="col" class="text-yellow text-center">
                                        {{ $title == 'Collection' ? 'Date' : 'User' }}</th>
                                    <th scope="col" class="text-yellow text-center" colspan="3">OPD</th>
                                    <th scope="col" class="text-yellow text-center" colspan="3">EMG</th>
                                    <th scope="col" class="text-yellow text-center" colspan="3">IPD</th>
                                    <th scope="col" class="text-yellow text-center" colspan="3">DAYCARE</th>
                                    <th scope="col" class="text-yellow text-center" colspan="3">DIALYSIS</th>
                                    <th scope="col" class="text-yellow text-center" colspan="3">INVESTIGATION</th>
                                    <th scope="col" class="text-yellow text-center" colspan="5">Total</th>
                                </tr>
                                <tr class="bg-primary text-orange">
                                    <th scope="col" class="text-orange text-center"></th>
                                    <th scope="col" class="text-orange text-center">Cash</th>
                                    <th scope="col" class="text-orange text-center">Bank</th>
                                    <th scope="col" class="text-orange text-center">Total</th>
                                    <th scope="col" class="text-orange text-center">Cash</th>
                                    <th scope="col" class="text-orange text-center">Bank</th>
                                    <th scope="col" class="text-orange text-center">Total</th>
                                    <th scope="col" class="text-orange text-center">Cash</th>
                                    <th scope="col" class="text-orange text-center">Bank</th>
                                    <th scope="col" class="text-orange text-center">Total</th>
                                    <th scope="col" class="text-orange text-center">Cash</th>
                                    <th scope="col" class="text-orange text-center">Bank</th>
                                    <th scope="col" class="text-orange text-center">Total</th>
                                    <th scope="col" class="text-orange text-center">Cash</th>
                                    <th scope="col" class="text-orange text-center">Bank</th>
                                    <th scope="col" class="text-orange text-center">Total</th>
                                    <th scope="col" class="text-orange text-center">Cash</th>
                                    <th scope="col" class="text-orange text-center">Bank</th>
                                    <th scope="col" class="text-orange text-center">Total</th>
                                    <th scope="col" class="text-orange text-center">Cash</th>
                                    <th scope="col" class="text-orange text-center">Refund</th>
                                    <th scope="col" class="text-orange text-center">Bank</th>
                                    <th scope="col" class="text-orange text-center">TDS</th>
                                    <th scope="col" class="text-orange text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($tableData) > 0)
                                    @php
                                        $totals = array_fill(1, 23, 0);
                                        $branchHiddenFields = [];
                                        if (!empty($branchKey)) {
                                            $branchHiddenFields[] = ['name' => 'branch', 'value' => $branchKey];
                                            $branchHiddenFields[] = ['name' => 'branch_title', 'value' => $branchTitle ?? ''];
                                        }
                                    @endphp

                                    @foreach ($tableData as $key => $item)
                                        @php
                                            $rowHiddenFields = $branchHiddenFields;
                                            if ($title != 'Collection') {
                                                $collectedUserId = $item['user_id'] ?? (isset($item['payments'][0]) ? $item['payments'][0]->payment_recived_by : null);
                                                if (!empty($collectedUserId)) {
                                                    $rowHiddenFields[] = ['name' => 'collected_user', 'value' => $collectedUserId];
                                                }
                                            }
                                            if ($title == 'Collection') {
                                                $rowDate = $key;
                                                if (!empty($rowDate)) {
                                                    $rowHiddenFields[] = ['name' => 'row_date', 'value' => $rowDate];
                                                }
                                            }
                                        @endphp
                                        <tr style="font-size: 16px">

                                            <!-- this is for user -->
                                            <td style="background-color: #ffeaa2;">{{ $title == 'Collection' ? dateFor($key) : $key }}</td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'OPD')
                                                    ->where('payment_mode', 'Cash')
                                                    ->sum('payment_amount');
                                                $totals[1] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">{{ $val }}</td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'OPD')
                                                    ->whereNotIn('payment_mode', ['Cash'])
                                                    ->sum('payment_amount');
                                                $totals[2] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">{{ $val }}</td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'OPD')
                                                    ->sum('payment_amount');
                                                $totals[3] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">
                                                @if ($title == 'Collection')
                                                    {{ $val }}
                                                @else
                                                    <form method="POST"
                                                        action="{{ route('reports.total-collection-view') }}">
                                                        @csrf
                                                        @foreach ($rowHiddenFields as $field)
                                                            <input type="hidden" name="{{ $field['name'] }}"
                                                                value="{{ $field['value'] }}">
                                                        @endforeach
                                                        <input type="hidden" name="section" value="OPD">
                                                        <input type="hidden" name="from_date"
                                                            value="{{ @$request_data['from_date'] ? $request_data['from_date'] : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                        <input type="hidden" name="to_date"
                                                            value="{{ @$request_data['to_date'] ? $request_data['to_date'] : \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                                        <button type="submit"
                                                            class="btn btn-default btn-sm"><b>{{ $val }}</b></button>
                                                    </form>
                                                @endif
                                            </td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'EMG')
                                                    ->where('payment_mode', 'Cash')
                                                    ->sum('payment_amount');
                                                $totals[4] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">{{ $val }}</td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'EMG')
                                                    ->whereNotIn('payment_mode', ['Cash'])
                                                    ->sum('payment_amount');
                                                $totals[5] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">{{ $val }}</td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'EMG')
                                                    ->sum('payment_amount');
                                                $totals[6] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">
                                                @if ($title == 'Collection')
                                                    {{ $val }}
                                                @else
                                                    <form method="POST"
                                                        action="{{ route('reports.total-collection-view') }}">
                                                        @csrf
                                                        @foreach ($rowHiddenFields as $field)
                                                            <input type="hidden" name="{{ $field['name'] }}"
                                                                value="{{ $field['value'] }}">
                                                        @endforeach
                                                        <input type="hidden" name="section" value="EMG">
                                                        <input type="hidden" name="from_date"
                                                            value="{{ @$request_data['from_date'] ? $request_data['from_date'] : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                        <input type="hidden" name="to_date"
                                                            value="{{ @$request_data['to_date'] ? $request_data['to_date'] : \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                                        <button type="submit"
                                                            class="btn btn-default btn-sm"><b>{{ $val }}</b></button>
                                                    </form>
                                                @endif
                                            </td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'IPD')
                                                    ->where('payment_mode', 'Cash')
                                                    ->sum('payment_amount');
                                                $totals[7] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">{{ $val }}</td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'IPD')
                                                    ->whereNotIn('payment_mode', ['Cash'])
                                                    ->sum('payment_amount');
                                                $totals[8] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">{{ $val }}</td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'IPD')
                                                    ->sum('payment_amount');
                                                $totals[9] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">
                                                @if ($title == 'Collection')
                                                    {{ $val }}
                                                @else
                                                    <form method="POST"
                                                        action="{{ route('reports.total-collection-view') }}">
                                                        @csrf
                                                        @foreach ($rowHiddenFields as $field)
                                                            <input type="hidden" name="{{ $field['name'] }}"
                                                                value="{{ $field['value'] }}">
                                                        @endforeach
                                                        <input type="hidden" name="section" value="IPD">
                                                        <input type="hidden" name="from_date"
                                                            value="{{ @$request_data['from_date'] ? $request_data['from_date'] : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                        <input type="hidden" name="to_date"
                                                            value="{{ @$request_data['to_date'] ? $request_data['to_date'] : \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                                        <button type="submit"
                                                            class="btn btn-default btn-sm"><b>{{ $val }}</b></button>
                                                    </form>
                                                @endif
                                            </td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'DAYCARE')
                                                    ->where('payment_mode', 'Cash')
                                                    ->sum('payment_amount');
                                                $totals[10] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">{{ $val }}</td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'DAYCARE')
                                                    ->whereNotIn('payment_mode', ['Cash'])
                                                    ->sum('payment_amount');
                                                $totals[11] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">{{ $val }}</td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'DAYCARE')
                                                    ->sum('payment_amount');
                                                $totals[12] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">
                                                @if ($title == 'Collection')
                                                    {{ $val }}
                                                @else
                                                    <form method="POST"
                                                        action="{{ route('reports.total-collection-view') }}">
                                                        @csrf
                                                        @foreach ($rowHiddenFields as $field)
                                                            <input type="hidden" name="{{ $field['name'] }}"
                                                                value="{{ $field['value'] }}">
                                                        @endforeach
                                                        <input type="hidden" name="section" value="DAYCARE">
                                                        <input type="hidden" name="from_date"
                                                            value="{{ @$request_data['from_date'] ? $request_data['from_date'] : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                        <input type="hidden" name="to_date"
                                                            value="{{ @$request_data['to_date'] ? $request_data['to_date'] : \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                                        <button type="submit"
                                                            class="btn btn-default btn-sm"><b>{{ $val }}</b></button>
                                                    </form>
                                                @endif
                                            </td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'DIALYSIS')
                                                    ->where('payment_mode', 'Cash')
                                                    ->sum('payment_amount');
                                                $totals[13] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">{{ $val }}</td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'DIALYSIS')
                                                    ->whereNotIn('payment_mode', ['Cash'])
                                                    ->sum('payment_amount');
                                                $totals[14] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">{{ $val }}</td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'DIALYSIS')
                                                    ->sum('payment_amount');
                                                $totals[15] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">
                                                @if ($title == 'Collection')
                                                    {{ $val }}
                                                @else
                                                    <form method="POST"
                                                        action="{{ route('reports.total-collection-view') }}">
                                                        @csrf
                                                        @foreach ($rowHiddenFields as $field)
                                                            <input type="hidden" name="{{ $field['name'] }}"
                                                                value="{{ $field['value'] }}">
                                                        @endforeach
                                                        <input type="hidden" name="section" value="DIALYSIS">
                                                        <input type="hidden" name="from_date"
                                                            value="{{ @$request_data['from_date'] ? $request_data['from_date'] : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                        <input type="hidden" name="to_date"
                                                            value="{{ @$request_data['to_date'] ? $request_data['to_date'] : \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                                        <button type="submit"
                                                            class="btn btn-default btn-sm"><b>{{ $val }}</b></button>
                                                    </form>
                                                @endif
                                            </td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'INVESTIGATION')
                                                    ->where('payment_mode', 'Cash')
                                                    ->sum('payment_amount');
                                                $totals[16] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">{{ $val }}</td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'INVESTIGATION')
                                                    ->whereNotIn('payment_mode', ['Cash'])
                                                    ->sum('payment_amount');
                                                $totals[17] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">{{ $val }}</td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('section', 'INVESTIGATION')
                                                    ->sum('payment_amount');
                                                $totals[18] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">
                                                @if ($title == 'Collection')
                                                    {{ $val }}
                                                @else
                                                    <form method="POST"
                                                        action="{{ route('reports.total-collection-view') }}">
                                                        @csrf
                                                        @foreach ($rowHiddenFields as $field)
                                                            <input type="hidden" name="{{ $field['name'] }}"
                                                                value="{{ $field['value'] }}">
                                                        @endforeach
                                                        <input type="hidden" name="section" value="INVESTIGATION">
                                                        <input type="hidden" name="from_date"
                                                            value="{{ @$request_data['from_date'] ? $request_data['from_date'] : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                        <input type="hidden" name="to_date"
                                                            value="{{ @$request_data['to_date'] ? $request_data['to_date'] : \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                                        <button type="submit"
                                                            class="btn btn-default btn-sm"><b>{{ $val }}</b></button>
                                                    </form>
                                                @endif
                                            </td>

                                            @php
                                                $val = $item['payments']
                                                    ->where('payment_mode', 'Cash')
                                                    ->sum('payment_amount');
                                                $totals[19] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">
                                                @if ($title == 'Collection')
                                                    <form method="POST"
                                                        action="{{ route('reports.cash-bank-collection-view') }}">
                                                        @csrf
                                                        @foreach ($rowHiddenFields as $field)
                                                            <input type="hidden" name="{{ $field['name'] }}"
                                                                value="{{ $field['value'] }}">
                                                        @endforeach
                                                        <input type="hidden" name="collect_amount_type" value="Cash">
                                                        <input type="hidden" name="from_date"
                                                            value="{{ @$request_data['from_date'] ? $request_data['from_date'] : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                        <input type="hidden" name="to_date"
                                                            value="{{ @$request_data['to_date'] ? $request_data['to_date'] : \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                                        <button type="submit"
                                                            class="btn btn-default btn-sm"><b>{{ $val }}</b></button>
                                                    </form>
                                                @else
                                                    {{ $val }}
                                                @endif
                                            </td>

                                            @php
                                                $val = $item['payment_refund'];
                                                $totals[20] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600; color: red">{{ $val }}</td>

                                            @php
                                                $val = $item['payments']
                                                    ->whereNotIn('payment_mode', ['Cash'])
                                                    ->sum('payment_amount');
                                                $totals[21] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">
                                                @if ($title == 'Collection')
                                                    <form method="POST"
                                                        action="{{ route('reports.cash-bank-collection-view') }}">
                                                        @csrf
                                                        @foreach ($rowHiddenFields as $field)
                                                            <input type="hidden" name="{{ $field['name'] }}"
                                                                value="{{ $field['value'] }}">
                                                        @endforeach
                                                        <input type="hidden" name="collect_amount_type" value="other">
                                                        <input type="hidden" name="from_date"
                                                            value="{{ @$request_data['from_date'] ? $request_data['from_date'] : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                        <input type="hidden" name="to_date"
                                                            value="{{ @$request_data['to_date'] ? $request_data['to_date'] : \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                                        <button type="submit"
                                                            class="btn btn-default btn-sm"><b>{{ $val }}</b></button>
                                                    </form>
                                                @else
                                                    {{ $val }}
                                                @endif
                                            </td>

                                            @php
                                                $val = $item['payments']
                                                    ->whereNotIn('payment_mode', ['Cash'])
                                                    ->sum('tds_amount');

                                                // $total_tds = ($val * $tds_amount) / 100;
                                                $totals[22] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600; color: red">{{ round($val) }}</td>
                                            @php
                                                $val = ($item['payments']->sum('payment_amount') - $item['payment_refund']) + $val = $item['payments']
                                                    ->whereNotIn('payment_mode', ['Cash'])
                                                    ->sum('tds_amount');
                                                $totals[23] += $val;
                                            @endphp
                                            <td style="text-align: center;font-weight:600">{{ $val }}</td>
                                        </tr>
                                    @endforeach

                                    <tr style="background-color: #9be986;font-size: 16px">
                                        <td>Total</td>
                                        @for ($i = 1; $i <= 23; $i++)
                                            <td style="text-align: center;font-weight:600">{{ round($totals[$i]) }}</td>
                                        @endfor
                                    </tr>
                                @else
                                    <tr class="">
                                        <th scope="col" class="text-center" colspan="24"> ** Data Not Found **</th>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
</div>
