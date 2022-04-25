<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ProcessedApplicantAttribute;

class ProcessedApplicant extends Model
{
    use ProcessedApplicantAttribute;

    protected $fillable = [
    	'applicant_id', 'principal_id', 'vessel_id', 'rank_id', 'status', 'mob'
    ];

    protected $dates = [
    	'created_at', 'updated_at'
        , 'eld' //EXPECTED LINEUP DATE
    ];

    public function applicant(){
        return $this->belongsTo('App\Models\Applicant');
    }

    public function principal(){
        return $this->belongsTo('App\Models\Principal');
    }

    public function vessel(){
    	return $this->belongsTo('App\Models\Vessel');
    }

    public function rank(){
    	return $this->belongsTo('App\Models\Rank');
    }
}
