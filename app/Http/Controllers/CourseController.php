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
        $request->validate([
            'intake_year' => 'required|string|max:255',
            'intake_semester' => 'required|string|max:255',
            'year_semester' => 'required|string|max:255',
            'course_data' => 'required|string',
            'description' => 'nullable|string' // Validate description if it's provided
        ]);

        $yearSemester = $request->year_semester;
        $intakeYear = $request->intake_year;
        $intakeSemester = $request->intake_semester;
        $description = $request->description; // Capture description from the request
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
                'intake_semester' => $intakeSemester,
                'description' => $description // Save description
            ]);
        }

        return redirect()->route('course-handbook.index')->with('success', 'Courses added successfully.');
    }




    public function edit($id)
    {
        $course = Course::findOrFail($id); // Find the course by ID or fail
        return view('courses.edit', compact('course')); // Return the edit view with the course
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);  // Fetch the course first

        $request->validate([
            'course_code' => 'required|string|max:255|unique:courses,course_code,' . $course->id . ',id,intake_year,' . $request->intake_year . ',intake_semester,' . $request->intake_semester,
            'course_name' => 'required|string|max:255',
            'year_semester' => 'required|string|max:255',
            'course_credit' => 'required|numeric',
            'prerequisites' => 'nullable|string|max:255', // Assuming this can be empty
            'description' => 'nullable|string', // No max length specified, adjust as necessary
        ]);

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

    public function show($id)
    {
        $course = Course::findOrFail($id); // Find the course or fail
        return view('courses.show', compact('course')); // Return the show view with the course
    }

    public function storeForSemester(Request $request)
    {
        $request->validate([
            'intake_year' => 'required|string',
            'intake_semester' => 'required|string',
            'year_semester' => 'required|string',
            'course_data' => 'required|string',
        ]);

        $yearSemester = $request->year_semester;
        $lines = explode("\n", $request->course_data);

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            preg_match('/(\w+)\s+(.+)\s+(\d+)\s*(.*)/', $line, $matches);
            Course::create([
                'course_code' => $matches[1],
                'course_name' => $matches[2],
                'year_semester' => $yearSemester,
                'course_credit' => $matches[3],
                'prerequisites' => $matches[4] ?? null,
                'intake_year' => $request->intake_year,
                'intake_semester' => $request->intake_semester,
                'description' => $request->description ?? null,
            ]);
        }

        return redirect()->route('course-handbook.index')->with('success', 'Courses added successfully.');
    }

    public function createForSemester($intakeYear, $intakeSemester, $yearSemester)
    {
        return view('courses.add-course-for-semester', [
            'intakeYear' => $intakeYear,
            'intakeSemester' => $intakeSemester,
            'yearSemester' => $yearSemester
        ]);
    }
}
