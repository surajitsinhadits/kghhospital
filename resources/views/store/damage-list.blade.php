@extends('layouts.structure')
@push('title')
    <title>Repair / Damage List</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">
                    Repair / Damage List
                </h4>
            </div>
            <div class="card-body p-0" style="margin-bottom: 32px;">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap data-table">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Request ID</th>
                                    <th>Product Name</th>
                                    <th>Department</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                    <th>Repair Amount</th>
                                    <th>Repair From</th>
                                    <th>Time / Bill</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($damage_list as $key => $damage)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>RE#{{ $damage->mas_id }} ({{ ucwords($damage->type) }})</td>
                                        <td>{{ $damage->item_name }} ({{ $damage->part_no }})</td>
                                        <td>{{ $damage->department_name }}</td>
                                        <td>{{ $damage->unit_qty }} {{ $damage->unit }} {{ $damage->sub_unit_qty }} {{ $damage->sub_unit }}</td>
                                        <td>
                                            <span>Return : {{ dateFor($damage->return_date) }}</span>
                                            {!! $damage->repair_completed_at ? '<br><span>Re-Issue : '.dateFor($damage->repair_completed_at).'</span>' : '' !!}
                                        </td>
                                        <td>{{ $damage->repair_amount }}</td>
                                        <td>{{ $damage->repair_from }}</td>
                                        <td>
                                            {{ $damage->repair_time ? $damage->repair_time.' Days' : '' }}
                                            {!! $damage->repair_bill ? '<a terget="_blank" href="'.url('public/assets/images/billdocument/'.$damage->repair_bill).'" style="cursor: pointer;padding-inline:8px"><i class="fas fa-eye"></i></a>' : '' !!}
                                        </td>
                                        <td>
                                            {!! ($damage->status == 0 && $damage->type == 'repair')
                                                ? '<button type="button" onClick="setID('.$damage->id.')" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                        Re-Issue
                                                    </button>'
                                                : '<span class="badge badge-success">Completed</span>' !!}
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Repairing Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('store.repair-items-return') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="return_id" name="return_id" value="">
            <div class="form-group">
                <label>Repair From <span class="text-danger">*</span></label>
                <textarea class="form-control" placeholder="Where Repair this Item?" name="repair_from" rows="3" required></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Repair Time (In Days) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="repair_time" placeholder="Enter Days" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Total Amount <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="repair_amount" placeholder="Enter Amount" required>
                </div>
            </div>
            <div class="form-group">
                <label>Bill Invoice (Optional)</label>
                <input type="file" class="form-control" name="repair_bill">
            </div>
            <div class="form-group text-center">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script>
    function setID(id) {
        console.log(id);

        document.getElementById('return_id').value = id;
    }
</script>
@endpush
