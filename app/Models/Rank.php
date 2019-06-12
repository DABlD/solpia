<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $fillable = [
    	'name', 'abbr', 'category', 'type'
    ];

    protected $dates = [
    	'created_at', 'updated_at'
    ];
}