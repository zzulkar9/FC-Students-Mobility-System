<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InboundStudentTimetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_code',
        'course_name',
        'section',
        'time_slot',
        'year',
        'semester',
    ];
}
