@extends('layouts.app')
@section('title','Details of '.$employee->first_name)

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
	<!-- Employee Details -->
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
            @if($auth == 'Admin')
                @if(empty($employee->employee_details) == false)
                    <button type="button" class="btn btn-padding btn-sm btn-primary pull-right" data-toggle="modal" data-target="#editEmployeeDetailsModal" onclick="edit({{$employee->id}})"><i class="fa fa-edit"></i></button>
                @else
                    <button type="button" class="btn btn-padding btn-sm btn-primary pull-right" data-toggle="modal" data-target="#addEmployeeDetailsModal"><i class="fa fa-plus"></i></button>
                @endif
            @endif

            <h3 class="widget-title">Employee Details </h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td style="width: 22%;" class="text-center">
                                @if($employee->employee_details)
								<img class="w-100" style="height: 140px; border-radius: 4px;" src="{{asset('images/employee/'.$employee->employee_details->photo)}}">
                                @else
                                    Photo
                                @endif
							</td>
							<td>
								<table class="table table-bordered table-striped">
									<tbody>
										<tr>
											<td><strong>ID</strong></td>
											<td>{{$employee->id}}</td>
										</tr>
										<tr>
											<td><strong>Name</strong></td>
											<td>{{$employee->first_name}} {{$employee->last_name}}</td>
										</tr>
										<tr>
											<td><strong>Email</strong></td>
											<td>{{$employee->email}}</td>
										</tr>
                                        @if($employee->employee_details)
										<tr>
											<td><strong>Address</strong></td>
											<td>{{$employee->employee_details->address}}</td>
										</tr>
                                        @endif
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- Appoint History -->
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
            @if($auth == 'Admin')
            <button class="btn btn-padding btn-sm btn-primary pull-right" data-toggle="modal" data-target="#addEmployeeContactmodal"><i class="fa fa-plus"></i> Add New</button>
            @endif
            <h3 class="widget-title">Employee Contacts</h3>
			<div class="table-responsive">
				<table id="employee_contact" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Contact Name</th>
							<th>Contact Email</th>
                            @if($auth == 'Admin')
							<th>Action</th>
                            @endif
						</tr>
					</thead>
						@foreach($employee->employeContacts as $contact)
						<tr>
							<td>{{$loop->index + 1}}</td>
							<td>{{$contact->contact_name}}</td>
							<td>{{$contact->contact_email}}</td>
                            @if($auth == 'Admin')
							<td class="text-center">
                                <button type="button" class="btn btn-padding btn-sm btn-info" data-toggle="modal" data-target="#editEmployeeContactModal" onclick="editContact({{$contact->id}})"><i class="fa fa-edit"></i></button>
                            </td>
                            @endif
						</tr>
						@endforeach
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
    <!-- Attendance History -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
            @if($auth == 'Employee')
{{--			<button class="btn btn-padding btn-sm btn-primary pull-right" data-toggle="modal" data-target="#addAttendanceModal"><i class="fa fa-plus"></i> Add New</button>--}}
            @endif
            <h3 class="widget-title">Attendance History</h3>
			<div class="table-responsive">
				<table id="attendance" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>SL</th>
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
							<td>{{date('d M Y', strtotime($attendance->created_at))}}</td>
							<td>
                                @if($attendance->in_time)
                                    {{date('h:i a', strtotime($attendance->in_time))}}
                                @else
                                    <input type="checkbox" name="in_time" id="in_time" value="{{$attendance->id}}" data-toggle="toggle" data-width="100" data-height="25">
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
                                    $durationString = $duration->format('%h:%I');
                            @endphp
                            <td>
                                <span id="show_total_time"></span>
                                @if($attendance->out_time)
                                    {{$durationString}}
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


<!-- Employee Details -->
<div class="modal fade" id="addEmployeeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeDetailsModal" aria-hidden="true">
  	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addEmployeeDetailsModal">Add Employee Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
	      	<form action="{{route('admin.employee-details.store')}}" method="POST" enctype="multipart/form-data">
		      	@csrf
		      	<input type="hidden" name="employee_id" value="{{$employee->id}}">
				<div class="modal-body">
					<div class="row">
                        <div class="form-group col-md-12">
                            <label for="address">Address</label> <span class="text-danger">*</span>
                            <textarea name="address" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="photo">Photo</label> <span class="text-danger">*</span>
                            <input type="file" name="photo" id="photo" class="form-control">
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-padding btn-sm btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
					<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
				</div>
	      	</form>
	    </div>
  	</div>
</div>
<!-- End Add Modal -->
<!-- Employee Details -->
<div class="modal fade" id="addAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="addAttendanceModal" aria-hidden="true">
  	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addAttendanceModal">Add Employee Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
	      	<form action="{{route('admin.employee-details.store')}}" method="POST" enctype="multipart/form-data">
		      	@csrf
		      	<input type="hidden" name="employee_id" value="{{$employee->id}}">
				<div class="modal-body">
					<div class="row">
                        <div class="form-group col-md-12">
                            <label for="address">Address</label> <span class="text-danger">*</span>
                            <textarea name="address" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="photo">Photo</label> <span class="text-danger">*</span>
                            <input type="file" name="photo" id="photo" class="form-control">
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-padding btn-sm btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
					<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
				</div>
	      	</form>
	    </div>
  	</div>
</div>
<!-- End Add Modal -->
<!-- Employee Contact -->
<div class="modal fade" id="addEmployeeContactmodal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeContactmodal" aria-hidden="true">
  	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addEmployeeContactmodal">Add Employee Contact</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
	      	<form action="{{route('admin.employee-contact.store')}}" method="POST">
		      	@csrf
		      	<input type="hidden" name="employee_id" value="{{$employee->id}}">
				<div class="modal-body">
					<div class="row">
                        <div class="form-group col-md-12">
                            <label for="contact_name">Contact Name</label> <span class="text-danger">*</span>
                            <input type="text" name="contact_name" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="contact_email">Contact Email</label> <span class="text-danger">*</span>
                            <input type="text" name="contact_email" class="form-control form-control-sm">
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-padding btn-sm btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
					<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
				</div>
	      	</form>
	    </div>
  	</div>
</div>
<!-- End Add Modal -->

<!-- Edit Employee Details Modal -->
<div class="modal fade" id="editEmployeeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" id="editemployeeDetails">
	</div>
</div>
<!-- End Add Modal -->
<!-- Edit Employee Contact Modal -->
<div class="modal fade" id="editEmployeeContactModal" tabindex="-1" role="dialog" aria-labelledby="editEmployeeContactModal" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" id="editemployeeContact">
	</div>
</div>
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
                    console.log(data);
                    $("div[data-toggle='toggle']").addClass('d-none');
                    $("#show_out_time").append(data[0]);
                    $("#show_total_time").append(data[1]);

                }
            })
        }
    });
    function edit(id){
        $("#editemployeeDetails").empty();
        $("#edittreat").empty();
        $.ajax({
            url: '{{route('admin.employee-details.edit', $employee->id)}}',
            type: 'GET',
            success:function(data){
                console.log(data.address);
                $("#editemployeeDetails").append(
                    '<div class="modal-content">'+
                        '<div class="modal-header">'+
                            '<h5 class="modal-title" id="exampleModalLabel">Edit Employee Details </h5>'+
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                            '<span aria-hidden="true">&times;</span>'+
                            '</button>'+
                        '</div>'+
                        '<form action="{{route('admin.employee-details.update', $employee->id)}}" method="POST" enctype="multipart/form-data">'+
                            '@csrf'+
                            '@method("PUT")'+
                            '<input type="hidden" name="employee_id" value="{{$employee->id}}">'+
                            '<div class="modal-body">'+
                                '<div class="row">'+
                                    '<div class="form-group col-md-12">'+
                                        '<label for="address">Address</label> <span class="text-danger">*</span>'+
                                        '<textarea name="address" class="form-control " required>'+data.address+'</textarea>'+
                                    '</div>'+
                                    '<div class="form-group col-md-12">'+
                                        '<label for="photo">Photo</label> <span class="text-danger">*</span>'+
                                        '<input type="file" name="photo" id="photo" class="form-control">'+
                                        '<img class="w-25" src="{{asset('images/employee')}}/'+data.photo+'" />'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="modal-footer">'+
                                '<button type="button" class="btn btn-padding btn-sm btn-danger pull-left" data-dismiss="modal">Close</button>'+
                                '<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>'+
                            '</div>'+
                        '</form>'+
                    '</div>'
                );
            }
        })
    };
    function editContact(id){
        $("#editemployeeContact").empty();
        var url = "{{url('/')}}"+'/admin/employee-contact/'+id+'/edit';
        var updateUrl = "{{url('/')}}/admin/employee-contact/"+ id;
        console.log(url);
        $.ajax({
            url: url,
            type: 'GET',
            success:function(data){
                $("#editemployeeContact").append(
                    '<div class="modal-content">'+
                        '<div class="modal-header">'+
                            '<h5 class="modal-title" id="editEmployeeContactModal">Edit Employee Contact </h5>'+
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                            '<span aria-hidden="true">&times;</span>'+
                            '</button>'+
                        '</div>'+
                        '<form action="'+updateUrl+'" method="POST">'+
                            '@csrf'+
                            '@method("PUT")'+
                            '<input type="hidden" name="employee_id" value="{{$employee->id}}">'+
                            '<div class="modal-body">'+
                                '<div class="row">'+
                                    '<div class="form-group col-md-12">'+
                                        '<label for="contact_name">Contact Name</label> <span class="text-danger">*</span>'+
                                        '<input type name="contact_name" value="'+data.contact_name+'" class="form-control form-control-sm" required>'+
                                    '</div>'+
                                    '<div class="form-group col-md-12">'+
                                        '<label for="contact_email">Contact Email</label> <span class="text-danger">*</span>'+
                                        '<input type name="contact_email" value="'+data.contact_email+'" class="form-control form-control-sm" required>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="modal-footer">'+
                                '<button type="button" class="btn btn-padding btn-sm btn-danger pull-left" data-dismiss="modal">Close</button>'+
                                '<button type="submit" class="btn btn-padding btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>'+
                            '</div>'+
                        '</form>'+
                    '</div>'
                );
            }
        })
    };

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
