<?php

namespace App\Http\Controllers;

use App\Models\ApplicationForm;
use App\Models\CreditCalculation;
use Illuminate\Http\Request;

class CreditCalculationController extends Controller
{
    public function calculateAndShowCredits()
    {
        $user = auth()->user();
        $applicationForm = ApplicationForm::where('user_id', $user->id)->with('subjects')->firstOrFail();

        foreach ($applicationForm->subjects as $subject) {
            // Calculate equivalent UTM credits (using the provided conversion coefficient)
            $coefficient = 60 / 32.75; // 60 credits per year in Europe / 32.75 credits per year in Malaysia
            $equivalentUtmCredits = $subject->target_course_credit / $coefficient;

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

        // Reload the application form with the calculated credits
        $applicationForm = ApplicationForm::where('user_id', $user->id)->with('subjects.creditCalculations')->firstOrFail();

        return view('credits.index', compact('applicationForm'));
    }


}
