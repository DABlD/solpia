<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentId extends Model
{
	use SoftDeletes;

    protected $fillable = ['type', 'number', 'issue_date', 'expiry_date', 'applicant_id', 'issuer'];

    protected $dates = [
        'issue_date', 'expiry_date', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function applicant(){
        return $this->belongsTo('App\Models\Applicant');
    }
}
