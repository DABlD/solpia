<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditTrail extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'user_id', 'action', 'ip', 
    	'hostname', 'device', 'browser', 
    	'platform'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
