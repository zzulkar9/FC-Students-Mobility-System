<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course; // Don't forget to import your Course model

class CourseHandbookController extends Controller
{
    public function index($searchQuery = null)
    {
        $courses = Course::query();

        if ($searchQuery) {
            $courses = $courses->where('course_code', 'like', "%{$searchQuery}%")
                ->orWhere('course_name', 'like', "%{$searchQuery}%");
        }

        $courses = $courses->paginate(5); // Paginate the courses, 6 per page

        return view('course-handbook.index', compact('courses'));
    }
}
