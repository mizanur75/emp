<?php

namespace App\Http\Controllers\Auth;

use App\EmployeeAttendance;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{


    use AuthenticatesUsers;

    protected $redirectTo;

    public function __construct()
    {
        if(Auth::check() && Auth::user()->role->name == 'Admin' ){
            $this->redirectTo = route('admin.dashboard');
        }else{
            $this->redirectTo = route('employee.dashboard');
        }
        $this->middleware('guest')->except('logout');
    }
    protected function credentials(Request $request)
    {
        // return $request->only($this->username(), 'password');
        return ['email' => $request->{$this->username()},'password'=> $request->password, 'status' => 'Active'];
    }
}
