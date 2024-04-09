<?php

namespace App\Http\Controllers;

use App\Models\Course;


use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $inputStr = $request->course_data;
        // Basic parsing logic; adjustments may be needed based on your exact data format
        preg_match('/(\w+)\s+(.+)\s+(\d+)\s*(.*)/', $inputStr, $matches);

        $courseCode = $matches[1] ?? null;
        $courseName = $matches[2] ?? null;
        $courseCredit = $matches[3] ?? null;
        $prerequisites = $matches[4] ?? null;

        Course::create([
            'course_code' => $courseCode,
            'course_name' => $courseName,
            'year_semester' => $request->year_semester,
            'course_credit' => $courseCredit,
            'prerequisites' => $prerequisites,
            'description' => $request->description, // Now taking input from form
            'day_and_timeslot' => $request->day_and_timeslot, // Now taking input from form
        ]);

        return redirect()->route('courses.create')->with('success', 'Course added successfully');
    }
}
