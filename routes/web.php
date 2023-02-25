<?php

Auth::routes(['register' => false]);

//  ====================== Admi Route 1  =====================
Route::group(['as'=>'admin.','prefix' => 'admin','namespace'=>'Admin','middleware'=>['auth','admin']], function () {
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::resource('employee','EmployeeController');

    Route::resource('employee-details','EmployeeDetailsController');
    Route::resource('employee-contact','EmployeeContactController');
    Route::resource('attendance','EmployeeAttendanceController');
    Route::get('report','EmployeeAttendanceController@report')->name('report');


    Route::get('in-time/{id}','EmployeeAttendanceController@in_time')->name('in_time');
    Route::get('out-time/{id}','EmployeeAttendanceController@out_time')->name('out_time');

});

//  ============== User Route 2 =================

Route::group(['as'=>'employee.','prefix' => 'employee','namespace'=>'Admin','middleware'=>['auth','employee']], function () {
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::resource('employee','EmployeeController');
    Route::get('in-time/{id}','EmployeeAttendanceController@in_time')->name('in_time');
    Route::get('out-time/{id}','EmployeeAttendanceController@out_time')->name('out_time');

    Route::resource('attendance','EmployeeAttendanceController');

    Route::get('report','EmployeeAttendanceController@report')->name('report');

});

//  =========================== Social Login ============================
    Route::get('auth/{provider}', 'AuthController@redirectToProvider');
    Route::get('auth/{provider}/collback', 'AuthController@handleProviderCallback');

//  =========================== When Not Match Any Route ============================

Route::any('{query}','Front\FrontController@index')
  ->where('query', '.*');
