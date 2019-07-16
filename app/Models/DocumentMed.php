<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentMed extends Model
{
	protected $fillable = [
		'type', 'with_mv', 'year', 'case_remarks', 'applicant_id'
	];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
