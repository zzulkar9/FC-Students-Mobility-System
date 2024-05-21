<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\StudyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudyPlanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch the user's study plans
        $studyPlans = StudyPlan::where('user_id', $user->id)->get()->groupBy('year_semester');

        // Fetch all guided courses
        $allCourses = Course::where('intake_year', '20' . substr($user->matric_number, 1, 2))
            ->where('intake_semester', $user->intake_period)
            ->orderBy('year_semester', 'asc')
            ->get()
            ->groupBy('year_semester');

        // Merge guided courses with study plans
        $mergedCourses = collect();

        foreach ($allCourses as $yearSemester => $courses) {
            if (isset($studyPlans[$yearSemester])) {
                // If there are study plans for this year_semester, use them
                $mergedCourses[$yearSemester] = $studyPlans[$yearSemester]->map(function ($plan) {
                    $plan->course = Course::find($plan->course_id);
                    return $plan;
                });
            } else {
                // Otherwise, use the guided courses
                $mergedCourses[$yearSemester] = $courses->map(function ($course) {
                    return new StudyPlan([
                        'course_id' => $course->id,
                        'year_semester' => $course->year_semester,
                        'course' => $course,
                    ]);
                });
            }
        }

        return view('study-plans.index', compact('mergedCourses'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'study_plan_data' => 'required|string',
        ]);

        $studyPlanData = json_decode($data['study_plan_data'], true);

        // Remove existing study plan
        StudyPlan::where('user_id', $user->id)->delete();

        // Add new study plan
        foreach ($studyPlanData as $courseData) {
            StudyPlan::create([
                'user_id' => $user->id,
                'course_id' => $courseData['course_id'],
                'year_semester' => $courseData['year_semester'],
            ]);
        }

        return redirect()->back()->with('success', 'Study plan updated successfully.');
    }
}
