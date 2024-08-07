<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyPlan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'target_university_course_id', 'year_semester', 'remark', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function targetCourse()
    {
        return $this->belongsTo(TargetUniversityCourse::class, 'target_university_course_id');
    }
}
