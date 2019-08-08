<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyData extends Model
{
	use SoftDeletes;
	
    protected $fillable = [
    	'applicant_id','type','name',
    	'age','birthday','address',
    	'occupation', 'email'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'birthday'
    ];
}
