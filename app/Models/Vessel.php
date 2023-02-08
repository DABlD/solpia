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
    	'ecdis', 'status', 'manning_agent', 'imo', 'fleet', 'particulars',
        'owner', 'size',
        'former_agency', 'former_principal', 'mlc_shipowner', 'mlc_shipowner_address',
        'registered_shipowner', 'registered_shipowner_address',
        'work_hours', 'ot_per_hour', 'ot_hours', 'cba_affiliation',
        
    ];

    protected $dates = [
    	'created_at', 'updated_at'
    ];

    public function setBHPAttribute($value) {
        $this->attributes['BHP'] = $value == ""? 0 : $value;
    }

    public function principal(){
    	return $this->belongsTo('App\Models\Principal');
    }
}
