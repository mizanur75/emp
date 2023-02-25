<?php

namespace App\Http\Controllers\Admin;

use App\EmployeeAttendance;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        if(Auth::user()->role->name == 'Admin'){
            $attendances = EmployeeAttendance::orderBy('id','DESC')->where('created_at','>', now()->subWeek()->startOfWeek())
                ->where('created_at','>', now()->subWeek()->endOfWeek())->get();
            return view('admin.index', compact('attendances'));
        }else{
            $attendances = EmployeeAttendance::orderBy('id','DESC')->where('user_id',Auth::user()->id)->where('created_at','>', now()->subWeek()->startOfWeek())
                ->where('created_at','>', now()->subWeek()->endOfWeek())->get();
            return view('employee.index', compact('attendances'));
        }
    }
}
