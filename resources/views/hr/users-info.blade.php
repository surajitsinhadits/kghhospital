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
			<div class="widget-user-image mx-auto mt-5"><img class="rounded-circle" src="{{$user->profile_img ? url('public/assets/images/users/'.$user->profile_img) : url('public/assets/images/users/users.png')}}" style="height: 100px;width: 117px;"></div>
			<div class="card-body text-center">
				<div class="pro-user">
					<h4 class="pro-user-username text-dark mb-1 font-weight-bold">{{$user->salutation}} {{$user->name}}</h4>
					<h6 class="pro-user-desc text-muted">{{$user->role}}</h6>
              		<a href="{{route('hr.edit-profile',ed($user->id, true))}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Profile"><i class="fa fa-edit"></i></a>
              		<a href="{{route('change-password')}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Change Password"><i class="fa fa-key"></i></a>
				</div>
			</div>
			<div class="card-body">
				<h4 class="card-title"><i class="fas fa-user-circle"></i> Personal Details</h4>
				<div class="table-responsive">
					<table class="table mb-0">
						<tbody>
                            <tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Employee ID </span>
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
									<span class="font-weight-semibold w-50">Date of Birth </span>
								</td>
								<td class="py-2 px-0">{{dateFor($user->dob)}}</td>
							</tr>
                            <tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Joining Date </span>
								</td>
								<td class="py-2 px-0">{{dateFor($user->joining_date)}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Father's Name </span>
								</td>
								<td class="py-2 px-0">{{$user->father_name}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Mother's Name </span>
								</td>
								<td class="py-2 px-0">{{$user->mother_name}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Metrial Status </span>
								</td>
								<td class="py-2 px-0">{{$user->marital_status}}</td>
							</tr>
                            <tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Blood Group </span>
								</td>
								<td class="py-2 px-0">{{$user->blood_group}}</td>
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
					<h5 class="font-weight-bold"><i class='bx bxs-briefcase'></i> Work &amp; Education</h5>
					<div class="main-profile-contact-list d-lg-flex justify-content-between">
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
								<h6 class="font-weight-bold mb-1">Note</h6>
								<span></span>
								<p>{{$user->note}}</p>
							</div>
						</div>
					</div>
				</div>
                <div class="card-body border-top">
					<h5 class="font-weight-bold"><i class='bx bxs-location-plus'></i> Address</h5>
					<div class="main-profile-contact-list d-lg-flex justify-content-around">
						<div class="media mr-5">
							<div class="media-icon bg-info text-white mr-4">
								<i class="fa fa-home"></i>
							</div>
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Current Address</h6>
								<span></span>
								<p>{{$user->current_address}}</p>
							</div>
						</div>
						<div class="media mr-5">
							<div class="media-icon bg-success text-white mr-4">
								<i class="fa fa-home"></i>
							</div>
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Permanent Addesss</h6>
								<span></span>
								<p>{{$user->permanent_address}}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body border-top">
					<h5 class="font-weight-bold"><i class='bx bxs-contact'></i> Contact</h5>
					<div class="main-profile-contact-list d-lg-flex justify-content-between">
						<div class="media mr-4">
							<div class="media-icon bg-warning text-white mr-3 mt-1">
								<i class="fa fa-mail-bulk"></i>
							</div>
							<div class="media-body">
								<small class="text-muted">Mail</small>
								<div class="font-weight-normal1">
									<a href="mailto:{{$user->email}}">{{$user->email}}</a>
								</div>
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
                        <div class="media mr-4">
							<div class="media-icon bg-success text-white  mr-3 mt-1">
								<i class="fab fa-whatsapp"></i>
							</div>
							<div class="media-body">
								<small class="text-muted">Whatsapp</small>
								<div class="font-weight-normal1">
									<a href="tel:{{$user->whatsapp_no}}">{{$user->whatsapp_no}}</a>
								</div>
							</div>
						</div>
                        <div class="media mr-4">
							<div class="media-icon bg-info text-white  mr-3 mt-1">
								<i class="fa fa-phone"></i>
							</div>
							<div class="media-body">
								<small class="text-muted">Emg. No</small>
								<div class="font-weight-normal1">
									<a href="tel:{{$user->emg_no}}">{{$user->emg_no}}</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body border-top">
					<h5 class="font-weight-bold"><i class='bx bxs-contact'></i> Identification</h5>
					<div class="main-profile-contact-list d-lg-flex justify-content-between">
						<div class="media mr-4">
							<div class="media-icon bg-warning text-white mr-3 mt-1">
								<i class="fas fa-id-badge"></i>
							</div>
							<div class="media-body">
								<small class="text-muted">PAN Number</small>
								<div class="font-weight-normal1">
									{{$user->pan_number}}
								</div>
							</div>
						</div>
                        <div class="media mr-4">
							<div class="media-icon bg-primary text-white  mr-3 mt-1">
								<i class="fas fa-id-badge"></i>
							</div>
							<div class="media-body">
								<small class="text-muted">Identification Name</small>
								<div class="font-weight-normal1">
									{{$user->identification_name}}
								</div>
							</div>
						</div>
                        <div class="media mr-4">
							<div class="media-icon bg-info text-white  mr-3 mt-1">
								<i class="fas fa-id-badge"></i>
							</div>
							<div class="media-body">
								<small class="text-muted">Identification Number</small>
								<div class="font-weight-normal1">
									{{$user->identification_number}}
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
