<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\WageAttribute;

class Wage extends Model
{
	use WageAttribute,
        SoftDeletes;

    protected $fillable = [
    	'rank_id','vessel_id','principal_id',
    	'currency','basic','leave_pay',
    	'fot','ot','sub_allow',
    	'retire_allow','sup_allow',
        'sr_pay', 'tanker_allow',
        'owner_allow', 'voyage_allow',
        'other_allow', 'engine_allow',
        'aca', 'total', 'imo',
        'ot_per_hour', 'leave_per_month'
    ];

    protected $dates = [
    	'created_at', 'updated_at', 'deleted_at'
    ];
}
