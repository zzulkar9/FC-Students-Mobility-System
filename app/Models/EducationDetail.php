<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_form_id',
        'faculty',
        'current_semester',
        'field_of_study',
        'expected_graduation',
        'program',
        'cgpa',
        'co_curriculum',
        'achievements',
        'special_skills'
    ];

    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class);
    }
}
