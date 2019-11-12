<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ssap extends Model
{
    protected $fillable = [
        'token', 'user_id'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
