<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'utm_course_id', 'utm_course_code', 'utm_course_name',
        'utm_course_description', 'target_course', 'target_course_description',
        'notes', 'is_draft'
    ];
    

    // Relationships, if you have users or courses models to link
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function utmCourse() {
        return $this->belongsTo(Course::class, 'utm_course_id');
    }
}

