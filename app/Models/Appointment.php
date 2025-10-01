<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppointmentAttribute;

class Appointment extends Model
{
    use AppointmentAttribute, SoftDeletes;

    protected $fillable = [
        "rank","name","assigned_vessel","person_to_visit",
        "purpose_of_visit","availability","status","remarks"
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
