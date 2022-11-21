<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'type', 'value', 'file', 'vessel', 'date'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'date'
    ];
}
