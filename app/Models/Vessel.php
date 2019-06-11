<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    protected $fillable = [
    	'principal_id', 'name', 'flag', 'type', 'year_build', 'builder', 'engine', 'gross_tonnage', 'BHP', 'trade', 'ecdis', 'status'
    ];

    protected $dates = [
    	'created_at', 'updated_at'
    ];

    public function principal(){
    	return $this->belongsTo('App\Models\Principal');
    }
}
