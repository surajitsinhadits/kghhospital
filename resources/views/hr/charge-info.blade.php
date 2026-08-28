@extends('layouts.structure')
@push('title')
    <title>Charge Info</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-header d-block card_hearder_mimi">
                <h4 class="pro-user-username mb-3 font-weight-bold text-white">CHARGE DETAILS</h4>
            </div>
            <div class="card-body p-0">
                <div class="card-body border-top">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 border">
                                <table class="table bordernone">
                                    <tbody>
                                        <tr>
                                            <td class="py-2 px-5 ">
                                                <span class="font-weight-semibold w-50">Charge Name </span>
                                            </td>
                                            <td class="py-2 px-5 ">{{$charge->charge_name}}</td>
                                        </tr>

                                        <tr>
                                            <td class="py-2 px-5 ">
                                                <span class="font-weight-semibold w-50">Standard Charges </span>
                                            </td>
                                            <td class="py-2 px-5 ">
                                                @foreach($chargeSections as $list)
                                                <span class="badge badge-gradient-primary mt-2">{{$list->charges_section_name}} : ₹{{$list->charge_amount}}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-5">
                                                <span class="font-weight-semibold w-50">Apply to ?</span>
                                            </td>
                                            <td class="py-2 px-5">
                                                @foreach($chargeSections as $list)
                                                <span class="badge badge-gradient-success mt-2">{{$list->charges_section_name}}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-5" colspan="2">
                                                <span class="badge badge-danger">{{$charge->charge_type}}</span>
                                                <span class="badge badge-success">{{$charge->charge_section}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-5">
                                                <span class="font-weight-semibold w-50">Note</span>
                                            </td>
                                            <td class="py-2 px-5">{{@$charge->note}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 border">
                                <table class="table bordernone">
                                    <tbody>
                                        <tr>
                                            <td class="py-2 px-5">
                                                <span class="font-weight-semibold w-50">Charge Category Name </span>
                                            </td>
                                            <td class="py-2 px-5">{{$charge_category->charges_catagories_name}}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-5">
                                                <span class="font-weight-semibold w-50">Sub Category Name</span>
                                            </td>
                                            <td class="py-2 px-5">{{@$charge_subcategory->charges_catagories_name}}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-5">
                                                <span class="font-weight-semibold w-50">Instrument Used</span>
                                            </td>
                                            <td class="py-2 px-5">{{@$charge->instrument_used}}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-5">
                                                <span class="font-weight-semibold w-50">Sample</span>
                                            </td>
                                            <td class="py-2 px-5">{{@$sample->sample_name}}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-5">
                                                <span class="font-weight-semibold w-50">Sample Required</span>
                                            </td>
                                            <td class="py-2 px-5">{{@$charge->sample_required}}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-5">
                                                <span class="font-weight-semibold w-50">Vial</span>
                                            </td>
                                            <td class="py-2 px-5">{{@$vial->vial_name}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="text-center text-blue">{{$charge->charge_name}}</h4>
                    <table style="overflow-x: auto;
                    display: block; " class="table-bordered text-center"
                        id="data-table">
                        <thead class="bg-primary">
                            <tr>
                                <th class="border-bottom-0 text-white" style="padding-left: 30px; padding-right:30px;">Sl. No.
                                </th>
                                <th class="border-bottom-0 text-white" style="padding-left: 30px; padding-right:30px;">Lebel
                                </th>
                                <th class="border-bottom-0 text-white" style="padding-left: 36px; padding-right:36px;">
                                    Grp.Cd</th>
                                <th class="border-bottom-0 text-white" style="padding-left: 120px; padding-right:120px;">
                                    Test</th>
                                <th class="border-bottom-0 text-white" style="padding-left: 30px; padding-right:30px;">Seq
                                    No.</th>
                                <th class="border-bottom-0 text-white" style="padding-left: 40px; padding-right:40px;">
                                    Comments</th>
                                <th class="border-bottom-0 text-white" style="padding-left: 30px; padding-right:30px;">Unit
                                </th>
                                <th class="border-bottom-0 text-white" style="padding-left: 30px; padding-right:30px;">M/LL
                                </th>
                                <th class="border-bottom-0 text-white" style="padding-left: 30px; padding-right:30px;">M/UL
                                </th>
                                <th class="border-bottom-0 text-white" style="padding-left: 30px; padding-right:30px;">F/LL
                                </th>
                                <th class="border-bottom-0 text-white" style="padding-left: 30px; padding-right:30px;">F/UL
                                </th>
                                <th class="border-bottom-0 text-white" style="padding-left: 30px; padding-right:30px;">C/LL
                                </th>
                                <th class="border-bottom-0 text-white" style="padding-left: 30px; padding-right:30px;">C/UL
                                </th>
                                <th class="border-bottom-0 text-white" style="padding-left: 30px; padding-right:30px;">
                                    Method</th>
                                <th class="border-bottom-0 text-white" style="padding-left: 30px; padding-right:30px;">
                                    Instrument Used
                                </th>
                                <th class="border-bottom-0 text-white" style="padding-left: 30px; padding-right:30px;">LISCd
                                </th>
                                <th class="border-bottom-0 text-white" style="padding-left: 140px; padding-right:140px;">
                                    Formula</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($normal as $list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$list->lebel}}</td>
                                <td>{{$list->grp_cd}}</td>
                                <td>{{$list->test_parameter}}</td>
                                <td>{{$list->seq_no}}</td>
                                <td>{{$list->comments}}</td>
                                <td>{{$list->unit}}</td>
                                <td>{{$list->m_ll}}</td>
                                <td>{{$list->m_ul}}</td>
                                <td>{{$list->f_ll}}</td>
                                <td>{{$list->f_ul}}</td>
                                <td>{{$list->c_ll}}</td>
                                <td>{{$list->c_ul}}</td>
                                <td>{{$list->method}}</td>
                                <td>{{$list->instrument_used}}</td>
                                <td>{{$list->lis_cd}}</td>
                                <td>{{$list->formula}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
