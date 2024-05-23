<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\ApplicationForm;
use App\Models\StudyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function indexForStudent()
    {
        $user = auth()->user();
        $currentSemester = $user->getCurrentSemester();

        if (!$currentSemester) {
            return view('dashboard.utm-student', ['message' => 'Unable to determine your current semester.']);
        }

        $intakeYear = '20' . substr($user->matric_number, 1, 2);
        $intakeSemester = $user->intake_period;

        // Fetch all courses that the student is eligible for based on their intake year.
        $allCourses = Course::where('intake_year', $intakeYear)
            ->where('intake_semester', $intakeSemester)
            ->orderBy('year_semester', 'asc')
            ->get()
            ->groupBy('year_semester');

        // Fetch the user's study plans
        $studyPlans = StudyPlan::where('user_id', $user->id)->get()->groupBy('year_semester');

        // Check if there are any study plans
        if ($studyPlans->isEmpty()) {
            // If no study plans, fall back to guided courses
            $studyPlans = collect();

            // Create a fallback study plan structure
            foreach ($allCourses as $yearSemester => $courses) {
                foreach ($courses as $course) {
                    if (!isset($studyPlans[$yearSemester])) {
                        $studyPlans[$yearSemester] = collect();
                    }
                    $studyPlans[$yearSemester][] = new StudyPlan([
                        'course_id' => $course->id,
                        'year_semester' => $yearSemester,
                        'course' => $course,
                    ]);
                }
            }
        } else {
            // If study plans exist, we need to fetch courses for the study plans
            foreach ($studyPlans as $yearSemester => $plans) {
                foreach ($plans as $plan) {
                    $plan->course = Course::find($plan->course_id);
                }
            }
        }

        // Check if the student has submitted any application forms
        $applicationForm = ApplicationForm::where('user_id', $user->id)->first();

        return view('dashboard.utm-student', compact('allCourses', 'applicationForm', 'studyPlans'));
    }
}
