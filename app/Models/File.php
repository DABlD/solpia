<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'applicant_id', 'type', 'name',
	];

	protected $dates = [
    	'created_at', 'updated_at', 'deleted_at'
	];
}
