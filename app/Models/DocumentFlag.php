<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentFlag extends Model
{
	use SoftDeletes;
	
    protected $fillable = [
    	'country', 'applicant_id', 'number', 'type',
    	'issue_date', 'expiry_date', 'rank'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'issue_date', 'expiry_date'
    ];

    public function rankz(){
        return $this->belongsTo('App\Models\Rank', 'rank', 'id');
    }
}
