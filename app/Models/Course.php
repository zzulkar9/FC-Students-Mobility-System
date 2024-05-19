<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // In your Course model
    protected $fillable = [
        'course_code', 'course_name', 'year_semester', 'course_credit',
        'prerequisites', 'description', 'intake_year', 'intake_semester'
    ];

    public function studyPlanCourses()
    {
        return $this->hasMany(StudyPlan::class);
    }
}
