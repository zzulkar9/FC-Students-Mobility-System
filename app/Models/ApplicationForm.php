<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationForm extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'is_draft', 'intake_period', 'submitted_at', 'link'];


    public function subjects()
    {
        return $this->hasMany(ApplicationFormSubject::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
