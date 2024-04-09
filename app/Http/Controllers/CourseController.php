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

    public function edit($id)
    {
        $course = Course::findOrFail($id); // Find the course by ID or fail
        return view('courses.edit', compact('course')); // Return the edit view with the course
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'course_code' => 'required|string|max:255',
            'course_name' => 'required|string|max:255',
            'year_semester' => 'required|string|max:255',
            'course_credit' => 'required|numeric',
            'prerequisites' => 'nullable|string|max:255', // Assuming this can be empty
            'description' => 'nullable|string', // No max length specified, adjust as necessary
        ]);

        $course = Course::findOrFail($id);
        $course->update([
            'course_code' => $request->course_code,
            'course_name' => $request->course_name,
            'year_semester' => $request->year_semester,
            'course_credit' => $request->course_credit,
            'prerequisites' => $request->prerequisites,
            'description' => $request->description, // Updating the course with description
        ]);

        return redirect()->route('course-handbook.index')->with('success', 'Course updated successfully.');
    }



    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('course-handbook.index')->with('success', 'Course deleted successfully.');
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }
}
