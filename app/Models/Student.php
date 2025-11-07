<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'full_name',
        'reg_number',
        'course',
        'organization_name',
        'student_contact',
        'student_email',
        'notes',
        'status',
        'supervisor_name',
        'supervisor_email',
    ];
}
