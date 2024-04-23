<?php

namespace App\Http\Controllers;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Display the form for creating a new course.
    public function create()
    {
        return view('courses.create');
    }

    // Store a newly created course in the database.
    public function store(Request $request)
    {
        $request->validate([
            'intake_year' => 'required|string|max:255',
            'intake_semester' => 'required|string|max:255',
            'year_semester' => 'required|string|max:255',
            'course_data' => 'required|string'
        ]);

        $yearSemester = $request->year_semester;
        $intakeYear = $request->intake_year;
        $intakeSemester = $request->intake_semester;
        $lines = explode("\n", $request->course_data);

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            preg_match('/(\w+)\s+(.+)\s+(\d+)\s*(.*)/', $line, $matches);
            $courseCode = $matches[1] ?? null;
            $courseName = $matches[2] ?? null;
            $courseCredit = $matches[3] ?? null;
            $prerequisites = $matches[4] ?? null;

            Course::create([
                'course_code' => $courseCode,
                'course_name' => $courseName,
                'year_semester' => $yearSemester,
                'course_credit' => $courseCredit,
                'prerequisites' => $prerequisites,
                'intake_year' => $intakeYear,
                'intake_semester' => $intakeSemester
            ]);
        }

        return redirect()->route('course-handbook.index')->with('success', 'Courses added successfully.');
    }

    // Display the specified course.
    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    // Show the form for editing the specified course.
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    // Update the specified course in the database.
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course_code' => 'required|string|max:255',
            'course_name' => 'required|string|max:255',
            'year_semester' => 'required|string|max:255',
            'course_credit' => 'required|numeric',
            'prerequisites' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'intake_year' => 'required|string|max:255',
            'intake_semester' => 'required|string|max:255'
        ]);

        $course->update($request->all());
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    // Remove the specified course from the database.
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
