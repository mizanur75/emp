@extends('layouts.app')

@section('title','Admin Dashboard')

@push('css')
@endpush

@section('content')
<div class="row">
    <!-- Widget Item -->
    <!-- /Widget Item -->

{{--    <div class="col-md-3">--}}
{{--        <div class="widget-area proclinic-box-shadow color-yellow">--}}
{{--            <div class="widget-left">--}}
{{--                <span class="ti-employee"></span>--}}
{{--            </div>--}}
{{--            <div class="widget-right">--}}
{{--                <h4 class="wiget-title">User</h4>--}}
{{--                <span class="numeric">{{$users->count()}}</span>--}}
{{--                <p class="inc-dec mb-0"><span class="ti-angle-up"></span> +20% Increased</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

</div>

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
            <h3 class="widget-title">Employee Attendances</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Employee Name</th>
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
                            <td>{{$attendance->user->first_name}} {{$attendance->user->last_name}}</td>
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
                            <td>
                                @if($attendance->out_time)
                                    {{$durationString}}
                                @endif
                            </td>
                            <td>
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
    <!-- /Widget Item -->
</div>

@endsection

@push('scripts')
@endpush
