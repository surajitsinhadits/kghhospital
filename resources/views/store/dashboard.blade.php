@extends('layouts.structure')
@push('title')
    <title>Dashboard || Store</title>
@endpush
@push('css')
<style>
    .jfdjfiji {
        width: 100%;
        height: 100vh;
        background-image: url('{{ url("public/store.jpg") }}');
        background-size: cover;
        background-attachment: fixed;
        margin: 0;
        padding: 0;
    }
</style>
@endpush
@section('main-content')
<div class="row jfdjfiji">
   <div class="container-fluid cardmain_areaboxsection">
      <div class="row">
         <div class="col-lg-9 foursection_outarea">
            <div class="row mt-4">
               <div class="col-lg-6">
                  <div class="cardmain_dashboardarea">
                     <div class="cardmain_innerdashboardareanew">
                        <div class="departmnt_imgsectionnew1">
                           <img src="{{ url('public/icons/quote-request.png') }}" class="dprmnt_imgdesignhs" style="border-radius:0px !important;">
                        </div>
                        <h2 class="cardinnerhdng_textdesign">
                           <a href="{{ route('store.listing-requisition') }}">TODAY REQUISITION</a>
                        </h2>

                        <div class="tanew1">
                           <table class="table">
                              <thead>
                                 <tr>
                                    <th>Req No.</th>
                                    <th>Req Details</th>
                                 </tr>
                              </thead>
                              <tbody>
                                @foreach ($requistion as $req)
                                 <tr>
                                    <td>
                                       <a href="{{ route('store.requisition-details', ed($req->id, true)) }}">
                                          <h6 style="margin-right: 22%;">{{$req->id}}</h6>
                                          <h6 style="margin-right: 22%; color:#018522"> {{$req->department}}</h6>
                                       </a>
                                    </td>
                                    <td>
                                       <h6 style="margin-right: 22%;">{{dateFor($req->requisition_date, true)}}</h6>
                                       <h6 style="margin-right: 22%;color:#4e3a04">{{$req->generated_by}}</h6>
                                       {!! $req->is_given == 1 ? '<span style="color :#18b71b ;font-size: 12px; font-weight: 600;">Issued </span>' : '<span style="color :#c01e1e ;font-size: 12px; font-weight: 600;">Not issued </span>' !!}
                                    </td>
                                 </tr>
                                @endforeach
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="cardmain_dashboardarea">
                     <div class="cardmain_innerdashboardareanew1">
                        <div class="departmnt_imgsectionnew">
                           <img src="{{ url('public/icons/checkout.png') }}" class="dprmnt_imgdesignhs">
                        </div>
                        <h2 class="cardinnerhdng_textdesign">
                           <a href="#">ITEM STOCK</a>
                        </h2>

                        <div class="tanew1">
                           <table class="table text-center">
                              <thead>
                                 <tr>
                                    <th style="text-align: left;">Item Name</th>
                                    <th>QTY</th>
                                    <th>Status</th>
                                 </tr>
                              </thead>
                              <tbody>
                                @foreach ($pasent_stock as $stock)
                                <tr style="background-color:#FFFFFF">
                                    <td style="text-align: left;"><a href="{{ route('store.item-info', ed($stock['id'], true)) }}">{{$stock['item']}}</a></td>
                                    <td>{{ $stock['unit_qty'].' '.$stock['unit'].' '.$stock['sub_unit_qty'].' '.$stock['sub_unit'] }}</td>
                                    <td>
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
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-lg-3">
            <div class="storedasharea">
               <a href="{{ route('store.listing-requisition') }}">
                  <div class="cardmain_dashboardarea3">
                     <div class="cardmain_innerdashboardarea1">
                        <div class="row">
                           <div class="col-lg-3">
                              <img src="{{ url('public/icons/request1.png') }}">
                           </div>
                           <div class="col-lg-9">
                              <h3 style="font-size: 17px;text-align:center;margin-top:10px;">Total Requisition : {{ $total['requistion'] }}</h3>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <a href="{{ route('store.listing-purchase-order') }}">
                  <div class="cardmain_dashboardarea3">
                     <div class="cardmain_innerdashboardarea1">
                        <div class="row">
                           <div class="col-lg-3">
                              <img src="{{ url('public/icons/request1.png') }}">
                           </div>
                           <div class="col-lg-9">
                              <h3 style="font-size: 17px;text-align:center;margin-top:10px;">
                                 Total Purchase Order : {{$total['po']}}</h3>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <a href="{{ route('store.listing-purchase') }}">
                  <div class="cardmain_dashboardarea3">
                     <div class="cardmain_innerdashboardarea1">
                        <div class="row">
                           <div class="col-lg-3">
                              <img src="{{ url('public/icons/request1.png') }}">
                           </div>
                           <div class="col-lg-9">
                              <h3 style="font-size: 17px;text-align:center;margin-top:10px;">
                                 Total Purchase : {{ $total['purchase'] }}</h3>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>

               <div class="cardmain_dashboardarea3">
                  <div class="cardmain_innerdashboardarea1">
                     <div class="row">
                        <div class="col-lg-3">
                           <img src="{{ url('public/icons/request1.png') }}">
                        </div>
                        <div class="col-lg-9">
                           <h3 style="font-size: 17px;text-align:center;margin-top:10px;">Stock Item Price : ₹{{ $total['stock_price'] }}</h3>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="cardmain_dashboardarea3">
                  <div class="cardmain_innerdashboardarea1">
                     <div class="row">
                        <div class="col-lg-3">
                           <img src="{{ url('public/icons/request1.png') }}">
                        </div>
                        <div class="col-lg-9">
                           <h3 style="font-size: 17px;text-align:center;margin-top:10px;">Issue Item Price : ₹{{ $total['issue_price'] }}</h3>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('js')
<script>
    const dd = document.querySelector('#dropdown-wrapper112');
    const links = document.querySelectorAll('.dropdown-list112 a');
    const span = document.querySelector('span');

    dd.addEventListener('click', function() {
        this.classList.toggle('is-active');
    });

    links.forEach((element) => {
        element.addEventListener('click', function(evt) {
            span.innerHTML = evt.currentTarget.textContent;
        })
    })
</script>
@endpush
