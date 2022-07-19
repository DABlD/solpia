<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interview extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'prospect_id','requirement_id',
		'status','remark'
	];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
