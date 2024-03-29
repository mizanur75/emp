@extends('layouts.app')
@section('title','Employee Attendance')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('custom/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('css/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

<style>
select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
    width: 3rem;
}
.form-control {
    border-color: #064619;
}
.select2-container--bootstrap4 .select2-selection {
    border: 1px solid #646667;
    border-radius: .25rem;
    width: 100%;
}

.swal2-popup .swal2-modal .swal2-show{
	width: 26% !important;
}

.myPressButton { padding: 5px; border: 1px solid darkgreen; width: 130px; text-align: center; font-size: 12px; margin-left: auto; margin-right: auto; background-color: #fff;}

</style>

@endpush


@section('content')
@php
$auth = Auth::user()->role->name;
@endphp
<div class="row">
	<div class="col-md-12">
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('success') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		@endif
        @if(Session::has('error'))
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('error') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		@endif
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
	</div>
</div>
<div class="row">

    <!-- Attendance History -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">

{{--			<button class="btn btn-padding btn-sm btn-primary pull-right" data-toggle="modal" data-target="#addAttendanceModal"><i class="fa fa-plus"></i> Add New</button>--}}
            @if($auth == 'Employee')
                <h3 class="widget-title">Attendance</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th>In Time</th>
                                <th>Out Time</th>
                                <th>Status</th>
                            </tr>
                            <tr class="text-center">
                                @if($employee_attendances)
                                <td>
                                    @if($employee_attendances->in_time)
                                        {{date('h:i a', strtotime($employee_attendances->in_time))}}
                                    @else
                                    <button class="myPressButton myPressButtonIn btn btn-white" data-id="1">In Time</button>
                                    @endif
                                </td>
                                <td>
                                    @if($employee_attendances->out_time)
                                        {{date('h:i a', strtotime($employee_attendances->out_time))}}
                                    @else
                                        <button class="myPressButton @if($employee_attendances) myPressButtonOut @endif btn btn-white" data-id="1" value="{{$employee_attendances->id}}">Out Time</button>
                                    @endif
                                </td>
                                <td>
                                    @if($employee_attendances->in_time != null && $employee_attendances->out_time == null)
                                        Working
                                    @else
                                        Finished
                                    @endif
                                </td>
                                @else
                                <td>
                                    <button class="myPressButton myPressButtonIn btn btn-white" data-id="1">In Time</button>
                                </td>
                                <td>
                                    <button class="myPressButton @if($employee_attendances) myPressButtonOut @endif btn btn-white" data-id="1">Out Time</button>
                                </td>
                                <td>
                                </td>
                                @endif
                            </tr>
                        </thead>
                    </table>

                </div>
            @else
            <h3 class="widget-title">Attendance History</h3>
			<div class="table-responsive">
				<table id="attendance" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>SL</th>
                            @if($auth == 'Admin')
							<th>Name</th>
                            @endif
							<th>Date</th>
							<th>In Time</th>
							<th>Out Time</th>
							<th>Total Time (H:M)</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($employee_attendances as $attendance)
						<tr class="text-center">
							<td>{{$loop->index + 1}}</td>
                            @if($auth == 'Admin')
                                <td>{{$attendance->user->first_name}} {{$attendance->user->last_name}}</td>
                            @endif
							<td>{{date('d M Y', strtotime($attendance->created_at))}}</td>
							<td>

                                    @if($attendance->in_time)
                                        {{date('h:i a', strtotime($attendance->in_time))}}

                                    @else
                                        @if($auth == 'Employee')
                                            @if(date('d M Y', strtotime($attendance->created_at)) == date('d M Y', strtotime(now())))
                                                <input type="checkbox" name="in_time" id="in_time" value="{{$attendance->id}}" data-toggle="toggle" data-width="100" data-height="25">
                                            @endif
                                        @endif
                                    @endif
                                        <span id="show_in_time"></span>


                            </td>
							<td>
                                @if($attendance->out_time)
                                    {{date('h:i a', strtotime($attendance->out_time))}}
                                @else
                                    @if($auth == 'Employee')
                                        @if(date('d M Y', strtotime($attendance->created_at)) == date('d M Y', strtotime(now())))
                                            <input type="checkbox" name="out_time" id="out_time" value="{{$attendance->id}}" data-toggle="toggle" data-width="100" data-height="25">
                                        @endif
                                    @else
                                        <span class="text-warning">On Working</span>
                                    @endif
                                @endif
                                    <span id="show_out_time"></span>

                            </td>
                            @php
                                    $checkInTime = \Carbon\Carbon::parse($attendance->in_time);
                                    $checkOutTime = \Carbon\Carbon::parse($attendance->out_time);
                                    $duration = $checkOutTime->diff($checkInTime);
                                    $duration = $duration->format('%h:%I');
                            @endphp
                            <td>
                                <span id="show_total_time"></span>
                                @if($attendance->out_time)
                                    {{$duration}}
                                @endif
                            </td>
							<td id="status">
                                @if($attendance->status == 'Present')
                                    <span class="badge badge-success">Present</span>
                                @else
                                    <span id="absent{{$attendance->id}}" class="badge badge-danger">Absent</span>
                                @endif
                            </td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
            @endif
		</div>
	</div>

</div>


<!-- Add Modal -->

<style>
	.modal-content {
	    border-radius: 5px;
	}
</style>


<!-- End Employee Contact Modal -->
@endsection

@push('scripts')
<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/js/bootstrap-select.js')}}"></script>
<script src="{{asset('datetime_picker/jquery-ui.js')}}"></script>
<script src="{{asset('js/select2.full.min.js')}}"></script>
{{--<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>--}}
<script src="{{asset('assets/js/jquery.pressAndHold.min.js')}}"></script>
<script type="text/javascript">
    var role = '{{$auth}}';
    var prefix = role.toLowerCase();
    $(document).ready(function() {
        $(".myPressButtonIn").pressAndHold({
            holdTime: 1000,
            progressIndicatorColor: "green",
            progressIndicatorOpacity: 1
        });
        $(".myPressButtonIn").on('complete.pressAndHold', function(event) {
            console.log("complete");
            $.ajax({
                url: "{{url('/')}}/"+prefix+"/in-time/",
                method: "GET",
                success: function (data) {
                    location.reload();
                }
            })
        });

        $(".myPressButtonOut").pressAndHold({
            holdTime: 1000,
            progressIndicatorColor: "green",
            progressIndicatorOpacity: 0.3
        });
        $(".myPressButtonOut").on('complete.pressAndHold', function(event) {
            console.log("complete");
            var id = $(this).val();
            $.ajax({
                url: "{{url('/')}}/"+prefix+"/out-time/"+id,
                method: "GET",
                success: function (data) {
                    location.reload();
                }
            })
        });
    });
</script>
<script>
	$('.select2').select2({
      theme: 'bootstrap4'
    });
</script>
<script>

	$("#tableId").dataTable({
	    pageLength : 2,
	    lengthMenu: [[2, 10, 20], [2, 10, 20]]
	});
	$("#attendance").dataTable({
	    // pageLength : 1,
	    // lengthMenu: [[2, 10, 20], [2, 10, 20]]
	});
	$("#employee_contact").dataTable({
	    pageLength : 2,
	    lengthMenu: [[2, 10, 20], [2, 10, 20]]
	});
</script>
<script type="text/javascript">

	$( function() {
		$( "#epredate" ).datepicker({
			dateFormat: 'dd-mm-yy',
		});
	} );
</script>
@endpush
