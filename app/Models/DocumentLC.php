<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentLC extends Model
{
	protected $fillable = [
		'type', 'issuer', 'no', 'issue_date', 'expiry_date', 
		'applicant_id', 'regulation', 'rank'
	];

    protected $dates = [
        'issue_date', 'expiry_date', 'created_at', 'updated_at', 'deleted_at'
    ];
}