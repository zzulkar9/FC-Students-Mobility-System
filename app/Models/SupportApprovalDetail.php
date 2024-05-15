<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportApprovalDetail extends Model
{
    protected $table = 'support_approval_details'; // Ensure the table name is correct

    protected $fillable = [
        'application_form_id', // Foreign key to link with ApplicationForm
        'advisor_name',
        'advisor_email',
        'advisor_phone',
        'advisor_remarks',
        'faculty_approval',
        'faculty_remarks'
    ];

    // Relationship with ApplicationForm
    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class);
    }
}
