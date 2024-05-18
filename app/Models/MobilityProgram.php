<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobilityProgram extends Model
{
    use HasFactory;

    protected $table = 'mobility_programs';

    protected $fillable = [
        'title', 'description', 'image', 'due_date', 'extra_info'
    ];

    protected $casts = [
        'due_date' => 'date',
    ];
}
