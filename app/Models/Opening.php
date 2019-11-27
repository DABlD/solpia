<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\OpeningAttribute;

class Opening extends Model
{
    use OpeningAttribute, SoftDeletes;

    protected $fillable = [
    	'user_id','fleet','rank',
    	'type','remarks',
    	'status'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
