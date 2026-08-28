@extends('layouts.structure')

@push('title')
    <title>Blood Inventory Summary</title>
@endpush

@section('main-content')
    <div class="row">
        <!-- Table Column -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Available Blood Stock Summary (Not Expired)</h4>
                </div>
                <div class="card-body">
                    @if ($bloodSummary->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Blood Group</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bloodSummary as $item)
                                        <tr>
                                            <td><strong>{{ $item->blood_group }}</strong></td>
                                            <td>{{ $item->quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            No available stock with valid expiry date.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Chart Column -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Blood Stock Chart</h4>
                </div>
                <div class="card-body">
                    <div style="width: 100%; max-width: 300px; margin: auto;">
                        <canvas id="bloodStockChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = {!! json_encode($bloodSummary->pluck('blood_group')) !!};
        const quantities = {!! json_encode($bloodSummary->pluck('quantity')) !!};

        const ctx = document.getElementById('bloodStockChart').getContext('2d');
        const bloodStockChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Units Available',
                    data: quantities,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56',
                        '#4BC0C0', '#9966FF', '#FF9F40',
                        '#00A36C', '#A52A2A'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
