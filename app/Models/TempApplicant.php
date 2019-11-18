<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempApplicant extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'user_id','birth_place','religion',
    	'provincial_address','provincial_contact',
    	'age','height','weight',
    	'bmi','blood_type','civil_status',
    	'tin','sss','waistline','shoe_size',
        'clothes_size', 'eye_color'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function user(){
    	return $this->belongsTo('App\TempUser');
    }

    public function sea_service(){
        return $this->hasMany('App\Models\TempSeaService');
    }
}
