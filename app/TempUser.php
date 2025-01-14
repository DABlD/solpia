<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TempUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fname', 'mname', 'username',
        'lname', 'email', 'birthday', 'suffix', 
        'gender', 'address', 'contact', 
        'avatar', 'status'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'birthday'
    ];

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }
}
