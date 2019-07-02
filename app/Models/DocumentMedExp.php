<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentMedExp extends Model
{
	protected $fillable = [
		'type', 'had', 'vaccine', 'applicant_id'
	];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
