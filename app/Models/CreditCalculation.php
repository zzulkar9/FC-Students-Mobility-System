<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_form_id',
        'application_form_subject_id',
        'equivalent_utm_credits',
    ];

    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class);
    }

    public function applicationFormSubject()
    {
        return $this->belongsTo(ApplicationFormSubject::class, 'application_form_subject_id');
    }
}
