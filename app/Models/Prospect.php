<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ProspectAttribute;

use App\Models\Candidate;

class Prospect extends Model
{
	use ProspectAttribute, SoftDeletes;

	protected $fillable = [
		'name','birthday','age','contact','email',
		'usv','contracts','exp','availability','last_disembark',
		'location','previous_salary','previous_agency','remarks','status',
		'rank', 'height', 'weight',
		'file', 'updated_at', 'source'
	];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'birthday', 'last_disembark',
    ];

    public function candidates(){
        return $this->hasMany(Candidate::class, 'prospect_id', 'id');
    }
}
