<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyData extends Model
{
    protected $fillable = [
    	'applicant_id','type','name',
    	'age','birthday','address',
    	'occupation'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'birthday'
    ];
}
