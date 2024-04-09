<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_name',
        'year_semester',
        'course_credit',
        'description',
        'prerequisites',
        'day_and_timeslot',
    ];
    
}
