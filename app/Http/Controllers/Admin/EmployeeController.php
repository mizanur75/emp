<?php

namespace App\Http\Controllers\Admin;

use App\EmployeeAttendance;
use App\Http\Controllers\Controller;
use App\Model\Schedule;
use App\Role;
use App\User;
use App\Order;
use App\Model\Chamber;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function index()
    {

        $users = User::orderBy('id','DESC')->where('role_id', '>', 1)->get();
        return view('admin.employee.all',compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $schedules = Schedule::all();
        return view('admin.employee.add',compact('roles','schedules'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'schedule_id' => 'required',
            'role_id' => 'required',
            'first_name' => 'required',
            'first_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = new User();
        $user->schedule_id = $request->schedule_id;
        $user->role_id = $request->role_id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->tmp_pass = $request->password;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('admin.employee.index')->with('success','Added Successfully!');
    }

    public function show($id)
    {
        $employee = User::findOrFail($id);
        $employee_attendances = EmployeeAttendance::where('user_id',$id)->orderBy('id','DESC')->get();
        return view('admin.employee.details', compact('employee','employee_attendances'));
    }


    public function edit($id)
    {
        $roles = Role::all();
        $schedules = Schedule::all();
        $user = User::find($id);
        return view('admin.employee.edit', compact('user','roles','schedules'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'schedule_id' => 'required',
            'role_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        $user = User::find($id);

        $user->schedule_id = $request->schedule_id;
        $user->role_id = $request->role_id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->status = $request->status == null ? '' : $request->status;
        $user->tmp_pass = $request->password;
        $user->password = bcrypt($request->password == null ? $user->tmp_pass: $request->password);
        $user->save();
        return redirect()->route('admin.employee.index')->with('success','Updated Successfully!');
    }


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return back()->with('success','Deleted!');
    }

    public function status(Request $request, $id)
    {
        User::where('id',$id)->update(['status' => $request->status]);
        return back()->with('success','Status Changed!');
    }
}
