<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\StudyPlan;
use App\Models\TargetUniversityCourse; // Make sure to import this model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudyPlanController extends Controller
{
    // public function index()
    // {
    //     $user = Auth::user();

    //     // Check if user is TDA or Program Coordinator
    //     if ($user->isTDA() || $user->isProgramCoordinator()) {
    //         // Fetch all users with study plans
    //         $students = User::whereHas('studyPlans')->get();

    //         return view('study-plans.review', compact('students'));
    //     }

    //     // Fetch the user's study plans
    //     $studyPlans = StudyPlan::where('user_id', $user->id)
    //         ->where('year_semester', '!=', 'None')
    //         ->with(['course', 'targetCourse']) // Ensure both relationships are loaded
    //         ->get()
    //         ->groupBy('year_semester');

    //     // Fetch all guided courses
    //     $allCourses = Course::where('intake_year', '20' . substr($user->matric_number, 1, 2))
    //         ->where('intake_semester', $user->intake_period)
    //         ->orderBy('year_semester', 'asc')
    //         ->get()
    //         ->groupBy('year_semester');

    //     // Fetch orphan subjects (those not in any semester)
    //     $orphanSubjects = StudyPlan::where('user_id', $user->id)
    //         ->where('year_semester', 'None')
    //         ->with(['course', 'targetCourse']) // Ensure both relationships are loaded
    //         ->get();

    //     // Check if there are any study plans
    //     if ($studyPlans->isEmpty()) {
    //         // If no study plans, fall back to guided courses
    //         $studyPlans = collect();

    //         // Create a fallback study plan structure
    //         foreach ($allCourses as $yearSemester => $courses) {
    //             foreach ($courses as $course) {
    //                 if (!isset($studyPlans[$yearSemester])) {
    //                     $studyPlans[$yearSemester] = collect();
    //                 }
    //                 $studyPlans[$yearSemester][] = new StudyPlan([
    //                     'course_id' => $course->id,
    //                     'year_semester' => $yearSemester,
    //                     'course' => $course,
    //                     'status' => 'guided',
    //                 ]);
    //             }
    //         }
    //     } else {
    //         // If study plans exist, we need to fetch courses for the study plans
    //         foreach ($studyPlans as $yearSemester => $plans) {
    //             foreach ($plans as $plan) {
    //                 if ($plan->course_id) {
    //                     $plan->course = Course::find($plan->course_id);
    //                 } else {
    //                     $plan->course = TargetUniversityCourse::find($plan->target_university_course_id);
    //                 }
    //             }
    //         }
    //     }

    //     return view('study-plans.index', [
    //         'studyPlans' => $studyPlans,
    //         'allCourses' => $allCourses,
    //         'orphanSubjects' => $orphanSubjects,
    //         'isPastSemester' => function ($yearSemester) use ($user) {
    //             return $this->isPastSemester($yearSemester);
    //         },
    //     ]);
    // }

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
        $studyPlans = StudyPlan::where('user_id', $user->id)
            ->where('year_semester', '!=', 'None')
            ->with(['course', 'targetCourse']) // Ensure both relationships are loaded
            ->get()
            ->groupBy('year_semester');

        // Fetch all guided courses
        $allCourses = Course::where('intake_year', '20' . substr($user->matric_number, 1, 2))
            ->where('intake_semester', $user->intake_period)
            ->orderBy('year_semester', 'asc')
            ->get()
            ->groupBy('year_semester');

        // Fetch orphan subjects (those not in any semester)
        $orphanSubjects = StudyPlan::where('user_id', $user->id)
            ->where('year_semester', 'None')
            ->with(['course', 'targetCourse']) // Ensure both relationships are loaded
            ->get();

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
                        'status' => 'guided',
                    ]);
                }
            }
        } else {
            // Ensure both course and targetCourse are loaded and set correctly
            foreach ($studyPlans as $yearSemester => $plans) {
                foreach ($plans as $plan) {
                    if ($plan->course_id) {
                        $plan->course = Course::find($plan->course_id);
                    }
                    if ($plan->target_university_course_id) {
                        $plan->targetCourse = TargetUniversityCourse::find($plan->target_university_course_id);
                    }
                }
            }
        }

        return view('study-plans.index', [
            'studyPlans' => $studyPlans,
            'allCourses' => $allCourses,
            'orphanSubjects' => $orphanSubjects,
            'isPastSemester' => function ($yearSemester) use ($user) {
                return $this->isPastSemester($yearSemester);
            },
        ]);
    }



    // public function review($userId)
    // {
    //     $student = User::findOrFail($userId);
    //     $studyPlans = StudyPlan::where('user_id', $student->id)
    //         ->where('year_semester', '!=', 'None')
    //         ->get()
    //         ->groupBy('year_semester');

    //     // Fetch orphan subjects (those not in any semester)
    //     $orphanSubjects = StudyPlan::where('user_id', $student->id)
    //         ->where('year_semester', 'None')
    //         ->get()
    //         ->map(function ($plan) {
    //             if ($plan->course_id) {
    //                 $plan->course = Course::find($plan->course_id);
    //             } elseif ($plan->target_university_course_id) {
    //                 $plan->course = TargetUniversityCourse::find($plan->target_university_course_id);
    //             }
    //             return $plan;
    //         });

    //     // Define isPastSemester closure
    //     $isPastSemester = function ($yearSemester) use ($student) {
    //         return $this->isPastSemester($yearSemester, $student);
    //     };

    //     return view('study-plans.review-detail', compact('student', 'studyPlans', 'orphanSubjects', 'isPastSemester'));
    // }

    public function review($userId)
    {
        $student = User::findOrFail($userId);

        // Fetch the user's study plans
        $studyPlans = StudyPlan::where('user_id', $student->id)
            ->where('year_semester', '!=', 'None')
            ->with(['course', 'targetCourse']) // Ensure both relationships are loaded
            ->get()
            ->groupBy('year_semester');

        // Fetch all guided courses
        $allCourses = Course::where('intake_year', '20' . substr($student->matric_number, 1, 2))
            ->where('intake_semester', $student->intake_period)
            ->orderBy('year_semester', 'asc')
            ->get()
            ->groupBy('year_semester');

        // Fetch orphan subjects (those not in any semester)
        $orphanSubjects = StudyPlan::where('user_id', $student->id)
            ->where('year_semester', 'None')
            ->with(['course', 'targetCourse']) // Ensure both relationships are loaded
            ->get();

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
                        'status' => 'guided',
                    ]);
                }
            }
        } else {
            // Ensure both course and targetCourse are loaded and set correctly
            foreach ($studyPlans as $yearSemester => $plans) {
                foreach ($plans as $plan) {
                    if ($plan->course_id) {
                        $plan->course = Course::find($plan->course_id);
                    }
                    if ($plan->target_university_course_id) {
                        $plan->targetCourse = TargetUniversityCourse::find($plan->target_university_course_id);
                    }
                }
            }
        }

        // Define isPastSemester closure
        $isPastSemester = function ($yearSemester) use ($student) {
            return $this->isPastSemester($yearSemester, $student);
        };

        return view('study-plans.review-detail', [
            'student' => $student,
            'studyPlans' => $studyPlans,
            'allCourses' => $allCourses,
            'orphanSubjects' => $orphanSubjects,
            'isPastSemester' => $isPastSemester,
        ]);
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

    private function isPastSemester($yearSemester, $user = null)
    {
        if ($yearSemester === 'None') {
            return false;
        }

        if (!$user) {
            $user = Auth::user();
        }

        $currentSemester = $this->getCurrentSemester($user);

        // Split the year and semester
        list($year, $semester) = explode(': Semester ', $yearSemester);

        // Calculate the current semester number (e.g., Year 1: Semester 1 -> 1, Year 2: Semester 2 -> 4)
        $semesterNumber = ((int) substr($year, 5) - 1) * 2 + (int) $semester;

        return $semesterNumber < $currentSemester;
    }

    private function getCurrentSemester($user)
    {
        // Extract the year from the matric number
        $matricYear = intval(substr($user->matric_number, 1, 2));
        $intakeType = substr($user->matric_number, 0, 1);

        // Current year and month for calculating the current semester
        $currentYear = intval(date('Y'));
        $currentMonth = intval(date('m'));

        // Determine the intake month
        $intakeMonth = ($user->intake_period === 'September') ? 9 : 3; // Assume March for "March/April"
        $yearsSinceMatric = $currentYear - (2000 + $matricYear); // Adding 2000 to convert '23' to 2023, for example

        // Calculate the current semester based on month and year difference
        $semesterCount = ($yearsSinceMatric * 2) + ($currentMonth >= $intakeMonth ? 1 : 0);

        // Adjust for the type 'B' students who start from the third semester
        if ($intakeType === 'B') {
            $semesterCount += 2;
        }

        return min($semesterCount, 8); // Ensure it does not exceed 8 semesters
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'study_plan_data' => 'required|string',
        ]);

        $studyPlanData = json_decode($data['study_plan_data'], true);

        // dd($studyPlanData);

        // Get existing remarks
        $existingRemarks = StudyPlan::where('user_id', $user->id)->pluck('remark', 'course_id')->toArray();

        // Remove existing study plan
        StudyPlan::where('user_id', $user->id)->delete();

        // Add new study plan and preserve remarks
        foreach ($studyPlanData as $courseData) {
            $remark = isset($existingRemarks[$courseData['course_id']]) ? $existingRemarks[$courseData['course_id']] : null;
            $yearSemester = $courseData['year_semester'] ?? 'None';

            // Ensure the status is set correctly
            $status = $courseData['status'] ?? 'custom';

            // Ensure the correct course_id and target_university_course_id are set
            StudyPlan::create([
                'user_id' => $user->id,
                'course_id' => $courseData['course_id'] ?? null,
                'target_university_course_id' => $courseData['target_university_course_id'] ?? null,
                'year_semester' => $yearSemester,
                'remark' => $remark,
                'status' => $status,
            ]);
        }

        return redirect()->back()->with('success', 'Study plan updated successfully.');
    }



}
