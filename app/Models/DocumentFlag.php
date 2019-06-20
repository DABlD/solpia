<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentFlag extends Model
{
    protected $fillable = [
    	'country', 'applicant_id', 'number', 'type',
    	'issue_date', 'expiry_date', 'rank'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'issue_date', 'expiry_date'
    ];
}
