<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\UserAttribute;
use Hash;

class User extends Authenticatable
{
    use Notifiable,
        SoftDeletes,
        UserAttribute;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role', 'fname', 'mname', 'username',
        'lname', 'email', 'birthday', 'suffix', 
        'gender', 'address', 'contact', 
        'password', 'email_verified_at',
        'applicant', 'avatar', 'status', 'fleet'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'birthday', 'email_verified_at'
    ];

    public function crew(){
        return $this->hasOne('App\Models\Applicant');
    }

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    public function ssap(){
        return $this->hasOne('App\Models\Ssap');
    }
}
