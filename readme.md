# Employee Management
composer create-project --prefer-dist laravel/laravel patient "5.7.*"

# Multi Authenticate define

    php artisan make:auth
    
Make role model and table

    php artisan make:model Role -m

Create Role User table seeder

    php artisan make:seed RolesTableSeeder
    php artisan make:seed UsersTableSeeder

Seed data into roles and users seeder class

    DB::table('roles')->insert([
        'name' => 'Admin',
    ])
    
    DB::table('roles')->insert([
        'name' => 'Employee',
    ])
    
    DB::table('users')->insert([
        'role_id' => 1,
        'first_name' => 'Super',
        'last_name' => 'admin',
        'email' => 'admin@email.com',
        'status' => 'Active',
        'password' => bcrypt('11111111'),
    ]);
    DB::table('users')->insert([
        'role_id' => 2,
        'first_name' => 'MD',
        'last_name' => 'Employee',
        'email' => 'employee@email.com',
        'status' => 'Active',
        'password' => bcrypt('22222222'),
    ]);

# Migration

    php artisan migrate
    php artisan db:seed
    
check relationship

# Create controller

Create controller for different user

    php artisan make:controller Admin/DashboardController
    php artisan make:controller Employee/DashboardController
    
# Create Middleware

create middleware to protect route

    php artisan make:middleware AdminMiddleware
    php artisan make:middleware EmployeeMiddleware

Now register middleware in Kernel.php

# Define Route

    Route::group(['as'=>'admin.','prefix' => 'admin','namespace'=>'Admin','middleware'=>['auth','admin']], function () {
        Route::get('dashboard','AdminDashboard@index')->name('dashboard');
    
    });

    Route::group(['as'=>'employee.','prefix' => 'employee','namespace'=>'Employee','middleware'=>['auth','employee']], function () {
        Route::get('dashboard','EmployeeDashboard@index')->name('dashboard');

    });
    
# Create blade and layout for different dashboard

# Logic Implement for diffrent user into middleware

    //Check Authenticate or not
    //AdminMiddleware
    if(Auth::check() && Auth::user()->role->id == 1){
        return $next($request);
    }else{
        return redirect()->route('login');
    }
    
    //EmployeeMiddleware
    if(Auth::check() && Auth::user()->role->id == 1){
        return $next($request);
    }else{
        return redirect()->route('login');
    }
    
    //Redirect if Authenticate
    if (Auth::guard($guard)->check() && Auth::user()->role->id == 1 ) {
        return redirect()->route('admin.dashboard');
    }elseif (Auth::guard($guard)->check() && Auth::user()->role->id == 2) {
        return redirect()->route('employee.dashboard');
    }else {
        return $next($request);
    }
    
# Login iplement in login register controller

    if(Auth::check() && Auth::user()->role->id == 1 ){
        $this->redirectTo = route('admin.dashboard');
    } else {
        $this->redirectTo = route('employee.dashboard');
    }
    $this->middleware('guest')->except('logout');
    
