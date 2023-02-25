<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function employeContacts(){
        return $this->hasMany(EmployeeContact::class);
    }

    public function employee_attendances(){
        return $this->hasMany(EmployeeAttendance::class);
    }
    public function employee_details(){
        return $this->hasOne(EmployeeDetails::class);
    }


    protected $fillable = [
        'role_id','name', 'email', 'phone', 'password','status','social_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
