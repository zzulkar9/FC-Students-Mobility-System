<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course; // Don't forget to import your Course model

class CourseHandbookController extends Controller
{
    public function index()
    {
        $courses = Course::all(); // Fetch all courses
        return view('course-handbook.index', compact('courses')); // Pass them to the view
    }
}
