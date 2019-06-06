<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Principal extends Model
{
    protected $fillable = [
    	'user_id', 'name', 'slug'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
