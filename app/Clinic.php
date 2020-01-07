<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    //
    use SoftDeletes;
    protected $guarded = [];
    protected $appends = ['city'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function getCityAttribute()
    {
        return $this->city()->first()->name;
    }
}
