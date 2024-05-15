<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvisorFacultyApprovalDetail extends Model
{
    use HasFactory;

    protected $table = 'advisor_and_approval_details'; // Ensure the table name is correct

    protected $fillable = [
        'application_form_id', // Foreign key to link with ApplicationForm
        'advisor_name',
        'advisor_email',
        'advisor_phone',
        'advisor_remarks',
        'approval',
        'faculty_remarks'
    ];

    // Relationship with ApplicationForm
    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class);
    }
}
