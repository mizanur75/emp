<?php

namespace App\Http\Controllers\Admin;

use App\EmployeeAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeAttendanceController extends Controller
{
    public function inireport(Request $request){

        $start =  null;
        $finish = null;
        $search_value = $request->input('search_employee');
        if (Auth::user()->role->name == 'Admin'){
            $employee_attendances = DB::table('users as u')
                ->join('employee_attendances as ea', 'u.id','=','ea.user_id')
                ->join('schedules as s', 's.id','=','u.schedule_id')
                ->orderBy('u.id','DESC')
                ->select('u.*','s.name as team_name','s.start_time as start_time','s.end_time as end_time','ea.in_time as in_time','ea.out_time as out_time','ea.created_at as created_at','ea.status as status')
                ->paginate(20);
//            return $employee_attendances;
        }else{
            $employee_attendances = DB::table('users as u')
                ->join('employee_attendances as ea', 'u.id','=','ea.user_id')
                ->join('schedules as s', 's.id','=','u.schedule_id')
                ->where('u.id',Auth::user()->id)
                ->orderBy('u.id','DESC')
                ->select('u.*','s.name as team_name','s.start_time as start_time','s.end_time as end_time','ea.in_time as in_time','ea.out_time as out_time','ea.created_at as created_at','ea.status as status')
                ->paginate(20);
        }
        return view('admin.employee.report',compact('employee_attendances','start', 'finish'));
    }
    public function report(Request $request){

        $start = $request->from_date;
        $finish = $request->to_date;
        $search_value = $request->input('search_employee');
        if (Auth::user()->role->name == 'Admin'){
            $employee_attendances = DB::table('users as u')
                ->join('employee_attendances as ea', 'u.id','=','ea.user_id')
                ->join('schedules as s', 's.id','=','u.schedule_id')
                ->where(function ($query) use ($search_value){
                    $query->where('u.first_name','LIKE','%'.$search_value.'%')
                        ->orWhere('u.last_name','LIKE','%'.$search_value.'%')
                        ->orWhere('u.email','LIKE','%'.$search_value.'%')
                        ->orWhere('u.status','LIKE','%'.$search_value.'%');
                })
                ->whereBetween('ea.c_date', [$start, $finish])
                ->orderBy('u.id','DESC')
                ->select('u.*','s.name as team_name','s.start_time as start_time','s.end_time as end_time','ea.in_time as in_time','ea.out_time as out_time','ea.created_at as created_at','ea.status as status')
                ->paginate(20);
//            return $employee_attendances;
        }else{
            $employee_attendances = DB::table('users as u')
                ->join('employee_attendances as ea', 'u.id','=','ea.user_id')
                ->join('schedules as s', 's.id','=','u.schedule_id')
                ->where(function ($query) use ($search_value){
                    $query->where('u.first_name','LIKE','%'.$search_value.'%')
                        ->orWhere('u.last_name','LIKE','%'.$search_value.'%')
                        ->orWhere('u.email','LIKE','%'.$search_value.'%')
                        ->orWhere('u.status','LIKE','%'.$search_value.'%');
                })
                ->whereBetween('ea.c_date', [$start, $finish])
                ->where('u.id',Auth::user()->id)
                ->orderBy('u.id','DESC')
                ->select('u.*','s.name as team_name','s.start_time as start_time','s.end_time as end_time','ea.in_time as in_time','ea.out_time as out_time','ea.created_at as created_at','ea.status as status')
                ->paginate(20);
        }
        return view('admin.employee.report',compact('employee_attendances','start', 'finish'));
    }
    public function in_time(){
        $ea = new EmployeeAttendance;
        $ea->user_id = Auth::user()->id;
        $ea->in_time = now();
        $ea->status = 'Present';
        $ea->c_date = date('Y-m-d', strtotime(now()));
        $ea->save();
        $in_time = date('h:i a', strtotime($ea->in_time));
        return response()->json($in_time);
    }
    public function out_time($id){
        $ea = EmployeeAttendance::findOrFail($id);
        $ea->out_time = now();
        $ea->save();
        $out_time = date('h:i a', strtotime($ea->out_time));
        $checkInTime = Carbon::parse($ea->in_time);
        $checkOutTime = Carbon::parse($ea->out_time);
        $duration = $checkOutTime->diff($checkInTime);
        $durationString = $duration->format('%h:%I');
        return response()->json([$out_time, $durationString]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role->name == 'Admin'){
            $employee_attendances = EmployeeAttendance::orderBy('id','DESC')->get();
        }else{
            $employee_attendances = EmployeeAttendance::orderBy('id','DESC')->where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.date('Y-m-d', strtotime(now())).'%')->latest()->first();
        }

//        dd($employee_attendances);

        return view('admin.employee.attendance',compact('employee_attendances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
