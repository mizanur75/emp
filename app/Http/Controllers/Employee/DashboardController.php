<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        return view('employee.index');
    }

}
