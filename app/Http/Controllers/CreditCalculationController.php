<?php

namespace App\Http\Controllers;

use App\Models\ApplicationForm;
use App\Models\CreditCalculation;
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
            // Ensure that UTM course credit is fetched correctly
            $utmCourseCredit = $subject->utm_course_credit;

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
}
