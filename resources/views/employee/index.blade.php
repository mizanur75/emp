@extends('layouts.app')

@section('title','Employee Dashboard')

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
        <div class="col-md-6">
            <div class="widget-area-2 proclinic-box-shadow">
                <h3 class="widget-title">Attendance Summery</h3>
                <div id="lineMorris" class="chart-home"></div>
            </div>
        </div>
        <!-- /Widget Item -->
        <!-- Widget Item -->
        <div class="col-md-6">
            <div class="widget-area-2 proclinic-box-shadow">
                <h3 class="widget-title"> Employee Year by Year</h3>
                <div id="barMorris" class="chart-home"></div>
            </div>
        </div>
        <!-- /Widget Item -->
    </div>

    <div class="row">
        <!-- Widget Item -->
        <div class="col-md-12">
            <div class="widget-area-2 proclinic-box-shadow">
                <h3 class="widget-title">Attendances Summery</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="">
                        <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Date</th>
                            <th>In</th>
                            <th>Out</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $attendance)
                                <tr>
                                    <td>{{$loop->index +1}}</td>
                                    <td>{{date('d M Y', strtotime($attendance->created_at))}}</td>
                                    <td>
                                        @if($attendance->in_time)
                                            {{date('h:i a', strtotime($attendance->in_time))}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($attendance->out_time)
                                            {{date('h:i a', strtotime($attendance->out_time))}}
                                        @endif
                                    </td>
                                    @php
                                        $checkInTime = \Carbon\Carbon::parse($attendance->in_time);
                                        $checkOutTime = \Carbon\Carbon::parse($attendance->out_time);
                                        $duration = $checkOutTime->diff($checkInTime);
                                        $durationString = $duration->format('%h:%I');
                                    @endphp
                                    <td>{{$durationString}}</td>
                                    <td>
                                        @if($attendance->status == 1)
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
        <!-- /Widget Item -->
    </div>

@endsection

@push('scripts')
<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
    $()

@endpush
