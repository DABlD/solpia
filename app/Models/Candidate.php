<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CandidateAttribute;

use App\Models\{Vessel, Applicant, Requirement, Prospect};

class Candidate extends Model
{
    use CandidateAttribute;

    protected $fillable = [
        'applicant_id','requirement_id','prospect_id','vessel_id','initial_interview',
        'written_assessment','technical_interview', 'endorsed_to_crewing', 'principals_approval',
        'medical','on_board','remarks','status'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function vessel(){
        return $this->hasOne(Vessel::class, 'id', 'vessel_id');
    }

    public function requirement(){
        return $this->hasOne(Requirement::class, 'id', 'requirement_id');
    }

    public function prospect(){
        return $this->hasOne(Prospect::class, 'id', 'prospect_id');
    }

    public function applicant(){
        return $this->hasOne(Applicant::class, 'id', 'applicant_id');
    }
}
