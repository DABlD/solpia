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
}
