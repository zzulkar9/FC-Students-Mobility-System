<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialDetail extends Model
{
    protected $table = 'financial_details'; // Ensure the table name is correct

    protected $fillable = [
        'application_form_id', // Foreign key to link with ApplicationForm
        'finance_method',
        'sponsorship_details',
        'budget_details'
    ];

    // Relationship with ApplicationForm
    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class);
    }
}
