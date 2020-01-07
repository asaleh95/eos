<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $table='city';

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function clinics()
    {
        return $this->hasMany('App\Clinic');
    }
}
