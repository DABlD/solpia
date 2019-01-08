<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationalBackground extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'applicant_id','type','course',
    	'year','school','address'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
