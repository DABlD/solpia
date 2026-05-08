<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportLogs extends Model
{
    protected $fillable = [
        "user_id", "rank", "name", "cert_no", "type"
    ];

    protected $dates = [
        'created_at', 'deleted_at'
    ];
}
