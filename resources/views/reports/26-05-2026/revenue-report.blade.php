@extends('layouts.structure')
@push('title')
    <title>{{ $title }}</title>
@endpush
@push('css')
    <style>
        .revenue-table {
            min-width: 1100px;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .revenue-table th,
        .revenue-table td {
            border: 1px solid #d3d7db;
            padding: 0.5rem;
        }

        .revenue-table thead th {
            background-color: #1f4d48;
            color: #fff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .revenue-table th.total-heading {
            background-color: #14362b;
        }

        .revenue-table tbody td {
            font-weight: 600;
            background-color: #fff;
        }

        .revenue-table tbody td.date-cell {
            background-color: #fff7d9;
            color: #0d1a10;
            font-weight: 700;
        }

        .revenue-table tfoot th {
            background-color: #99e380;
            color: #0a311a;
            font-weight: 700;
        }

        .table-control-row button,
        .table-control-row a {
            margin-bottom: 0.25rem;
        }
    </style>
@endpush
@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-header card_hearder_mimi">
                <div class="card-title card_hearder_mimi_text"> {{ $title }} Report</div>
            </div>
            <div class="card-body p-0">
                <div class="col-md-12 border-right">
                    <form method="GET" action="{{ $action }}">
                        <div class="whitebackground">
                            <div class="row ">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control datePickr"
                                            value="{{ $request_data['from_date'] ?? '' }}" id="fromDate" name="from_date"
                                            placeholder="Choose From Date">
                                        @error('from_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control datePickr"
                                            value="{{ $request_data['to_date'] ?? '' }}" id="toDate" name="to_date"
                                            placeholder="Choose To Date">
                                        @error('to_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group d-flex flex-wrap align-items-center">
                                        <button type="submit" class="btn btn-primary px-3 mr-2">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="{{ $action }}" class="btn btn-warning px-3">
                                            <i class="fas fa-history"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="whitebackground mt-4">
                <div class="card-body">
                    <div class="table-responsive p-3">
                        @php
                            $formatRevenue = function ($value = 0) {
                                return number_format((float) ($value ?? 0), 0, '', '');
                            };
                        @endphp
                        <table class="table table-bordered revenue-table mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center date-header">Date</th>
                                    @foreach ($sections as $section)
                                        <th class="text-center section-heading">{{ $section }}</th>
                                    @endforeach
                                    <th class="text-center total-heading">Total</th>
                                </tr>
                            </thead>
                    <tbody>
                        @forelse ($rows as $row)
                            <tr>
                                <td class="date-cell text-center">{{ $row['date'] }}</td>
                                @foreach ($sections as $section)
                                    @php
                                        $cell = $row['sections'][$section] ?? ['amount' => 0, 'count' => 0];
                                    @endphp
                                    <td class="text-right">
                                        {{ $formatRevenue($cell['amount']) }}
                                        <span class="text-muted">({{ $cell['count'] }})</span>
                                    </td>
                                @endforeach
                                <td class="text-right">
                                    {{ $formatRevenue($row['total']) }}
                                    <span class="text-muted">({{ $row['count'] }})</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 2 + count($sections) }}"
                                    class="text-center text-muted py-4">No records found for the selected dates.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <th>Total</th>
                            @foreach ($sections as $section)
                                @php
                                    $cellTotal = $sectionTotals[$section] ?? ['amount' => 0, 'count' => 0];
                                @endphp
                                <th class="text-right">
                                    {{ $formatRevenue($cellTotal['amount']) }}
                                    <span class="text-muted">({{ $cellTotal['count'] }})</span>
                                </th>
                            @endforeach
                            <th class="text-right">
                                {{ $formatRevenue($summaryTotals['grand_total']) }}
                                <span class="text-muted">({{ $summaryTotals['count_total'] }})</span>
                            </th>
                        </tr>
                    </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
