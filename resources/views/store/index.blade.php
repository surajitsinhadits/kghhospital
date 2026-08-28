@extends('layouts.structure')
@push('title')
    <title>Store Management Dashboard</title>
@endpush
@push('css')
  <style>
    .card-header svg {
      width: 20px;
      height: 20px;
    }
    .hover-scale:hover {
      transform: scale(1.02);
      transition: 0.2s;
    }
    .shadow-elegant {
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .glass-surface {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(6px);
    }
  </style>
@endpush
@section('main-content')
<div style="background: linear-gradient(135deg, #f8f7fe 0%, #f2f7fd 100%);">
<div class="container py-5">

  <!-- KPIs -->
  <div class="row">

    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card rounded glass-surface shadow-elegant h-65">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="text-muted mb-0">Requisitions</h6>
          <div class="p-2 bg-info rounded">
            <!-- Calendar icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 viewBox="0 0 24 24">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
          </div>
        </div>
        <div class="card-body">
          <h3 class="font-weight-bold">{{ $lastAllRequisition }}</h3>
          @if($weekPercentageChangeRequition < 0)
          <p class="text-danger small mb-0">{{ $weekPercentageChangeRequition }}% vs this week</p>
          @else
          <p class="text-success small mb-0">{{ $weekPercentageChangeRequition }}% vs this week</p>
          @endif
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card rounded glass-surface shadow-elegant h-65">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="text-muted mb-0">Purchase Order</h6>
          <div class="p-2 bg-info rounded">
            <!-- Dollar icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <!-- document -->
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <path d="M14 2v6h6"></path>
              <!-- text lines -->
              <path d="M8 13h5M8 17h3"></path>
              <!-- small cart -->
              <circle cx="15" cy="19" r="1"></circle>
              <circle cx="19" cy="19" r="1"></circle>
              <path d="M17 19h-2l-1-4h6l-1 4h-2"></path>
            </svg>
          </div>
        </div>
        <div class="card-body">
          <h3 class="font-weight-bold">{{ $lastAllPurchaseOrder }}</h3>
          @if($weekPercentageChangePurchaseOrder < 0)
          <p class="text-danger small mb-0">{{ $weekPercentageChangePurchaseOrder }}% vs this week</p>
          @else
          <p class="text-success small mb-0">{{ $weekPercentageChangePurchaseOrder }}% vs this week</p>
          @endif
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card rounded glass-surface shadow-elegant h-65">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="text-muted mb-0">Purchase</h6>
          <div class="p-2 bg-info rounded">
            <!-- Users icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
          </svg>
          </div>
        </div>
        <div class="card-body">
          <h3 class="font-weight-bold">{{ $lastAllPurchase }}</h3>
          @if($weekPercentageChangePurchase < 0)
          <p class="text-danger small mb-0">{{ $weekPercentageChangePurchase }}% vs this week</p>
          @else
          <p class="text-success small mb-0">{{ $weekPercentageChangePurchase }}% vs this week</p>
          @endif
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card rounded glass-surface shadow-elegant h-65">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="text-muted mb-0">Total Items</h6>
          <div class="p-2 bg-info rounded">
            <!-- Bag icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 viewBox="0 0 24 24">
              <path d="M6 2l.344 2.75A2 2 0 0 0 8.322 6h7.356a2 2 0 0 0 1.978-1.25L18 2"/>
              <path d="M6 2h12"/>
              <path d="M7 6l-1.5 14A2 2 0 0 0 7.486 22h9.028a2 2 0 0 0 1.986-1.999L17 6"/>
              <path d="M9 10a3 3 0 0 0 6 0"/>
            </svg>
          </div>
        </div>
        <div class="card-body">
          <h3 class="font-weight-bold">{{ $totalItems }}</h3>
        </div>
      </div>
    </div>

  </div>

  <div class="row">

    <div class="col-sm-6 col-lg-3">
      <div class="card rounded glass-surface shadow-elegant h-130" style="margin: 0 !important;">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="text-muted mb-0">Stock Amount</h6>
          <div class="p-2 bg-info rounded">
            <!-- Dollar icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 viewBox="0 0 24 24">
              <line x1="12" y1="1" x2="12" y2="23"/>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
          </div>
        </div>
        <div class="card-body">
          <h3 class="font-weight-bold">{{ $stockPurchaseLast7daysSum }}</h3>
          @if($weekPercentageChangeStock < 0)
          <p class="text-danger small mb-0">{{ $weekPercentageChangeStock }}% vs Last 7 Days</p>
          @else
          <p class="text-success small mb-0">{{ $weekPercentageChangeStock }}% vs Last 7 Days</p>
          @endif
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card rounded glass-surface shadow-elegant h-130" style="margin: 0 !important;">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="text-muted mb-0">Issue Amount</h6>
          <div class="p-2 bg-info rounded">
            <!-- Calendar icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 viewBox="0 0 24 24">
              <line x1="12" y1="1" x2="12" y2="23"/>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
          </div>
        </div>
        <div class="card-body">
          <h3 class="font-weight-bold">{{ $stockIssueLast7daysSum }}</h3>
          @if( $weekPercentageChangeIssue < 0 )
          <p class="text-danger small mb-0">{{ $weekPercentageChangeIssue }}% vs Last 7 Days</p>
          @else
          <p class="text-success small mb-0">{{ $weekPercentageChangeIssue }}% vs Last 7 Days</p>
          @endif
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card glass-surface shadow-elegant h-130" style="margin: 0 !important;">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="text-muted mb-0">Stock Amount</h6>
          <div class="p-2 bg-info rounded">
            <!-- Users icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 viewBox="0 0 24 24">
              <line x1="12" y1="1" x2="12" y2="23"/>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
          </div>
        </div>
        <div class="card-body">
          <h3 class="font-weight-bold">{{ $stockPurchaseLast1yearSum }}</h3>
          @if($weekPercentageChangeStockYear < 0)
          <p class="text-danger small mb-0">{{ $weekPercentageChangeStockYear }}% vs Last 1 Year</p>
          @else
          <p class="text-success small mb-0">{{ $weekPercentageChangeStockYear }}% vs Last 1 Year</p>
          @endif
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card glass-surface shadow-elegant h-130" style="margin: 0 !important;">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="text-muted mb-0">Issue Amount</h6>
          <div class="p-2 bg-info rounded">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 viewBox="0 0 24 24">
              <line x1="12" y1="1" x2="12" y2="23"/>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
          </div>
        </div>
        <div class="card-body">
          <h3 class="font-weight-bold">{{ $stockIssueLast1yearSum }}</h3>
          @if($weekPercentageChangeIssueYear < 0)
          <p class="text-danger small mb-0">{{ $weekPercentageChangeIssueYear }}% vs Last 1 Year</p>
          @else
          <p class="text-success small mb-0">{{ $weekPercentageChangeIssueYear }}% vs Last 1 Year</p>
          @endif
        </div>
      </div>
    </div>
    
  </div>

  <!-- Tables -->
  <div class="row">
    <div class="col-lg-7 mb-4">
      <div class="card" style="margin-top: 20px !important; min-height: 350px;">
        <div class="card-header d-flex justify-content-between">
          <h6 class="mb-0 my-2">Latest Requisition</h6>
        </div>
        <div class="table-responsive card-body">
          <table class="table table-sm">
            <thead class="text-muted">
              <tr>
                <th>SN</th>
                <th>Requisition No.</th>
                <th>Generated By</th>
                <th>Department</th>
                <th class="text-right">Date</th>
              </tr>
            </thead>
            <tbody>
              @if($allRequisition->count())
              @foreach($allRequisition as $requisition)
              <tr class="hover-scale">
                <td>{{ $loop->iteration }}</td>
                <td>R#{{ $requisition->id }}</td>
                <td>{{ $requisition->generated_by }}</td>
                <td>{{ $requisition->department }}</td>
                <td class="text-right">{{ dateFor($requisition->requisition_date, true) }}</td>
              </tr>
              @endforeach
              @endif
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-lg-5 mb-4">
      <div class="card" style="margin-top: 20px !important; height: 350px; overflow: scroll;">
        <div class="card-header d-flex justify-content-between">
            <div class="row col-md-12">
                <div class="col-md-4">
                    <h6 class="mb-0 mt-3">Stock Items</h6>
                </div>
                <div class="col-md-8">
                    <input style="height: 28px;" type="text" id="searchInput" class="form-control" placeholder="Search by item name">
                </div>
            </div>
        </div>
        <div class="table-responsive card-body">
          <table class="table table-sm" id="usersTable">
            <thead class="text-muted">
              <tr>
                <th>SN</th>
                <th>Item Name</th>
                <th>QTY</th>
                <th class="text-right">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($allItems as $stock)
                  <tr style="background-color:#FFFFFF">
                    <td>{{ $loop->iteration }}</td>
                      <td style="text-align: left;"><a href="{{ route('store.item-info', ed($stock['id'], true)) }}">{{$stock['item']}}</a></td>
                      <td>{{ $stock['unit_qty'].' '.$stock['unit'].' '.$stock['sub_unit_qty'].' '.$stock['sub_unit'] }}</td>
                      <td Class="text-right">
                          @if($stock['total_qty'] > 0)
                              {!! $stock['low_level'] < $stock['unit_qty'] ?
                                  '<span class="badge badge-gradient-success mt-2">Available</span>' :
                                  '<span class="badge badge-gradient-warning mt-2"> Low Stock</span>' !!}

                          @else
                              <span class="badge badge-gradient-secondary mt-2"> Out Of stock</span>
                          @endif
                      </td>
                  </tr>
                  @endforeach
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card shadow-elegant h-100" style="margin: 0 !important;">
        <div class="card-header">
          <h6 class="mb-0">Yearly Collection</h6>
        </div>
        <div class="card-body">
          <div id="monthWiseTwoColumn" class="w-100" style="height: 320px;"></div>
        </div>
      </div>
    </div>
  </div>

</div>
  </div>
  @endsection
@push('js')
    <script>
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll("#usersTable tbody tr");

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(value) ? "" : "none";
            });
        });

        var options = {
            series: [{
                name: 'Stock',
                data: @json($monthWiseStockAmount)
            }, {
                name: 'Issues',
                data: @json($monthWiseIssueAmount)
            }],
            chart: {
                height: 350,
                type: 'area'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: @json($categories)
            },
        };

        var chart = new ApexCharts(document.querySelector("#monthWiseTwoColumn"), options);
        chart.render();
    </script>
@endpush
