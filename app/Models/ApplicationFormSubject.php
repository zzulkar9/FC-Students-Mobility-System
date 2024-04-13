<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationFormSubject extends Model
{
    // Ensure your table name is correct if it's not the default
    protected $table = 'application_form_subjects';

    protected $fillable = [
        'application_form_id',
        'utm_course_id',
        'utm_course_code',
        'utm_course_name',
        'utm_course_description',
        'target_course',
        'target_course_description',
        'notes'
    ];

    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class);
    }
}
