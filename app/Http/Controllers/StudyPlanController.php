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

        // Check if user is TDA or Program Coordinator
        if ($user->isTDA() || $user->isProgramCoordinator()) {
            // Fetch all users with study plans
            $students = User::whereHas('studyPlans')->get();

            return view('study-plans.review', compact('students'));
        }

        // Fetch the user's study plans
        $studyPlans = StudyPlan::where('user_id', $user->id)->get()->groupBy('year_semester');

        // Fetch all guided courses
        $allCourses = Course::where('intake_year', '20' . substr($user->matric_number, 1, 2))
            ->where('intake_semester', $user->intake_period)
            ->orderBy('year_semester', 'asc')
            ->get()
            ->groupBy('year_semester');

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

        return view('study-plans.index', compact('studyPlans', 'allCourses'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'study_plan_data' => 'required|string',
        ]);
    
        $studyPlanData = json_decode($data['study_plan_data'], true);
    
        // Get existing remarks
        $existingRemarks = StudyPlan::where('user_id', $user->id)->pluck('remark', 'course_id')->toArray();
    
        // Remove existing study plan
        StudyPlan::where('user_id', $user->id)->delete();
    
        // Add new study plan and preserve remarks
        foreach ($studyPlanData as $courseData) {
            $remark = isset($existingRemarks[$courseData['course_id']]) ? $existingRemarks[$courseData['course_id']] : null;
            StudyPlan::create([
                'user_id' => $user->id,
                'course_id' => $courseData['course_id'],
                'year_semester' => $courseData['year_semester'],
                'remark' => $remark,
            ]);
        }
    
        return redirect()->back()->with('success', 'Study plan updated successfully.');
    }

    public function review($userId)
    {
        $student = User::findOrFail($userId);
        $studyPlans = StudyPlan::where('user_id', $student->id)->get()->groupBy('year_semester');

        return view('study-plans.review-detail', compact('student', 'studyPlans'));
    }

    public function saveRemarks(Request $request, $userId)
    {
        $data = $request->validate([
            'remarks' => 'array',
            'remarks.*' => 'nullable|string',
        ]);

        foreach ($data['remarks'] as $yearSemester => $remark) {
            StudyPlan::where('user_id', $userId)
                ->where('year_semester', $yearSemester)
                ->update(['remark' => $remark]);
        }

        return redirect()->back()->with('success', 'Remarks updated successfully.');
    }
}
