<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentMed extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
		'type', 'with_mv', 'year', 'case_remarks', 'applicant_id'
	];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
