<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeaService extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
		'vessel_name','rank','vessel_type','gross_tonnage','engine_type','bhp_kw','flag','trade','previous_salary','manning_agent','principal','crew_nationality','sign_on','sign_off','total_months','remarks', 'applicant_id',
		'smc'
	];

    protected $dates = [
        'sign_on', 'sign_off', 'created_at', 'updated_at'
    ];
}
