<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetCredit extends Model
{
    use HasFactory;

    protected $fillable = [
        'intake_year',
        'intake_semester',
        'year_semester',
        'target_credits',
    ];
}
