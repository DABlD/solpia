<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentFlag extends Model
{
    protected $fillable = [
    	'country', 'booklet_no', 'license_no', 'goc', 'sso', 'sdsd', 'applicant_id',
    	'issue_date', 'expiry_date'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'issue_date', 'expiry_date'
    ];
}
