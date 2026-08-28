@extends('layouts.structure')
@push('title')
    <title>Dashboard</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-xl-4 col-lg-3 col-md-12">
		<div class="card box-widget widget-user">
			<div class="widget-user-image mx-auto mt-5"><img class="rounded-circle" src="{{url('public/assets/images/users/doc.png')}}" style="height: 100px;width: 117px;"></div>
			<div class="card-body text-center">
				<div class="pro-user">
					<h4 class="pro-user-username text-dark mb-1 font-weight-bold">{{$user->salutation}} {{$user->name}}</h4>
					<h6 class="pro-user-desc text-muted">{{$user->role}}</h6>
              		<a href="{{route('hr.edit-doctor',ed($user->id, true))}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Profile"><i class="fa fa-edit"></i></a>
				</div>
			</div>
			<div class="card-body">
				<h4 class="card-title"><i class="fas fa-user-circle"></i> Personal Details</h4>
				<div class="table-responsive">
					<table class="table mb-0">
						<tbody>
                            <tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Registation ID </span>
								</td>
								<td class="py-2 px-0">{{$user->empId}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Gender </span>
								</td>
								<td class="py-2 px-0">{{$user->gender}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Department </span>
								</td>
								<td class="py-2 px-0">{{$user->department_name}}</td>
							</tr>
                            <tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Category </span>
								</td>
								<td class="py-2 px-0">{{$user->category}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Sub-Category </span>
								</td>
								<td class="py-2 px-0">{{$user->sub_category}}</td>
							</tr>
                            <tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Signature </span>
								</td>
								<td class="py-2 px-0">{{$user->father_name}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
    <div class="col-xl-8 col-lg-9 col-md-12">
		<div class="main-content-body main-content-body-profile card">
			<div class="main-profile-body">
				<div class="card-body border-top">
					<h5 class="font-weight-bold"><i class='bx bxs-briefcase'></i> Work &amp; Specialist</h5>
					<div class="main-profile-contact-list d-lg-flex justify-content-between">
                        <div class="media mr-5">
							<div class="media-icon bg-success text-white mr-4">
								<i class="fa fa-briefcase"></i>
							</div>
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Specialist</h6>
								<span></span>
								<p>{{$user->specialization}}</p>
							</div>
						</div>
						<div class="media mr-5">
							<div class="media-icon bg-success text-white mr-4">
								<i class="fa fa-briefcase"></i>
							</div>
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Work Exprience</h6>
								<span></span>
								<p>{{$user->experience}}</p>
							</div>
						</div>
                        <div class="media mr-5">
							<div class="media-icon bg-success text-white mr-4">
								<i class="fa fa-briefcase"></i>
							</div>
							<div class="media-body">
								<h6 class="font-weight-bold mb-1"> Qualification</h6>
								<span></span>
								<p>{{$user->qualification}}</p>
							</div>
						</div>
					</div>
				</div>
                <div class="card-body border-top">
					<h5 class="font-weight-bold"><i class='bx bxs-location-plus'></i> Address &amp; Contact</h5>
					<div class="main-profile-contact-list d-lg-flex justify-content-around">
						<div class="media mr-5">
							<div class="media-icon bg-info text-white mr-4">
								<i class="fa fa-home"></i>
							</div>
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Address</h6>
								<span></span>
								<p>{{$user->current_address}}</p>
							</div>
						</div>
						<div class="media mr-4">
							<div class="media-icon bg-primary text-white  mr-3 mt-1">
								<i class="fa fa-phone"></i>
							</div>
							<div class="media-body">
								<small class="text-muted">Mobile</small>
								<div class="font-weight-normal1">
									<a href="tel:{{$user->phone_no}}">{{$user->phone_no}}</a>
								</div>
							</div>
						</div>
					</div>
				</div>
                <div class="card-body border-top">
					<h5 class="font-weight-bold"><i class="fas fa-info-circle"></i> Info</h5>
					<div class="main-profile-contact-list d-lg-flex justify-content-around">
						<div class="media mr-5">
							<div class="media-icon bg-info text-white mr-4">
								<i class="fas fa-user-md"></i>
							</div>
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Doctor Type</h6>
								<span></span>
								<p>{{$user->doctor_type}}</p>
							</div>
						</div>
						<div class="media mr-4">
							<div class="media-icon bg-primary text-white  mr-3 mt-1">
								<i class="fas fa-comment-dollar"></i>
							</div>
							<div class="media-body">
								<small class="text-muted">Doctor Fees</small>
								<div class="font-weight-normal1">
									<p>{{$user->doctor_fees}}</p>
								</div>
							</div>
						</div>
                        <div class="media mr-4">
							<div class="media-icon bg-warning text-white  mr-3 mt-1">
								<i class="fas fa-percent"></i>
							</div>
							<div class="media-body">
								<small class="text-muted">Doctor Charge Amount</small>
								<div class="font-weight-normal1">
									<p>{{$user->commission_amount}} {{$user->commission_type}}</p>
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
@endpush
