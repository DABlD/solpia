<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentMedCert extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
		'clinic', 'issue_date', 'expiry_date', 'applicant_id', 'type', 'number', 'issuer'
	];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'issue_date', 'expiry_date'
    ];
}
