<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    const TYPE_UTM_STUDENT = 'utm_student';
    const TYPE_OTHER_STUDENT = 'other_uni_student';
    const TYPE_ADMIN = 'Admin';
    const TYPE_TDA = 'TDA';
    const TYPE_PROGRAM_COORDINATOR = 'program_coordinator';
    const TYPE_UTM_STAFF = 'UTM Staff';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_type', 'matric_number', 'intake_period',
    ];





    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // 'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->user_type === self::TYPE_ADMIN;
    }

    /**
     * Check if the user is a program coordinator.
     *
     * @return bool
     */
    public function isProgramCoordinator(): bool
    {
        return $this->user_type === self::TYPE_PROGRAM_COORDINATOR;
    }
}
