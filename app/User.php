<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password','mobile'
    // ];

    protected $guarded = [];
    protected $appends = ['country','city'];

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

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function clinics()
    {
        return $this->hasMany('App\Clinic');
    }

    public function visits()
    {
        return $this->hasMany('App\Visit');
    }

    public function meetings()
    {
        return $this->hasMany('App\Meeting');
    }

    public function getCountryAttribute()
    {
        return $this->country()->first()->name;
    }

    public function getCityAttribute()
    {
        return $this->city()->first()->name;
    }

    public function getQrcodeAttribute()
    {
        if (!empty($this->attributes['qrcode'])) {
            return base64_encode(\QrCode::format('png')->size(399)->color(40,40,40)->generate($this->attributes['qrcode']));
        }
    }
}
