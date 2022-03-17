<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wage extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'rank_id','vessel_id','principal_id',
    	'currency','basic','leave_pay',
    	'fot','ot','sub_allow',
    	'retire_allow','sup_allow',
        'sr_pay', 'tanker_allow',
        'owner_allow', 'voyage_allow',
        'other_allow', 'engine_allow',
        'aca', 'total', 'imo'
    ];

    protected $dates = [
    	'created_at', 'updated_at', 'deleted_at'
    ];
}
