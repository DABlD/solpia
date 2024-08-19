<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentLC extends Model
{
	use SoftDeletes;
	
	protected $table = 'document_l_cs';

	protected $fillable = [
		'type', 'issuer', 'no', 'issue_date', 'expiry_date', 
		'applicant_id', 'regulation', 'rank'
	];

    protected $dates = [
        'issue_date', 'expiry_date', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function rank2(){
        return $this->belongsTo('App\Models\Rank', 'rank', 'id');
    }
}