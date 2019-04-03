<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentLC extends Model
{
	protected $fillables = ['issuer', 'no', 'issue_date', 'expiry_date'];

    protected $dates = [
        'issue_date', 'expiry_date', 'created_at', 'updated_at', 'deleted_at'
    ];
}
