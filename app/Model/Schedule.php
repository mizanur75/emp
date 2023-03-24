<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function employee(){
        return $this->hasMany(User::class);
    }
}
