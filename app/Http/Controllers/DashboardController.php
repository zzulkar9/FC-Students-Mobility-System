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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        }

        return view('dashboard.utm-student', compact('allCourses', 'applicationForm', 'studyPlans', 'incompleteTabs'));
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
            if (empty($subject->utm_course_id) || 
                empty($subject->target_course) || 
                empty($subject->target_course_credit) || 
                empty($subject->target_course_description)) {
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
}

