<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetUniversityCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_form_subject_id',
        'user_id',
        'course_code',
        'course_name',
        'course_credit',
        'course_code_name',
    ];

    public function applicationFormSubject()
    {
        return $this->belongsTo(ApplicationFormSubject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


