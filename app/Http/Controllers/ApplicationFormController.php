<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course; // Assuming you have a Course model that we are working with
use App\Models\ApplicationForm;

class ApplicationFormController extends Controller
{
    public function index()
    {
        // Assume you have some data to pass to the application form
        $courses = Course::all(); // Fetch all courses
        return view('application-form.index', ['courses' => $courses]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'utm_course' => 'required',
            'target_course' => 'required|string|max:255',
            'target_course_description' => 'required|string',
            'target_course_notes' => 'nullable|string',
        ]);

        // Find the UTM course to retrieve its details
        $utmCourse = Course::findOrFail($request->utm_course);

        $isDraft = $request->input('action') == 'save_draft';
        $applicationForm = new ApplicationForm();
        $applicationForm->user_id = auth()->id();
        $applicationForm->utm_course_id = $utmCourse->id;
        $applicationForm->utm_course_code = $utmCourse->course_code;
        $applicationForm->utm_course_name = $utmCourse->course_name;
        $applicationForm->utm_course_description = $utmCourse->description;  // Assuming 'description' is a field in your Course model
        $applicationForm->target_course = $request->target_course;
        $applicationForm->target_course_description = $request->target_course_description;
        $applicationForm->notes = $request->target_course_notes;
        $applicationForm->is_draft = $isDraft;
        $applicationForm->save();

        return redirect()->route('dashboard')->with('success', $isDraft ? 'Draft saved successfully!' : 'Application submitted successfully!');
    }
}
