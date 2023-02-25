<?php

namespace App\Http\Controllers\Admin;

use App\EmployeeContact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeContactController extends Controller
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
            'contact_name' => 'required',
            'contact_email' => 'required'
        ]);
        try {
            $employeeContact = new EmployeeContact();
            $employeeContact->user_id = $request->employee_id;
            $employeeContact->contact_name = $request->contact_name;
            $employeeContact->contact_email = $request->contact_email;
            $employeeContact->save();
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
        $employeeContact = EmployeeContact::findOrFail($id);
        return response()->json($employeeContact);
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
            'contact_name' => 'required',
            'contact_email' => 'required'
        ]);
        try {
            $employeeContact = EmployeeContact::findOrFail($id);
            $employeeContact->user_id = $request->employee_id;
            $employeeContact->contact_name = $request->contact_name;
            $employeeContact->contact_email = $request->contact_email;
            $employeeContact->save();
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
