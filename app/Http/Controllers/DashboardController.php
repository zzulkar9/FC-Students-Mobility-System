<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\ApplicationForm;
use App\Models\StudyPlan;
use App\Models\ApplicationFormSubject;
use App\Models\ApplicantDetail;
use App\Models\EducationDetail;
use App\Models\FinancialDetail;
use App\Models\AdvisorFacultyApprovalDetail;
use App\Models\User;
use App\Models\InboundStudent;
use App\Models\MobilityProgram;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function indexForStudent()
    {
        $user = auth()->user();
        $currentSemester = $user->getCurrentSemester();
    
        if (!$currentSemester) {
            return view('dashboard.utm-student', ['message' => 'Unable to determine your current semester.']);
        }
    
        $intakeYear = '20' . substr($user->matric_number, 1, 2);
        $intakeSemester = $user->intake_period;
    
        // Fetch all courses that the student is eligible for based on their intake year.
        $allCourses = Course::where('intake_year', $intakeYear)
            ->where('intake_semester', $intakeSemester)
            ->orderBy('year_semester', 'asc')
            ->get()
            ->groupBy('year_semester');
    
        // Fetch the user's study plans
        $studyPlans = StudyPlan::where('user_id', $user->id)->get()->groupBy('year_semester');
    
        // Check if there are any study plans
        if ($studyPlans->isEmpty()) {
            // If no study plans, fall back to guided courses
            $studyPlans = collect();
    
            // Create a fallback study plan structure
            foreach ($allCourses as $yearSemester => $courses) {
                foreach ($courses as $course) {
                    if (!isset($studyPlans[$yearSemester])) {
                        $studyPlans[$yearSemester] = collect();
                    }
                    $studyPlans[$yearSemester][] = new StudyPlan([
                        'course_id' => $course->id,
                        'year_semester' => $yearSemester,
                        'course' => $course,
                    ]);
                }
            }
        } else {
            // If study plans exist, we need to fetch courses for the study plans
            foreach ($studyPlans as $yearSemester => $plans) {
                foreach ($plans as $plan) {
                    $plan->course = Course::find($plan->course_id);
                }
            }
        }
    
        // Check if the student has submitted any application forms
        $applicationForm = ApplicationForm::where('user_id', $user->id)->first();
    
        // Check completeness of each tab
        $incompleteTabs = [];
    
        // Check Tab A completeness
        if ($applicationForm) {
            $applicantDetails = ApplicantDetail::where('application_form_id', $applicationForm->id)->first();
            if (!$applicantDetails || $this->isTabAIncomplete($applicantDetails)) {
                $incompleteTabs[] = 'A';
            }
    
            // Check Tab B completeness
            $educationDetails = EducationDetail::where('application_form_id', $applicationForm->id)->first();
            if (!$educationDetails || $this->isTabBIncomplete($educationDetails)) {
                $incompleteTabs[] = 'B';
            }
    
            // Check Tab C completeness
            $subjects = ApplicationFormSubject::where('application_form_id', $applicationForm->id)->get();
            if ($subjects->isEmpty() || $this->isTabCIncomplete($subjects)) {
                $incompleteTabs[] = 'C';
            }
    
            // Check Tab D completeness
            $financialDetails = FinancialDetail::where('application_form_id', $applicationForm->id)->first();
            if (!$financialDetails || $this->isTabDIncomplete($financialDetails)) {
                $incompleteTabs[] = 'D';
            }
    
            // Check Tab E completeness
            $advisorFacultyApprovalDetails = AdvisorFacultyApprovalDetail::where('application_form_id', $applicationForm->id)->first();
            if (!$advisorFacultyApprovalDetails || $this->isTabEIncomplete($advisorFacultyApprovalDetails)) {
                $incompleteTabs[] = 'E';
            }
    
            // Fetch the latest comment for the application form
            $latestComment = Comment::where('application_form_id', $applicationForm->id)->latest()->first();
        } else {
            $latestComment = null;
        }
    
        return view('dashboard.utm-student', compact('allCourses', 'applicationForm', 'studyPlans', 'incompleteTabs', 'latestComment'));
    }
     

    private function isTabAIncomplete($applicantDetails)
    {
        return empty($applicantDetails->program_type) ||
            empty($applicantDetails->religion) ||
            empty($applicantDetails->citizenship) ||
            empty($applicantDetails->ic_passport_number) ||
            empty($applicantDetails->contact_number) ||
            empty($applicantDetails->race) ||
            empty($applicantDetails->home_address) ||
            empty($applicantDetails->next_of_kin) ||
            empty($applicantDetails->emergency_contact) ||
            empty($applicantDetails->parents_occupation) ||
            empty($applicantDetails->parents_monthly_income);
    }

    private function isTabBIncomplete($educationDetails)
    {
        return empty($educationDetails->faculty) ||
            empty($educationDetails->current_semester) ||
            empty($educationDetails->field_of_study) ||
            empty($educationDetails->expected_graduation) ||
            empty($educationDetails->program) ||
            empty($educationDetails->cgpa) ||
            empty($educationDetails->co_curriculum) ||
            empty($educationDetails->achievements) ||
            empty($educationDetails->special_skills);
    }

    private function isTabCIncomplete($subjects)
    {
        foreach ($subjects as $subject) {
            if (
                empty($subject->utm_course_id) ||
                empty($subject->target_course) ||
                empty($subject->target_course_credit) ||
                empty($subject->target_course_description)
            ) {
                return true;
            }
        }
        return false;
    }

    private function isTabDIncomplete($financialDetails)
    {
        return empty($financialDetails->finance_method) ||
            empty($financialDetails->sponsorship_details) ||
            empty($financialDetails->budget_details);
    }

    private function isTabEIncomplete($advisorFacultyApprovalDetails)
    {
        return empty($advisorFacultyApprovalDetails->advisor_name) ||
            empty($advisorFacultyApprovalDetails->advisor_email) ||
            empty($advisorFacultyApprovalDetails->advisor_phone) ||
            empty($advisorFacultyApprovalDetails->advisor_remarks) ||
            empty($advisorFacultyApprovalDetails->approval) ||
            empty($advisorFacultyApprovalDetails->faculty_remarks);
    }

    public function indexForPC(Request $request)
    {
        $searchTerm = $request->input('search', '');

        // Fetch outbound applications
        $applications = ApplicationForm::with('user')
            ->where('is_draft', false)
            ->whereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('matric_number', 'like', '%' . $searchTerm . '%');
            })
            ->latest()
            ->paginate();

        // Fetch study plans for review
        $studentsWithStudyPlans = User::whereHas('studyPlans')->get();

        // Fetch inbound students
        $inboundStudents = InboundStudent::paginate();

        // Get the logged-in program coordinator
        $programCoordinator = Auth::user();

        return view('dashboard.pc', compact('applications', 'studentsWithStudyPlans', 'inboundStudents', 'programCoordinator'));
    }

    public function indexForAdmin(Request $request)
    {
        $searchQuery = $request->input('search', '');
    
        // Fetch users based on the search query
        $users = User::query()
            ->when($searchQuery, function ($query) use ($searchQuery) {
                return $query->where('name', 'like', "%{$searchQuery}%")
                    ->orWhere('email', 'like', "%{$searchQuery}%");
            })
            ->paginate();
    
        // Fetch mobility programs
        $programs = MobilityProgram::all();
    
        // Get the current logged-in user as the program coordinator
        $programCoordinator = Auth::user();
    
        return view('dashboard.admin', compact('users', 'programs', 'programCoordinator'));
    }

    public function indexForStaff(Request $request)
    {   
        // Fetch mobility programs
        $programs = MobilityProgram::all();
    
        return view('dashboard.staff', compact('programs'));
    }

    public function indexForTDA(Request $request)
    {
        // Fetch outbound applications
        $applications = ApplicationForm::with('user')
            ->where('is_draft', false) // Assuming 'is_draft' indicates whether an application is final or not
            ->paginate();
    
        // Fetch students with study plans
        $studentsWithStudyPlans = User::whereHas('studyPlans')->paginate();
    
        return view('dashboard.tda', compact('applications', 'studentsWithStudyPlans'));
    }

    public function indexForAA(Request $request)
    {
        // Fetch outbound applications
        $applications = ApplicationForm::with(['user', 'advisorFacultyApprovalDetails'])
            ->where('is_draft', false)
            ->paginate();
    
        // Fetch students with study plans
        $studentsWithStudyPlans = User::whereHas('studyPlans')->paginate(10);
    
        return view('dashboard.aa', compact('applications', 'studentsWithStudyPlans'));
    }
    
}

