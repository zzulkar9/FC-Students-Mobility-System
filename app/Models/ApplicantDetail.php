<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantDetail extends Model
{
    protected $fillable = [
        'application_form_id', 'program_type', 'religion', 'citizenship', 'ic_passport_number',
        'contact_number', 'race', 'home_address', 'next_of_kin', 'emergency_contact',
        'parents_occupation', 'parents_monthly_income'
    ];

    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class);
    }
}

