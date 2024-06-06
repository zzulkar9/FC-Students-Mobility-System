<?php
namespace App\Http\Controllers;

use App\Models\ApplicationForm;
use App\Models\CreditCalculation;
use App\Http\Controllers\StudyPlanController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseHandbookController;
use App\Models\TargetUniversityCourse;
use App\Models\Course;
use App\Models\StudyPlan;
use Illuminate\Http\Request;

class CreditCalculationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $applicationForm = ApplicationForm::where('user_id', $user->id)->with('subjects.creditCalculations')->firstOrFail();

        return view('credits.index', compact('applicationForm'));
    }

    public function calculateAndShowCredits()
    {
        $user = auth()->user();
        $applicationForm = ApplicationForm::where('user_id', $user->id)->with('subjects')->firstOrFail();

        // Recalculate credits
        $this->recalculateCredits($applicationForm->id);

        // Redirect to the calculated credits view
        return redirect()->route('credits.index');
    }

    public function recalculateCredits($applicationFormId)
    {
        $applicationForm = ApplicationForm::with('subjects')->findOrFail($applicationFormId);

        foreach ($applicationForm->subjects as $subject) {
            // Calculate equivalent UTM credits (using the provided conversion coefficient)
            $equivalentUtmCredits = $subject->target_course_credit / 1.832;

            // Store the calculated equivalent UTM credits in the new table
            CreditCalculation::updateOrCreate(
                [
                    'application_form_id' => $applicationForm->id,
                    'application_form_subject_id' => $subject->id,
                ],
                [
                    'equivalent_utm_credits' => $equivalentUtmCredits,
                ]
            );
        }
    }

    public function updateCredits(Request $request, $id)
    {
        $applicationForm = ApplicationForm::with('subjects')->findOrFail($id);
    
        foreach ($request->credit_calculations as $calculationId => $data) {
            $calculation = CreditCalculation::findOrFail($calculationId);
            $calculation->remarks = $data['remarks'] ?? $calculation->remarks;
            $calculation->save();
        }
    
        // Save overall approval status
        $applicationForm->approval_status = $request->input('approval_status') == 'approved';
        $applicationForm->save();
    
        // If approved, add target university courses to study plans
        if ($applicationForm->approval_status) {
            foreach ($applicationForm->subjects as $subject) {
                // Check if there are credit calculations for the subject
                if ($subject->creditCalculations()->exists()) {
                    // Move UTM course to "Subjects Not in Any Semester"
                    StudyPlan::where('user_id', $applicationForm->user_id)
                        ->where('course_id', $subject->utm_course_id)
                        ->update(['year_semester' => 'None']);
    
                    // Add target university course
                    $targetUniversityCourse = TargetUniversityCourse::create([
                        'application_form_subject_id' => $subject->id,
                        'user_id' => $applicationForm->user_id,
                        'course_code' => $subject->target_course,
                        'course_name' => $subject->target_course,
                        'course_credit' => $subject->target_course_credit,
                        'course_code_name' => $subject->target_course, // Add this line to match your model
                    ]);
    
                    // Add to study plans with the ID of the created target university course
                    StudyPlan::create([
                        'user_id' => $applicationForm->user_id,
                        'course_id' => $subject->utm_course_id,  // Keep UTM course reference for consistency
                        'target_university_course_id' => $targetUniversityCourse->id,
                        'year_semester' => 'None',
                        'remark' => 'Approved BY Program Coordinator',
                        'status' => 'approved',
                    ]);
                }
            }
        }
    
        return redirect()->route('dashboard')->with('success', 'Credit calculations updated successfully!');
    }
    
    
    
    


}
