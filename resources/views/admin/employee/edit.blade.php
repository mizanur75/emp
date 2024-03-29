@extends('layouts.app')
@section('title','Edit')

@push('css')

@endpush


@section('content')
<div class="row">
	<!-- Widget Item -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			@if($errors->any())
			@foreach($errors->all() as $error)
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<strong>Opps!</strong> {{$error}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
			@endforeach
			@endif
			<form action="{{route('admin.employee.update',$user->id)}}" method="POST" enctype="multipart/form-data">
				@csrf
                @method('PUT')
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="dob">Role<sup class="text-danger">*</sup></label>
						<select name="role_id" id="" class="form-control form-control-sm">
							<option selected="false" disabled>Please Select a Role</option>
							@foreach($roles as $role)
							<option value="{{$role->id}}" {{$user->role_id == $role->id ? 'selected':''}}>{{$role->name}}</option>
							@endforeach
						</select>
					</div>
                    <div class="form-group col-md-6">
                        <label for="dob">Time Schedule<sup class="text-danger">*</sup></label>
                        <select name="schedule_id" id="" class="form-control form-control-sm">
                            <option selected="false" disabled>Please Select Schedule </option>
                            @foreach($schedules as $schedule)
                                <option value="{{$schedule->id}}" {{$schedule->id == $user->schedule_id ? 'selected':''}}>{{$schedule->name}} ({{$schedule->start_time}}-{{$schedule->end_time}})</option>
                            @endforeach
                        </select>
                    </div>
					<div class="form-group col-md-12">
						<label for="patient-name">First Name<sup class="text-danger">*</sup></label>
						<input type="text" name="first_name" class="form-control form-control-sm" value="{{$user->first_name}}" id="patient-name">
					</div>
					<div class="form-group col-md-12">
						<label for="patient-name">Last Name<sup class="text-danger">*</sup></label>
						<input type="text" name="last_name" class="form-control form-control-sm" value="{{$user->last_name}}" id="patient-name">
					</div>
					<div class="form-group col-md-12">
						<label for="email">Email<sup class="text-danger">*</sup></label>
						<input type="email" name="email" value="{{$user->email}}" readonly class="form-control form-control-sm" id="Email">
					</div>
					<div class="form-group col-md-12">
						<label for="exampleFormControlTextarea1">Password</label>
						<input type="password" autocomplete="off" class="form-control form-control-sm" name="password" value="{{$user->tmp_pass}}">
					</div>

					<div class="form-check col-md-12 mb-2">
						<div class="text-left">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" name="status" value="Active" {{$user->status == 'Active' ? 'checked':''}} id="ex-check-2">
								<label class="custom-control-label" for="ex-check-2">Status</label>
							</div>
						</div>
					</div>
					<div class="form-group col-md-12 mb-3">
						<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-refresh"></i> Update</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- /Widget Item -->
</div>
@endsection


@push('scripts')

@endpush
