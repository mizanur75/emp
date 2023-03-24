@extends('layouts.app')
@section('title','All')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
<style>

select.form-control:not([size]):not([multiple]) {
    height: 1.8rem;
    width: 3rem;
}
</style>
@endpush


@section('content')
<div class="row">
    <!-- Widget Item -->
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow text-right">
            <!-- Button trigger modal -->
            <a href="{{route('admin.schedule.create')}}" class="btn btn-padding btn-sm btn-primary">
                <i class="fa fa-plus"></i> Add New
            </a>
        </div>
    </div>
	<!-- Widget Item -->
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('success') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		@endif
			<div class="table-responsive mb-3">
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Department Name</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($schedules as $schedule)
						<tr class="text-center">
							<td>{{$loop->index +1}}</td>
							<td>{{$schedule->name}}</td>
							<td>{{$schedule->start_time}}</td>
							<td>{{$schedule->end_time}}</td>
							<td class="text-center">
{{--								<a href="{{route('admin.schedule.show',$schedule->id)}}" class="btn btn-padding btn-sm btn-info"><i class="fa fa-eye"></i></a>--}}
								<a href="{{route('admin.schedule.edit',$schedule->id)}}" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i></a>
{{--								<form action="{{route('admin.schedule.destroy', $schedule->id)}}" method="post"--}}
{{--									style="display: inline;"--}}
{{--									onsubmit="return confirm('Are you Sure? Want to delete')">--}}
{{--									@csrf--}}
{{--									@method('DELETE')--}}
{{--									<button class="btn btn-padding btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i>--}}
{{--									</button>--}}
{{--								</form>--}}
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- /Widget Item -->
</div>
@endsection


@push('scripts')

<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script>
	$("#tableId").dataTable();
</script>
@endpush
