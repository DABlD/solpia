<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationalBackground extends Model
{
    protected $fillable = [
    	'applicant_id','type','course',
    	'year','school','address'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
}
