<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\PrincipalAttribute;

class Principal extends Model
{
	use PrincipalAttribute;

    protected $fillable = [
    	'user_id', 'name', 'slug', 'fleet',
    	'full_name', 'address', 'contact', 'email'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
