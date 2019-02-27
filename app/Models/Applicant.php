<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ApplicantAttribute;

class Applicant extends Model
{
    use ApplicantAttribute,
        SoftDeletes;

    protected $fillable = [
    	'user_id','birth_place','religion',
    	'provincial_address','provincial_contact',
    	'age','height','weight',
    	'bmi','blood_type','civil_status',
    	'tin','sss','waistline','shoe_size'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function educational_background(){
        return $this->hasMany('App\Models\EducationalBackground');
    }

    public function family_data(){
        return $this->hasMany('App\Models\FamilyData');
    }

    public function sea_service(){
        return $this->hasMany('App\Models\SeaService');
    }
}
