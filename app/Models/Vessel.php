<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VesselAttribute;

class Vessel extends Model
{
    use VesselAttribute;

    protected $fillable = [
    	'principal_id', 'name', 'flag', 'type', 'year_build',
    	'builder', 'engine', 'gross_tonnage', 'BHP', 'trade',
    	'ecdis', 'status', 'manning_agent'
    ];

    protected $dates = [
    	'created_at', 'updated_at'
    ];

    public function principal(){
    	return $this->belongsTo('App\Models\Principal');
    }
}
