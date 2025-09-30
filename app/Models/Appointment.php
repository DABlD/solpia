<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AppointmentAttribute;

class Appointment extends Model
{
    use AppointmentAttribute, SoftDeletes;

    protected $fillable = [
        "rank","lname","fname","assigned_vessel","sign_on",
        "sign_off","contact","age","person_to_visit",
        "purpose_of_visit","recommended_by","remarks",
        "status"
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
