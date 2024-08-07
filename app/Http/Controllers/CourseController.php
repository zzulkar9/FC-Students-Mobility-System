<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\TargetCredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        if (!$user->isUtmStudent()) {
            return view('courses.create');
        } else {
            // Optionally handle other roles or redirect with an error
            return view('unauthorize-access.unauthorize-access');
        }
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

            // Check if a course with the same code and name but different year_semester exists
            $existingCourse = Course::where('course_code', $courseCode)
                ->where('intake_year', $intakeYear)
                ->where('intake_semester', $intakeSemester)
                ->where('year_semester', $yearSemester)
                ->first();

            if (!$existingCourse) {
                // Proceed to store the new course
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
        $intakeSemester = str_replace('-', '/', urldecode($intakeSemester));
        $yearSemester = urldecode($yearSemester);
    
        return view('courses.add-course-for-semester', [
            'intakeYear' => $intakeYear,
            'intakeSemester' => $intakeSemester,
            'yearSemester' => $yearSemester
        ]);
    }
    
    public function editForSemester($intakeYear, $intakeSemester, $yearSemester)
    {
        $intakeSemester = str_replace('-', '/', urldecode($intakeSemester));
        $yearSemester = urldecode($yearSemester);
    
        $courses = Course::where('intake_year', $intakeYear)
            ->where('intake_semester', $intakeSemester)
            ->where('year_semester', $yearSemester)
            ->get();
    
        $courseData = $courses->map(function ($course) {
            return "{$course->course_code} {$course->course_name} {$course->course_credit}";
        })->implode("\n");
    
        return view('course-handbook.edit-for-semester', compact('intakeYear', 'intakeSemester', 'yearSemester', 'courseData'));
    }
    
    
    

    public function updateForSemester(Request $request)
{
    $request->validate([
        'intake_year' => 'required|string',
        'intake_semester' => 'required|string',
        'year_semester' => 'required|string',
        'course_data' => 'required|string',
    ]);

    $courseData = explode("\n", $request->course_data);

    DB::transaction(function () use ($request, $courseData) {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Delete existing courses for this semester
        Course::where('intake_year', $request->intake_year)
            ->where('intake_semester', $request->intake_semester)
            ->where('year_semester', $request->year_semester)
            ->delete();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Add updated courses
        foreach ($courseData as $courseLine) {
            $courseDetails = preg_split('/\s+/', trim($courseLine));

            if (count($courseDetails) < 3) {
                // Skip invalid lines
                continue;
            }

            $course_code = $courseDetails[0];
            $course_credit = array_pop($courseDetails); // Get the last element
            $course_name = implode(' ', array_slice($courseDetails, 1)); // Rest is course name

            // Validate the course credit is a valid integer
            if (!is_numeric($course_credit)) {
                return back()->withErrors(['course_data' => 'Invalid course credit value: ' . $course_credit]);
            }

            Course::create([
                'intake_year' => $request->intake_year,
                'intake_semester' => $request->intake_semester,
                'year_semester' => $request->year_semester,
                'course_code' => $course_code,
                'course_name' => $course_name,
                'course_credit' => intval($course_credit),
            ]);
        }
    });

    return redirect()->route('course-handbook.index')->with('success', 'Courses updated successfully.');
}

    public function setTargetCredits(Request $request)
    {
        $request->validate([
            'intake_year' => 'required|string',
            'intake_semester' => 'required|string',
            'year_semester' => 'required|string',
            'target_credits' => 'required|integer',
        ]);

        TargetCredit::updateOrCreate(
            [
                'intake_year' => $request->intake_year,
                'intake_semester' => $request->intake_semester,
                'year_semester' => $request->year_semester,
            ],
            [
                'target_credits' => $request->target_credits,
            ]
        );

        return back()->with('success', 'Target credits set successfully.');
    }

    public function duplicate(Request $request)
    {
        \Log::info('Request Data:', $request->all());

        $validated = $request->validate([
            'sourceYear' => 'required|string|max:255',
            'sourceIntake' => 'required|string|max:255',
            'targetYear' => 'required|string|max:255',
            'targetIntake' => 'required|string|max:255',
        ]);

        \Log::info('Validated Data:', $validated);

        $sourceYear = $validated['sourceYear'];
        $sourceIntake = $validated['sourceIntake'];
        $targetYear = $validated['targetYear'];
        $targetIntake = $validated['targetIntake'];

        $coursesToDuplicate = Course::where('intake_year', $sourceYear)
            ->where('intake_semester', $sourceIntake)
            ->get();

        foreach ($coursesToDuplicate as $course) {
            Course::create([
                'course_code' => $course->course_code,
                'course_name' => $course->course_name,
                'year_semester' => $course->year_semester,
                'course_credit' => $course->course_credit,
                'prerequisites' => $course->prerequisites,
                'intake_year' => $targetYear,
                'intake_semester' => $targetIntake,
                'description' => $course->description,
            ]);
        }

        return response()->json(['message' => 'Courses duplicated successfully']);
    }

    public function deleteIntake(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:255',
            'intake' => 'required|string|max:255',
        ]);

        $year = $validated['year'];
        $intake = $validated['intake'];

        Course::where('intake_year', $year)
            ->where('intake_semester', $intake)
            ->delete();

        return response()->json(['message' => 'Courses deleted successfully']);
    }


}
