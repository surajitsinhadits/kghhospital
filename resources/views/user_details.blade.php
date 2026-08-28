@extends('layouts.structure')
@push('title')
    <title>Appointments</title>
@endpush
@push('css')
@endpush
@section('main-content')
	<div class="col-xl-4 col-lg-3 col-md-12">
		<div class="card box-widget widget-user">
			<div class="widget-user-image mx-auto mt-5"><img  class="rounded-circle" src="{{ asset('public/profile_picture') }}/{{@$login_details->profile_image}}" style="height: 100px;width: 117px;"></div>
			<div class="card-body text-center">
				<div class="pro-user">
					<h4 class="pro-user-username text-dark mb-1 font-weight-bold">{{@$login_details->first_name}} {{@$login_details->last_name}}</h4>
					<h6 class="pro-user-desc text-muted">{{@$login_details->role}}</h6>

          
           
              	@if(auth()->user()->can('USER EDIT') || $login_details->id == Auth::id())
					<a href="{{route('user-edit',base64_encode($login_details->id))}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Profile"><i class="fa fa-edit"></i></a>	
                @endif

                @if($login_details->id == Auth::id())
					<a href="{{route('change-password')}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Change Password"><i class="fa fa-key"></i></a>
                @endif
                @can('USER DELETE')
                @if($login_details->id != Auth::id())
					<a href="{{route('user-delete',base64_encode($login_details->id))}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
				@endif
				@endcan


				</div>
			</div>
			<div class="card-body">
				<h4 class="card-title">Personal Details</h4>
				<div class="table-responsive">
					<table class="table mb-0">
						<tbody>
		
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Gender </span>
								</td>
								<td class="py-2 px-0">{{@$login_details->gender}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Age </span>
								</td>
								<td class="py-2 px-0">{{date('d-m-Y',strtotime(@$login_details->date_of_birth))}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Father's Name </span>
								</td>
								<td class="py-2 px-0">{{@$login_details->father_name}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Mother's Name </span>
								</td>
								<td class="py-2 px-0">{{@$login_details->mother_name}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Metrial Status </span>
								</td>
								<td class="py-2 px-0">{{@$login_details->marital_status}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Phone </span>
								</td>
								<td class="py-2 px-0">{{@$login_details->phone_no}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Blood Group </span>
								</td>
								<td class="py-2 px-0">{{@$login_details->blood_group}}</td>
							</tr>
			
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Department </span>
								</td>
								<td class="py-2 px-0">{{@$login_details->department_details->department_name}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Designation </span>
								</td>
								<td class="py-2 px-0">{{@$login_details->designation_details->designation_name}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Joining Date </span>
								</td>
								<td class="py-2 px-0">@if($login_details->date_of_joining != null || $login_details->date_of_joining != ''){{date('d-m-Y',strtotime(@$login_details->date_of_joining))}} @endif</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">Pan Number </span>
								</td>
								<td class="py-2 px-0">{{@$login_details->pan_number}}</td>
							</tr>
							<tr>
								<td class="py-2 px-0">
									<span class="font-weight-semibold w-50">{{ @$login_details->identification_name }} </span>
								</td>
								<td class="py-2 px-0">{{@$login_details->identification_number}}</td>
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
					<h5 class="font-weight-bold">Work & Education / Specialist</h5>
					<div class="main-profile-contact-list d-lg-flex">
						<div class="media mr-5">
							<div class="media-icon bg-success text-white mr-4">
								<i class="fa fa-briefcase"></i>
							</div>
							<div class="media-body">
								<h6 class="font-weight-bold mb-1"> Qualification</h6>
								<span></span>
								<p>{!!@$login_details->qualification!!}</p>
							</div>
						</div>
						<div class="media mr-5">
							<div class="media-icon bg-success text-white mr-4">
								<i class="fa fa-briefcase"></i>
							</div>
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Work Exprience</h6>
								<span></span>
								<p>{!!@$login_details->experience!!}</p>
							</div>
						</div>
						<div class="media mr-5">
							<div class="media-icon bg-success text-white mr-4">
								<i class="fa fa-briefcase"></i>
							</div>
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Specialist</h6>
								<span></span>
								<p>{!!@$login_details->specialist!!}</p>
							</div>
						</div>
	
					</div>
				</div>
				<div class="card-body border-top">
					<h5 class="font-weight-bold">Contact</h5>
					<div class="main-profile-contact-list d-lg-flex">
						<div class="media mr-4">
							<div class="media-icon bg-primary text-white  mr-3 mt-1">
								<i class="fa fa-phone"></i>
							</div>
							<div class="media-body">
								<small class="text-muted">Mobile</small>
								<div class="font-weight-normal1">
									<a href="tel:{{@$login_details->phone_no}}">{{@$login_details->phone_no}}</a> / 
									<a href="tel:{{$login_details->emg_phone_no}}">{{@$login_details->emg_phone_no}}</a>
								
								</div>
							</div>
						</div>
						<div class="media mr-4">
							<div class="media-icon bg-warning text-white mr-3 mt-1">
								<i class="fa fa-mail-bulk"></i>
							</div>
							<div class="media-body">
								<small class="text-muted">Mail</small>
								<div class="font-weight-normal1">
									<a href="mailto:{{$login_details->email}}">{{@$login_details->email}}</a>
								</div>
							</div>
						</div>
						
					</div><!-- main-profile-contact-list -->
				</div>
				<div class="card-body border-top">
					<h5 class="font-weight-bold"> Address</h5>
					<div class="main-profile-contact-list d-lg-flex">
						
						<div class="media mr-5">
							<div class="media-icon bg-info text-white mr-4">
								<i class="fa fa-home"></i>
							</div>
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Current Address</h6>
								<span></span>
								<p>{!!@$login_details->current_address!!}</p>
							</div>
						</div>
						<div class="media mr-5">
							<div class="media-icon bg-info text-white mr-4">
								<i class="fa fa-home"></i>
							</div>
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Local Addesss</h6>
								<span></span>
								<p>{!!@$login_details->permanent_address!!}</p>
							</div>
						</div>
					</div><!-- main-profile-contact-list -->
				</div>
				<div class="card-body border-top">
					<h5 class="font-weight-bold"> Bank Details</h5>
					<div class="main-profile-contact-list d-lg-flex">
						<div class="media mr-5">
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Bank Account No.</h6>
								<span></span>
								<p>{!!@$login_details->bank_account_no!!}</p>
							</div>
						</div>
						<div class="media mr-5">
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Bank Name.</h6>
								<span></span>
								<p>{!!@$login_details->bank_name!!}</p>
							</div>
						</div>
						<div class="media mr-5">
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">IFSC Code</h6>
								<span></span>
								<p>{!!@$login_details->ifsc_code!!}</p>
							</div>
						</div>
						<div class="media mr-5">
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Bank Branch Name</h6>
								<span></span>
								<p>{!!@$login_details->bank_branch_name!!}</p>
							</div>
						</div>
					</div><!-- main-profile-contact-list -->
				</div>
			
				<div class="card-body border-top">
					<h5 class="font-weight-bold"> Leave Details</h5>
					<div class="main-profile-contact-list d-lg-flex">
						<div class="media mr-5">
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Casual Leave</h6>
								<span></span>
								<p>{!!@$login_details->casual_leave!!}</p>
							</div>
						</div>
						<div class="media mr-5">
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Privilege Leave</h6>
								<span></span>
								<p>{!!@$login_details->privilege_leave!!}</p>
							</div>
						</div>
						<div class="media mr-5">
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Sick Leave</h6>
								<span></span>
								<p>{!!@$login_details->sick_leave!!}</p>
							</div>
						</div>
						<div class="media mr-5">
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Maternity Leave</h6>
								<span></span>
								<p>{!!@$login_details->maternity_leave!!}</p>
							</div>
						</div>
						<div class="media mr-5">
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Paternity Leave</h6>
								<span></span>
								<p>{!!@$login_details->paternity_leave!!}</p>
							</div>
						</div>
					</div><!-- main-profile-contact-list -->
				</div>
			
				<div class="card-body border-top">
					<h5 class="font-weight-bold"> Payroll / Contract Details</h5>
					<div class="main-profile-contact-list d-lg-flex">
						<div class="media mr-5">
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Basic Salary</h6>
								<span></span>
								<p>{!!@$login_details->basic_salary!!}</p>
							</div>
						</div>
						<div class="media mr-5">
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">EPF No.</h6>
								<span></span>
								<p>{!!@$login_details->epf_no!!}</p>
							</div>
						</div>
						<div class="media mr-5">
							<div class="media-body">
								<h6 class="font-weight-bold mb-1">Contract Type</h6>
								<span></span>
								<p>{!!@$login_details->contract_type!!}</p>
							</div>
						</div>
						
					</div><!-- main-profile-contact-list -->
				</div>
			</div>
		</div>
	</div>
@endsection
@push('js')
@endpush
