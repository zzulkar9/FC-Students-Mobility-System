<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ApplicationForm;
use App\Models\ApplicationFormSubject;
use Illuminate\Support\Facades\Auth;

class ApplicationFormController extends Controller
{
    public function indexForStudent()
    {
        $applications = ApplicationForm::where('user_id', Auth::id())->latest()->get();
        return view('dashboard.utm-student', compact('applications'));
    }

    public function index()
    {
        $courses = Course::all();
        return view('application-form.index', ['courses' => $courses]);
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

        $applicationForm = new ApplicationForm();
        $applicationForm->user_id = auth()->id();
        $applicationForm->is_draft = $isDraft;
        $applicationForm->save();

        foreach ($request->utm_course_id as $index => $courseId) {
            $utmCourse = Course::findOrFail($courseId);

            $subject = new ApplicationFormSubject([
                'utm_course_id' => $utmCourse->id,
                'utm_course_code' => $utmCourse->course_code,
                'utm_course_name' => $utmCourse->course_name,
                'utm_course_description' => $utmCourse->description ?? 'No description available', // Provide a default if null
                'target_course' => $request->target_course[$index],
                'target_course_description' => $request->target_course_description[$index],
                'notes' => $request->target_course_notes[$index] ?? null,
            ]);

            $applicationForm->subjects()->save($subject);
        }

        return redirect()->route('dashboard')->with('success', $isDraft ? 'Draft saved successfully!' : 'Application submitted successfully!');
    }

    public function coordinatorIndex()
    {
        // Assuming each application form has a relation to a user where user details like name, matric number are stored
        $applications = ApplicationForm::with('user')->get();

        return view('dashboard.pc', ['applications' => $applications]);
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
        $applicationForm = ApplicationForm::with('subjects')->findOrFail($id); // Load form with subjects

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

        foreach ($request->utm_course_id as $index => $courseId) {
            $utmCourse = Course::findOrFail($courseId);
            $subject = $applicationForm->subjects[$index]; // Assuming index aligns correctly with subjects

            // Update each subject entry
            $subject->utm_course_id = $utmCourse->id;
            $subject->utm_course_code = $utmCourse->course_code;
            $subject->utm_course_name = $utmCourse->course_name;
            $subject->utm_course_description = $utmCourse->description;
            $subject->target_course = $request->target_course[$index];
            $subject->target_course_description = $request->target_course_description[$index];
            $subject->notes = $request->target_course_notes[$index] ?? $subject->notes; // Use existing notes if none provided
            $subject->save(); // Make sure to save each subject update
        }

        $applicationForm->save(); // Save the overall form changes

        return redirect()->route('dashboard')->with('success', 'Application updated successfully!');
    }
}
