<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseHandbookController extends Controller
{
    // public function index($searchQuery = null)
    // {
    //     $courses = Course::query();

    //     if ($searchQuery) {
    //         $courses = $courses->where('course_code', 'like', "%{$searchQuery}%")
    //             ->orWhere('course_name', 'like', "%{$searchQuery}%");
    //     }

    //     $courses = $courses->paginate(5); // Paginate the courses, 6 per page

    //     return view('course-handbook.index', compact('courses'));
    // }


    public function index($searchQuery = null)
    {
        $years = Course::select('intake_year')->distinct()->orderBy('intake_year', 'desc')->get();
    
        $coursesByYearAndIntake = [];
        foreach ($years as $year) {
            $intakes = Course::where('intake_year', $year->intake_year)
                             ->select('intake_semester')
                             ->distinct()
                             ->pluck('intake_semester');
    
            foreach ($intakes as $intake) {
                $coursesByYearAndIntake[$year->intake_year][$intake] = Course::where('intake_year', $year->intake_year)
                                                                            ->where('intake_semester', $intake)
                                                                            ->orderBy('year_semester', 'asc')
                                                                            ->get()
                                                                            ->groupBy('year_semester');
            }
        }
    
        return view('course-handbook.index', compact('coursesByYearAndIntake', 'years'));
    }
    
}
