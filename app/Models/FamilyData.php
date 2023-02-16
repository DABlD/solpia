<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\FamilyDataAttribute;

class FamilyData extends Model
{
	use SoftDeletes,
        FamilyDataAttribute;

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
