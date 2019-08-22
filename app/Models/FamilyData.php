<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyData extends Model
{
	use SoftDeletes;

    protected $table = "family_datas";
	
    protected $fillable = [
    	'applicant_id','type','fname',
    	'mname','lname','suffix',
        'age','birthday','address',
    	'occupation', 'email'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'birthday'
    ];
}
