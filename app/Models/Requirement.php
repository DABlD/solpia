<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requirement extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'vessel_id', 'rank','joining_date','joining_port',
		'usv','salary','remarks','max_age','status','fleet'
	];

    protected $dates = [
        'created_at', 'updated_at', 'joining_date', 'deleted_at'
    ];
}
