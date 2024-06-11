<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InboundStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'semester',
    ];

    public function timetables()
    {
        return $this->hasMany(InboundStudentTimetable::class, 'inbound_student_id');
    }

}

