<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['application_form_id', 'user_id', 'comment'];

    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
