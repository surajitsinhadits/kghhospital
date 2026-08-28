@extends('layouts.structure')
@push('title')
    <title>REQUISITION PRINT</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 leftside_fixarea">
                        <x-billbar section="{{ $section }}" id="{{$bill_id}}" type="bill" />
                    </div>

                    <div class="col-md-9 rightside_fixarea" style="border:2px solid black">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="modal-header">
                                <h6 class="modal-title">REQUISITION PRINT </h6>
                                {{-- <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button> --}}
                            </div>
                            <form action="{{ route('bill.print-requisition', $section) }}" method="POST" id="myForm1">
                                @csrf
                                <input type="hidden" value="{{ @$bill_details->id }}" name="bill_id" />
                                <div class="modal-body">
                                    <table class="table table-hover card-table table-vcenter text-nowrap border-left border-right border-bottom" id="subhendu">
                                        <thead class="bg-primary text-white">
                                            <tr class="border-left">
                                                <th class="text-white" style="width:10%"> <input type="checkbox" id="checkAll1"></th>
                                                <th class="text-white" style="width:80%">Test Name</th>
                                                <th class="text-white" style="width:10%">Date</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($patient_charge_details_for_requisition as $key => $value)
                                            <tr id="row{{ $key }}">
                                                <td>
                                                    <input type="checkbox" class="check-all" name="bill_details_id[{{ $key }}]" value="{{ $value->id }}" id="bill_details_id{{ $key }}" />
                                                </td>
                                                <td>{{ @$value->charge_name}}</td>
                                                <td>{{ @$value->date != null ? dateFor($value->date) : date('d-m-Y')}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if(count($patient_charge_details_for_requisition) > 0)
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit"> Print Selected Requisition</button>
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $("#checkAll1").change(function() {
            $(".check-all").prop("checked", $(this).prop("checked"));
        });
    });
</script>
@endpush
