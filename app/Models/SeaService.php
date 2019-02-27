<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeaService extends Model
{
	protected $fillable = [
		
	];

    protected $dates = [
        'sign_on', 'sign_off', 'created_at', 'updated_at'
    ];
}
