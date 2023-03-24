@extends('layouts.app')
@section('title','Edit')

@push('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

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
			<form action="{{route('admin.schedule.update',$schedule->id)}}" method="POST" enctype="multipart/form-data">
				@csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="patient-name">Department/Team Name<sup class="text-danger">*</sup></label>
                        <input type="text" required name="name" value="{{$schedule->name}}" class="form-control form-control-sm" placeholder="Name" id="patient-name">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="age">Start Time<sup class="text-danger">*</sup></label>
                        <input type="text" required autocomplete="off" name="start_time" value="{{$schedule->start_time}}" placeholder="Start Time" class="timepicker form-control form-control-sm" id="age">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="age">End Time<sup class="text-danger">*</sup></label>
                        <input type="text" required autocomplete="off" name="end_time" value="{{$schedule->end_time}}" placeholder="End Time" class="timepicker form-control form-control-sm" id="age">
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <script>
        $('.timepicker').timepicker({
            timeFormat: 'hh:mm p',
            interval: 30,
            minTime: '09',
            maxTime: '11:59pm',
            startTime: '09:00',
            dynamic: true,
            dropdown: true,
            scrollbar: true
        });
    </script>
@endpush
