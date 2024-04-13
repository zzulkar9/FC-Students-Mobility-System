<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ApplicationForm;
use App\Models\ApplicationFormSubject;

class ApplicationFormController extends Controller
{
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
}
