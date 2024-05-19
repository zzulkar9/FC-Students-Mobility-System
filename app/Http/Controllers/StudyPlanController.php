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

        // Check if there are any study plans
        if ($studyPlans->isEmpty()) {
            // If no study plans, fall back to guided courses
            $studyPlans = collect();
            $allCourses = Course::where('intake_year', '20' . substr($user->matric_number, 1, 2))
                                ->where('intake_semester', $user->intake_period)
                                ->orderBy('year_semester', 'asc')
                                ->get()
                                ->groupBy('year_semester');

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
            // If study plans exist, fetch all courses for display
            $allCourses = Course::where('intake_year', '20' . substr($user->matric_number, 1, 2))
                                ->where('intake_semester', $user->intake_period)
                                ->orderBy('year_semester', 'asc')
                                ->get()
                                ->groupBy('year_semester');
        }

        return view('study-plans.index', compact('studyPlans', 'allCourses'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'courses' => 'array',
            'courses.*.course_id' => 'required|exists:courses,id',
            'courses.*.year_semester' => 'required|string',
        ]);

        // Remove existing study plan
        StudyPlan::where('user_id', $user->id)->delete();

        // Add new study plan
        foreach ($data['courses'] as $courseData) {
            StudyPlan::create([
                'user_id' => $user->id,
                'course_id' => $courseData['course_id'],
                'year_semester' => $courseData['year_semester'],
            ]);
        }

        return redirect()->route('study-plans.index')->with('success', 'Study plan updated successfully.');
    }
}
