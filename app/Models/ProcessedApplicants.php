<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessedApplicants extends Model
{
    protected $fillable = [
    	'applicant_id', 'principal_id', 'vessel_id', 'rank_id', 'status'
    ];

    protected $dates = [
    	'created_at', 'updated_at'
    ];
}
