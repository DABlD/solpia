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
    	'tin','sss','waistline','shoe_size',
        'clothes_size', 'eye_color'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function user(){
    	return $this->belongsTo('App\User')->withTrashed();
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

    public function document_id(){
        return $this->hasMany('App\Models\DocumentId');
    }

    public function document_flag(){
        return $this->hasMany('App\Models\DocumentFlag');
    }

    public function document_lc(){
        return $this->hasMany('App\Models\DocumentLC');
    }

    public function document_med_cert(){
        return $this->hasMany('App\Models\DocumentMedCert');
    }

    public function document_med(){
        return $this->hasMany('App\Models\DocumentMed');
    }

    public function document_med_exp(){
        return $this->hasMany('App\Models\DocumentMedExp');
    }

    public function pro_app(){
        return $this->hasOne('App\Models\ProcessedApplicant');
    }
}
