<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LineUpContract extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'applicant_id','principal_id','vessel_id',
    	'rank_id','joining_port','joining_date',
    	'months', 'status', 'reliever',
    	'disembarkation_date', 'disembarkation_port'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'joining_date', 'disembarkation_date'
    ];

    public function document_id(){
        return $this->hasMany('App\Models\DocumentId', 'applicant_id', 'applicant_id');
    }

    public function document_flag(){
        return $this->hasMany('App\Models\DocumentFlag', 'applicant_id', 'applicant_id');
    }

    public function document_lc(){
        return $this->hasMany('App\Models\DocumentLC', 'applicant_id', 'applicant_id');
    }

    public function document_med_cert(){
        return $this->hasMany('App\Models\DocumentMedCert', 'applicant_id', 'applicant_id');
    }

    public function vessel(){
        return $this->hasOne('App\Models\Vessel', 'id', 'vessel_id');
    }

    public function rank(){
        return $this->hasOne('App\Models\Rank', 'id', 'rank_id');
    }

    public function pa_reliever(){
        return $this->hasOne('App\Models\ProcessedApplicant', 'applicant_id', 'reliever');
    }

    public function applicant(){
        return $this->belongsTo('App\Models\Applicant');
    }
}
