@extends('layouts.app')
@section('title','Attendance Report')

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
            <div class="row mb-2">
                <div class="col-md-12">
                    <form action="{{$auth == 'Admin' ? route('admin.report') : route('employee.report')}}" method="GET">
                        <div class="row" style="margin-top: -8px;">
                            @if($auth == 'Admin')
                            <div class="col-md-3">
                                <input type="text" name="search_employee" class="form-control form-control-sm" placeholder="Search (Input employee name, email or Status)">
                            </div>
                            @endif
                            <div class="col-md-{{$auth == 'Admin'?3:4}}">
{{--                                <input type="text" name="from_date" class="form-control form-control-sm" placeholder="Enter From Date">--}}
                                <input type="text" name="from_date" id="start" class="form-control form-control-sm" placeholder="Start Date" @if($start) value="@if($start){{date('Y-m-d', strtotime($start))}}@endif" @endif autocomplete="off">
                            </div>
                            <div class="col-md-{{$auth == 'Admin'?3:4}}">
{{--                                <input type="text" name="to_date" class="form-control form-control-sm" placeholder="Enter to Date">--}}
                                <input type="text" name="to_date" id="finish" class="form-control form-control-sm" placeholder="End Date" @if($finish) value="{{date('Y-m-d', strtotime($finish))}}" @endif autocomplete="off">
                            </div>
                            <div class="col-md-{{$auth == 'Admin'?3:4}}">
                                <button class="btn btn-block btn-info float-right"> <i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
			<div class="table-responsive">
				<table id="attendance" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>SL</th>
                            @if($auth == 'Admin')
							<th>Name</th>
							<th>Email</th>
                            @endif
							<th>Date</th>
							<th>In Time</th>
							<th>In Status</th>
							<th>Out Time</th>
							<th>Out Status</th>
							<th>Total Time (H:M)</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($employee_attendances as $attendance)
						<tr class="text-center">
							<td>{{$loop->index + 1}}</td>
                            @if($auth == 'Admin')
                                <td>{{$attendance->first_name}} {{$attendance->last_name}}</td>
                                <td>{{$attendance->email}}</td>
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
                            </td>
                            <td>
                                @php
                                    $start_time =  date('H:i:s', strtotime($attendance->start_time));
                                    $in_time = date('H:i:s', strtotime($attendance->in_time));
                                    $checkTime = strtotime($start_time);
                                    $loginTime = strtotime($in_time);
                                    $in_status = $checkTime - $loginTime;
                                @endphp
                                @if($in_status < 0)
                                    <span class="badge badge-danger">Late! </span>
                                @else
                                    <span class="badge badge-success">Right Time! </span>
                                @endif
                            </td>
							<td>
                                @if($attendance->out_time)
                                    {{date('h:i a', strtotime($attendance->out_time))}}
                                @endif

                            </td>
                            <td>
                                @php
                                    $end_time =  date('H:i:s', strtotime($attendance->end_time));
                                    $out_t = date('H:i:s', strtotime($attendance->out_time));
                                    $checkTime = strtotime($end_time);
                                    $out_time = strtotime($out_t);
                                    $out_status = $out_time - $checkTime;
                                @endphp
                                @if($attendance->out_time)
                                    @if($out_status < 0)
                                        <span class="badge badge-danger">Due Time Away! </span>
                                    @elseif($out_status == 0)
                                        <span class="badge badge-success">Right Time! </span>
                                    @else
                                        <span class="badge badge-info">Over Time! </span>
                                    @endif
                                @endif
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
                                    <span id="absent" class="badge badge-danger">Absent</span>
                                @endif
                            </td>
						</tr>
						@endforeach
					</tbody>
				</table>
                @if($employee_attendances)
                    {{$employee_attendances->appends(Request::all())->links()}}
                @endif
			</div>
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
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script>
    function chec(){
        alert()
    }
    var role = '{{$auth}}';
    var prefix = role.toLowerCase();

        $("#in_time").change(function (){
            if($(this).prop('checked')) {
                var id = $(this).val();
                $.ajax({
                    url: "{{url('/')}}/"+prefix+"/in-time/"+id,
                    method: "GET",
                    success: function (data) {
                        $("div[data-toggle='toggle']").addClass('d-none');
                        $("#show_in_time").append(data);
                        $("#absent").addClass('d-none');
                        $("#status").html('<span class="badge badge-success">Present</span>');

                    }
                })
            }
        });


        $("#out_time").change(function (){
            if($(this).prop('checked')) {
                var id = $(this).val();
                $.ajax({
                    url: "{{url('/')}}/"+prefix+"/out-time/"+id,
                    method: "GET",
                    success: function (data) {
                        $("div[data-toggle='toggle']").addClass('d-none');
                        $("#show_out_time").append(data[0]);
                        $("#show_total_time").append(data[1]);

                    }
                })
            }
        });


</script>

<script>
	$('.select2').select2({
      theme: 'bootstrap4'
    });
    $(function() {
        $( "#start" ).datepicker({
            dateFormat: 'yy-mm-dd',
            maxDate: 0
        });
    });

    $(function() {
        $( "#finish" ).datepicker({
            dateFormat: 'yy-mm-dd',
            maxDate: 0
        });
    });
</script>
@endpush
