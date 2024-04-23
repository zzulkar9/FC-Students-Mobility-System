<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ApplicationForm;
use App\Models\ApplicationFormSubject;
use Illuminate\Support\Facades\Auth;

class ApplicationFormController extends Controller
{
    // Function to determine the current semester based on matric number
    public function getCurrentSemester() {
        if (!$this->matric_number) {
            return null; // Return null if no matric number is set
        }
    
        // Extract the year from the matric number
        $matricYear = intval(substr($this->matric_number, 1, 2));
        $intakeType = substr($this->matric_number, 0, 1);
    
        // Current year and month for calculating the current semester
        $currentYear = intval(date('Y'));
        $currentMonth = intval(date('m'));
    
        // Determine the intake month
        $intakeMonth = ($this->intake_period === 'September') ? 9 : 3; // Assume March for "March/April"
        $yearsSinceMatric = $currentYear - (2000 + $matricYear); // Adding 2000 to convert '23' to 2023, for example
    
        // Calculate the current semester based on month and year difference
        $semesterCount = ($yearsSinceMatric * 2) + ($currentMonth >= $intakeMonth ? 1 : 0);
    
        // Adjust for the type 'B' students who start from the third semester
        if ($intakeType === 'B') {
            $semesterCount += 2;
        }
    
        return min($semesterCount, 8); // Ensure it does not exceed 8 semesters
    }
    

    public function indexForStudent()
{
    $user = auth()->user();
    $currentSemester = $user->getCurrentSemester();

    if (!$currentSemester) {
        return view('dashboard.utm-student', ['message' => 'Unable to determine your current semester.']);
    }

    $intakeYear = 2000 + intval(substr($user->matric_number, 1, 2)); // Assuming the year is the second and third characters of the matric number

    $courses = Course::where('year_semester', 'Year ' . ceil($currentSemester / 2) . ': Semester ' . (($currentSemester % 2) ? 1 : 2))
                     ->where('intake_year', (string)$intakeYear) // You need to make sure this field exists or adjust the database accordingly
                     ->where('intake_semester', $user->intake_period)
                     ->get();

    return view('dashboard.utm-student', compact('courses'));
}

    
    
    
    


    public function index()
    {
        $user = auth()->user();

        if ($user->isUtmStudent()) {
            // Check if the user has any existing applications
            $applicationForm = ApplicationForm::where('user_id', $user->id)
                ->latest('updated_at') // Make sure to get the most recent application
                ->first();

            if ($applicationForm) {
                // If an application exists, redirect to edit the most recent one
                return redirect()->route('application-form.show', $applicationForm->id);
            } else {
                // No applications found, show the form to submit a new application
                $courses = Course::all(); // Assuming you need course data for the form
                return view('application-form.index', compact('courses'));
            }
        } elseif ($user->isProgramCoordinator()) {
            // For program coordinators, show the dashboard with all submissions
            $applications = ApplicationForm::with('user')->latest()->paginate(10);
            return view('application-form.pc-index', compact('applications'));
        } else {
            // Optionally handle other roles or redirect with an error
            return abort(403, 'Unauthorized access.');
        }
    }


    public function submit(Request $request)
    {
        $request->validate([
            'utm_course_id' => 'required|array',
            'utm_course_id.*' => 'exists:courses,id',
            'target_course' => 'required|array',
            'target_course.*' => 'required|string|max:255',
            'target_course_description' => 'required|array',
            'target_course_description.*' => 'required|string',
            'target_course_notes' => 'nullable|array',
            'target_course_notes.*' => 'nullable|string',
        ]);

        $isDraft = $request->input('action') == 'save_draft';
        $user = auth()->user();  // Fetch the authenticated user

        $applicationForm = new ApplicationForm();
        $applicationForm->user_id = $user->id;
        $applicationForm->is_draft = $isDraft;
        $applicationForm->intake_period = $user->intake_period;
        $applicationForm->save();

        foreach ($request->utm_course_id as $index => $courseId) {
            $utmCourse = Course::findOrFail($courseId);

            $subject = new ApplicationFormSubject([
                'utm_course_id' => $utmCourse->id,
                'utm_course_code' => $utmCourse->course_code,
                'utm_course_name' => $utmCourse->course_name,
                'utm_course_description' => $utmCourse->description ?? 'No description available',
                'target_course' => $request->target_course[$index],
                'target_course_description' => $request->target_course_description[$index],
                'notes' => $request->target_course_notes[$index] ?? null,
            ]);

            $applicationForm->subjects()->save($subject);
        }

        return redirect()->route('dashboard')->with('success', $isDraft ? 'Draft saved successfully!' : 'Application submitted successfully!');
    }



    public function coordinatorIndex(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $applications = ApplicationForm::with('user')
            ->whereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('matric_number', 'like', '%' . $searchTerm . '%');
            })
            ->latest()
            ->paginate(10);

        return view('application-form.pc-index', compact('applications'));
    }


    public function review(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $applications = ApplicationForm::with('user')
            ->whereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('matric_number', 'like', '%' . $searchTerm . '%');
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.pc', compact('applications'));
    }

    public function show($id)
    {
        $applicationForm = ApplicationForm::with(['user', 'subjects'])->findOrFail($id);
        return view('application-form.show', compact('applicationForm'));
    }

    public function updateNotes(Request $request, $subjectId)
    {
        $request->validate([
            'notes' => 'required|string|max:255', // Validate as necessary
        ]);

        $subject = ApplicationFormSubject::findOrFail($subjectId);
        $subject->notes = $request->notes;
        $subject->save();

        return back()->with('success', 'Notes updated successfully.');
    }


    public function edit($id)
    {
        $applicationForm = ApplicationForm::with('subjects')->findOrFail($id);  // Make sure to load related subjects if needed

        // Check if the currently authenticated user is the owner of the form
        if (auth()->id() !== $applicationForm->user_id && !auth()->user()->isAdmin()) {
            abort(403); // Added admin check if admins can edit any form
        }

        $courses = Course::all(); // Fetch all courses for dropdown options

        return view('application-form.edit', compact('applicationForm', 'courses'));
    }


    public function update(Request $request, $id)
    {
        $applicationForm = ApplicationForm::with('subjects')->findOrFail($id);

        $request->validate([
            'utm_course_id' => 'required|array',
            'utm_course_id.*' => 'exists:courses,id',
            'target_course' => 'required|array',
            'target_course.*' => 'required|string|max:255',
            'target_course_description' => 'required|array',
            'target_course_description.*' => 'required|string',
            'target_course_notes' => 'nullable|array',
            'target_course_notes.*' => 'nullable|string',
        ]);

        // Update existing subjects or create new ones
        foreach ($request->utm_course_id as $index => $courseId) {
            $utmCourse = Course::findOrFail($courseId);

            $subject = $applicationForm->subjects->get($index) ?? new ApplicationFormSubject();
            $subject->application_form_id = $applicationForm->id;
            $subject->utm_course_id = $utmCourse->id;
            $subject->utm_course_code = $utmCourse->course_code;
            $subject->utm_course_name = $utmCourse->course_name;
            $subject->utm_course_description = $utmCourse->description ?? 'No description available';
            $subject->target_course = $request->target_course[$index];
            $subject->target_course_description = $request->target_course_description[$index];
            $subject->notes = $request->target_course_notes[$index] ?? null;

            $subject->save(); // This will update existing records or create new ones as necessary
        }

        return redirect()->route('dashboard')->with('success', 'Application updated successfully!');
    }
}
