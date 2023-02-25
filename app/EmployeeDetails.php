<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeDetails extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
}
