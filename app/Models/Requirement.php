<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RequirementAttribute;

use App\Models\{Vessel, Rank, Candidate};

class Requirement extends Model
{
	use SoftDeletes, RequirementAttribute;

	protected $fillable = [
		'vessel_id', 'rank','joining_date','joining_port',
		'usv','salary','remarks','max_age','status','fleet',
        'date_provided'
	];

    protected $dates = [
        'created_at', 'updated_at', 'joining_date', 'deleted_at',
        'date_provided'
    ];

    public function vessel(){
        return $this->hasOne(Vessel::class, 'id', 'vessel_id');
    }

    public function rank(){
        return $this->hasOne(Rank::class, 'id', 'rank');
    }

    public function candidates(){
        return $this->hasMany(Candidate::class, 'requirement_id', 'id');
    }
}
