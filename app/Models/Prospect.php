<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prospect extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'name','birthday','age','contact','email',
		'usv','contracts','exp','availability','last_disembark',
		'location','previous_salary','previous_agency','remarks','status'
	];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'birthday', 'last_disembark',
    ];
}
