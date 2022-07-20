<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ProspectAttribute;

class Prospect extends Model
{
	use ProspectAttribute, SoftDeletes;

	protected $fillable = [
		'name','birthday','age','contact','email',
		'usv','contracts','exp','availability','last_disembark',
		'location','previous_salary','previous_agency','remarks','status',
		'rank'
	];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'birthday', 'last_disembark',
    ];
}
