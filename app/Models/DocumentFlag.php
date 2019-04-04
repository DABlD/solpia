<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentFlag extends Model
{
    protected $fillable = ['country', 'booklet_no', 'license_no', 'goc', 'sso', 'sdsd', 'applicant_id'];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
