<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ApplicationForm;
use App\Models\ApplicationFormSubject;
use App\Models\ApplicantDetail;
use App\Models\EducationDetail;
use App\Models\FinancialDetail;
use App\Models\AdvisorFacultyApprovalDetail;
use App\Models\CreditCalculation;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApplicationFormController extends Controller
{
    protected $creditCalculationController;

    public function __construct(CreditCalculationController $creditCalculationController)
    {
        $this->creditCalculationController = $creditCalculationController;
    }

    // Function to determine the current semester based on matric number
    public function getCurrentSemester()
    {
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

    public function index(Request $request)
    {
        $user = auth()->user();
    
        if ($user->isUtmStudent()) {
            // Check if the user has any existing applications
            $applicationForm = ApplicationForm::where('user_id', $user->id)
                ->latest('updated_at') // Make sure to get the most recent application
                ->first();
    
            // If an application form exists, redirect to the show function
            if ($applicationForm) {
                return redirect()->route('application-form.show', ['applicationForm' => $applicationForm->id]);
            }
    
            $currentSemester = $user->getCurrentSemester();
            if (!$currentSemester) {
                return view('application-form.index', [
                    'message' => 'Unable to determine your current semester.'
                ]);
            }
    
            $intakeYear = 2000 + intval(substr($user->matric_number, 1, 2)); // Assuming the year is the second and third characters of the matric number
            $intakeSemester = $user->intake_period;
    
            $courses = Course::where('year_semester', 'Year ' . ceil($currentSemester / 2) . ': Semester ' . (($currentSemester % 2) ? 1 : 2))
                ->where('intake_year', (string) $intakeYear)
                ->where('intake_semester', $intakeSemester)
                ->get();
    
            $allCourses = Course::where('intake_year', $intakeYear)
                ->where('intake_semester', $intakeSemester)
                ->get();
    
            // Now pass the applicationFormId to the view correctly
            return view('application-form.index', [
                'courses' => $courses,
                'allCourses' => $allCourses,
                'applicationForm' => null,
                'message' => 'No existing application form found. Please create a new application if needed.'
            ]);
        }
        elseif ($user->isProgramCoordinator() || $user->isAA() || $user->isTDA() || $user->isAdmin()) {
            $searchTerm = $request->input('search', '');
            $applications = ApplicationForm::with('user')
                ->where('is_draft', false)  // Ensure drafts are not shown to coordinators
                ->whereHas('user', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('matric_number', 'like', '%' . $searchTerm . '%');
                })
                ->latest()
                ->paginate(10);
    
            return view('application-form.pc-index', compact('applications'));
        } else {
            // Optionally handle other roles or redirect with an error
            return view('unauthorize-access.unauthorize-access');
        }
    }
    
    




    public function coordinatorIndex(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $applications = ApplicationForm::with('user')
            ->where('is_draft', false)  // Ensure drafts are not shown to coordinators
            ->whereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('matric_number', 'like', '%' . $searchTerm . '%');
            })
            ->latest()
            ->paginate(10);

        return view('application-form.pc-index', compact('applications'));
    }


    public function submit(Request $request)
    {
        $request->validate([
            // Validation rules for tabs A, B, C, D, and E
            'program_type' => 'nullable|string',
            'upcoming_semester' => 'nullable|string',
            'religion' => 'nullable|string',
            'citizenship' => 'nullable|string',
            'ic_passport_number' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'race' => 'nullable|string',
            'home_address' => 'nullable|string',
            'next_of_kin' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'parents_occupation' => 'nullable|string',
            'parents_monthly_income' => 'nullable|string',
            'faculty' => 'nullable|string',
            'current_semester' => 'nullable|string',
            'field_of_study' => 'nullable|string',
            'expected_graduation' => 'nullable|date',
            'program' => 'nullable|string',
            'cgpa' => 'nullable|numeric',
            'co_curriculum' => 'nullable|string',
            'achievements' => 'nullable|string',
            'special_skills' => 'nullable|string',
            'utm_course_id' => 'nullable|array',
            'utm_course_id.*' => 'exists:courses,id',
            'target_course' => 'nullable|array',
            'target_course.*' => 'nullable|string|max:255',
            'target_course_description' => 'nullable|array',
            'target_course_description.*' => 'nullable|string',
            'target_course_credit' => 'nullable|array',
            'target_course_credit.*' => 'nullable|string|max:255',
            'target_course_notes' => 'nullable|array',
            'target_course_notes.*' => 'nullable|string',
            'link' => 'nullable|url',
            'finance_method' => 'nullable|string',
            'sponsorship_details' => 'nullable|string',
            'budget_details' => 'nullable|string',
            'advisor_name' => 'nullable|string',
            'advisor_email' => 'nullable|email',
            'advisor_phone' => 'nullable|string',
            'advisor_remarks' => 'nullable|string',
            'approval' => 'nullable|string',
            'faculty_remarks' => 'nullable|string'
        ]);

        $isDraft = $request->input('action') == 'save_draft';
        $user = auth()->user();  // Fetch the authenticated user

        // Create or update the main application form
        $applicationForm = ApplicationForm::updateOrCreate(
            ['user_id' => $user->id],
            [
                'is_draft' => $isDraft,
                'intake_period' => $user->intake_period,
                'link' => $request->input('link'),
            ]
        );

        // Save or update details for Tab A
        $applicationForm->applicantDetails()->updateOrCreate(
            ['application_form_id' => $applicationForm->id],
            $request->only(['program_type', 'upcoming_semester', 'religion', 'citizenship', 'ic_passport_number', 'contact_number', 'race', 'home_address', 'next_of_kin', 'emergency_contact', 'parents_occupation', 'parents_monthly_income'])
        );

        // Save or update details for Tab B
        $applicationForm->educationDetails()->updateOrCreate(
            ['application_form_id' => $applicationForm->id],
            $request->only(['faculty', 'current_semester', 'field_of_study', 'expected_graduation', 'program', 'cgpa', 'co_curriculum', 'achievements', 'special_skills'])
        );

        // Handle courses selection for Tab C
        foreach ($request->utm_course_id ?? [] as $index => $courseId) {
            $utmCourse = Course::findOrFail($courseId);

            $subject = new ApplicationFormSubject([
                'application_form_id' => $applicationForm->id,
                'utm_course_id' => $utmCourse->id,
                'utm_course_code' => $utmCourse->course_code,
                'utm_course_name' => $utmCourse->course_name,
                'utm_course_credit' => $utmCourse->course_credit,
                'utm_course_description' => $utmCourse->description ?? 'No description available',
                'target_course' => $request->target_course[$index],
                'target_course_credit' => $request->target_course_credit[$index],
                'target_course_description' => $request->target_course_description[$index],
                'notes' => $request->target_course_notes[$index] ?? null,
            ]);

            $applicationForm->subjects()->save($subject);
        }

        // Save or update details for Tab D
        $applicationForm->financialDetails()->updateOrCreate(
            ['application_form_id' => $applicationForm->id],
            $request->only(['finance_method', 'sponsorship_details', 'budget_details'])
        );

        // Save or update details for Tab E (Advisor and Approval)
        $applicationForm->advisorFacultyApprovalDetails()->updateOrCreate(
            ['application_form_id' => $applicationForm->id],
            $request->only(['advisor_name', 'advisor_email', 'advisor_phone', 'advisor_remarks', 'approval', 'faculty_remarks'])
        );

        // Calculate credits immediately after saving subjects
        $this->creditCalculationController->recalculateCredits($applicationForm->id);

        return redirect()->route('dashboard')->with('success', $isDraft ? 'Draft saved successfully!' : 'Application submitted successfully!');
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
        // Load the application form with the necessary relationships
        $applicationForm = ApplicationForm::with([
            'user',
            'subjects',
            'applicantDetails',
            'educationDetails',
            'financialDetails',
            'advisorFacultyApprovalDetails',
            'subjects.creditCalculations' // Load the credit calculations for the subjects
        ])->findOrFail($id);

        // Extract details for the view
        $details = $applicationForm->applicantDetails;
        $educations = $applicationForm->educationDetails;
        $financial = $applicationForm->financialDetails;
        $approval = $applicationForm->advisorFacultyApprovalDetails;

        // Load comments
        $comments = Comment::where('application_form_id', $id)->with('user')->get();

        // Pass the necessary details along with the ApplicationForm and comments to the view
        return view('application-form.show', compact('applicationForm', 'details', 'educations', 'financial', 'approval', 'comments'));
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
        // Assuming 'applicantDetails' is the relationship defined in ApplicationForm to access Tab A details
        $applicationForm = ApplicationForm::with(['user', 'subjects', 'applicantDetails'])->findOrFail($id);

        // Extract details for the view
        $courses = Course::all();
        $details = $applicationForm->applicantDetails;
        $educations = $applicationForm->educationDetails;
        $financial = $applicationForm->financialDetails;
        $approval = $applicationForm->advisorFacultyApprovalDetails;

        // Pass the necessary details along with the ApplicationForm to the view
        return view('application-form.edit', compact('applicationForm', 'details', 'educations', 'financial', 'approval', 'courses'));
    }


    public function update(Request $request, $id)
    {
        $applicationForm = ApplicationForm::with([
            'subjects',
            'applicantDetails',
            'educationDetails',
            'financialDetails',
            'advisorFacultyApprovalDetails'
        ])->findOrFail($id);

        $request->validate([
            'utm_course_id' => 'required|array',
            'utm_course_id.*' => 'exists:courses,id',
            'target_course' => 'required|array',
            'target_course.*' => 'required|string|max:255',
            'target_course_credit' => 'nullable|array',
            'target_course_credit.*' => 'nullable|numeric',
            'target_course_description' => 'required|array',
            'target_course_description.*' => 'required|string',
            'target_course_notes' => 'nullable|array',
            'target_course_notes.*' => 'nullable|string',
            'link' => 'nullable|url',

            'program_type' => 'nullable|string',
            'upcoming_semester' => 'nullable|string',
            'religion' => 'nullable|string',
            'citizenship' => 'nullable|string',
            'ic_passport_number' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'race' => 'nullable|string',
            'home_address' => 'nullable|string',
            'next_of_kin' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'parents_occupation' => 'nullable|string',
            'parents_monthly_income' => 'nullable|string',

            'faculty' => 'nullable|string',
            'current_semester' => 'nullable|string',
            'field_of_study' => 'nullable|string',
            'expected_graduation' => 'nullable|string',
            'program' => 'nullable|string',
            'cgpa' => 'nullable|numeric',
            'co_curriculum' => 'nullable|string',
            'achievements' => 'nullable|string',
            'special_skills' => 'nullable|string',

            'finance_method' => 'nullable|string',
            'sponsorship_details' => 'nullable|string',
            'budget_details' => 'nullable|string',

            'advisor_name' => 'nullable|string',
            'advisor_email' => 'nullable|string|email',
            'advisor_phone' => 'nullable|string',
            'advisor_remarks' => 'nullable|string',
            'approval' => 'nullable|string',
            'faculty_remarks' => 'nullable|string',
        ]);

        $applicationForm->update([
            'link' => $request->input('link'),
        ]);

        // Save or update details for Tab A (Applicant Details)
        $applicationForm->applicantDetails()->updateOrCreate(
            ['application_form_id' => $applicationForm->id],
            $request->only([
                'program_type',
                'upcoming_semester',
                'religion',
                'citizenship',
                'ic_passport_number',
                'contact_number',
                'race',
                'home_address',
                'next_of_kin',
                'emergency_contact',
                'parents_occupation',
                'parents_monthly_income'
            ])
        );

        // Save or update details for Tab B (Education & Co-Curriculum)
        $applicationForm->educationDetails()->updateOrCreate(
            ['application_form_id' => $applicationForm->id],
            $request->only([
                'faculty',
                'current_semester',
                'field_of_study',
                'expected_graduation',
                'program',
                'cgpa',
                'co_curriculum',
                'achievements',
                'special_skills'
            ])
        );

        // Collect current subject IDs from the form submission
        $currentSubjectIds = [];
        foreach ($request->utm_course_id as $index => $courseId) {
            $utmCourse = Course::findOrFail($courseId);
            $subject = $applicationForm->subjects->where('utm_course_id', $utmCourse->id)->first() ?? new ApplicationFormSubject();

            $subject->application_form_id = $applicationForm->id;
            $subject->utm_course_id = $utmCourse->id;
            $subject->utm_course_code = $utmCourse->course_code;
            $subject->utm_course_name = $utmCourse->course_name;
            $subject->utm_course_credit = $utmCourse->course_credit;
            $subject->utm_course_description = $utmCourse->description ?? 'No description available';
            $subject->target_course = $request->target_course[$index];
            $subject->target_course_credit = $request->target_course_credit[$index] ?? null;
            $subject->target_course_description = $request->target_course_description[$index];
            $subject->notes = $request->target_course_notes[$index] ?? $subject->notes;  // Maintain existing notes if not provided

            $subject->save();

            // Add to current subject IDs
            $currentSubjectIds[] = $subject->id;
        }

        // Delete subjects that are no longer present in the form submission
        $applicationForm->subjects()->whereNotIn('id', $currentSubjectIds)->delete();

        // Save or update details for Tab D (Financial)
        $applicationForm->financialDetails()->updateOrCreate(
            ['application_form_id' => $applicationForm->id],
            $request->only(['finance_method', 'sponsorship_details', 'budget_details'])
        );

        // Save or update details for Tab E (Advisor and Approval)
        $applicationForm->advisorFacultyApprovalDetails()->updateOrCreate(
            ['application_form_id' => $applicationForm->id],
            $request->only(['advisor_name', 'advisor_email', 'advisor_phone', 'advisor_remarks', 'approval', 'faculty_remarks'])
        );

        // Calculate credits
        $this->creditCalculationController->recalculateCredits($applicationForm->id);

        return redirect()->route('application-form.show', $applicationForm->id)->with('success', 'Application updated successfully!');
    }


    public function updateAllNotes(Request $request, $applicationFormId)
    {
        $applicationForm = ApplicationForm::with('subjects')->findOrFail($applicationFormId);
        $notes = $request->notes;

        foreach ($applicationForm->subjects as $subject) {
            if (array_key_exists($subject->id, $notes)) {
                $subject->notes = $notes[$subject->id];
                $subject->save();
            }
        }

        return back()->with('success', 'All notes updated successfully!');
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        Comment::create([
            'application_form_id' => $id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return redirect()->route('application-form.show', $id)->with('success', 'Comment added successfully.');
    }
    public function ApprovalUpdate(Request $request, $id)
    {
        $applicationForm = ApplicationForm::with([
            'subjects',
            'applicantDetails',
            'educationDetails',
            'financialDetails',
            'advisorFacultyApprovalDetails'
        ])->findOrFail($id);

        $request->validate([
            'advisor_name' => 'nullable|string',
            'advisor_email' => 'nullable|string|email',
            'advisor_phone' => 'nullable|string',
            'advisor_remarks' => 'nullable|string',
            'approval' => 'nullable|string',
            'faculty_remarks' => 'nullable|string',
        ]);

        $applicationForm->advisorFacultyApprovalDetails()->updateOrCreate(
            ['application_form_id' => $applicationForm->id],
            $request->only(['advisor_name', 'advisor_email', 'advisor_phone', 'advisor_remarks', 'approval', 'faculty_remarks'])
        );

        return redirect()->route('application-form.show', $id)->with('success', 'Approval details updated successfully.');
    }

    public function destroy($id)
{
    $application = ApplicationForm::findOrFail($id);
    $application->delete();

    return redirect()->route('application-form.index')->with('success', 'Application deleted successfully.');
}




}
