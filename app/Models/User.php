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
    const TYPE_AA = 'Academic Advisor';

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

    public function isStaff(): bool
    {
        return $this->user_type === self::TYPE_UTM_STAFF;
    }

    public function isUtmStudent(): bool
    {
        return $this->user_type === self::TYPE_UTM_STUDENT;
    }

    public function isTDA(): bool
    {
        return $this->user_type === self::TYPE_TDA;
    }

    public function isAA(): bool
    {
        return $this->user_type === self::TYPE_AA;
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

    // GET CURRENT SEMESTER

    public function getCurrentSemester() {
        if (!$this->matric_number) {
            return null;  // Return null if no matric number is set
        }

        // Extract the year and the intake type ('A' or 'B') from the matric number
        $year = intval(substr($this->matric_number, 1, 2));
        $intakeType = substr($this->matric_number, 0, 1);

        // Calculate the number of years since the matriculation year
        $currentYear = intval(date('y'));
        $yearsSinceMatric = $currentYear - $year;

        // Determine the current semester
        $currentMonth = intval(date('m'));
        $semesterOffset = $currentMonth >= 9 || $currentMonth < 3 ? 0 : 1; // September to February is semester 1, March to August is semester 2
        $currentSemester = $yearsSinceMatric * 2 + $semesterOffset;

        // If the student had credit transfers (type 'B'), start counting from semester 3
        if ($intakeType === 'B') {
            $currentSemester += 2;
        }

        return min($currentSemester, 8); // Ensure it does not exceed 8 semesters
    }

    public function studyPlans()
    {
        return $this->hasMany(StudyPlan::class);
    }
}
