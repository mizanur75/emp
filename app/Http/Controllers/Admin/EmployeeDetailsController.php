<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EmployeeDetails;

class EmployeeDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request, [
            'address' => 'required',
            'photo' => 'required'
        ]);

        $image = $request->file('photo');

        if (isset($image)){
            $imagename = $request->employee_id.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!file_exists('images/employee')){
                mkdir('images/employee', 777, true);
            }
            $image->move('images/employee',$imagename);
        }
        try {
            $employeeDetails = new EmployeeDetails();
            $employeeDetails->user_id = $request->employee_id;
            $employeeDetails->address = $request->address;
            $employeeDetails->photo = $imagename;
            $employeeDetails->save();
            return back()->with('success','Success!');
        } catch (\Exception $exception){
            return back()->with('error','Opps! Something wrong!');
        }
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
        $ed = EmployeeDetails::where('user_id',$id)->first();

        return response()->json($ed);
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
        $this->validate($request, [
            'address' => 'required',
        ]);

        $image = $request->file('photo');
        $employeeDetails = EmployeeDetails::where('user_id',$id)->first();
        if (isset($image)){
            $imagename = $request->employee_id.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (file_exists('images/employee/'.$employeeDetails->photo)){
                unlink('images/employee/'.$employeeDetails->photo);
            }
            $image->move('images/employee',$imagename);
        }else{
            $imagename = $employeeDetails->photo;
        }
        try {

            $employeeDetails->user_id = $request->employee_id;
            $employeeDetails->address = $request->address;
            $employeeDetails->photo = $imagename;
            $employeeDetails->save();
            return back()->with('success','Success!');
        } catch (\Exception $exception){
            return back()->with('error','Opps! Something wrong!');
        }
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
