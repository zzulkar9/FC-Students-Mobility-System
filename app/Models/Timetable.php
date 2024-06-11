<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_name',
        'section',
        'time_slot',
        'program_type',
        'year',
        'semester',
    ];
}
