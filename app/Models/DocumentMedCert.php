<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentMedCert extends Model
{
	protected $fillable = [
		'clinic', 'issue_date', 'expiry_date', 'applicant_id', 'type', 'number'
	];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
