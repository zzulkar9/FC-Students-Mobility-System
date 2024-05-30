<?php

// app/Http/Controllers/CreditTransferController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreditTransferController extends Controller
{
    public function showForm()
    {
        return view('credit-transfer.form');
    }

    public function calculate(Request $request)
    {
        $ectsCredits = $request->input('ects_credits');

        // Conversion factor from ECTS to UTM credits
        $conversionFactor = 1 / 1.832;
        $utmCredits = $ectsCredits * $conversionFactor;

        return view('credit-transfer.result', [
            'ectsCredits' => $ectsCredits,
            'utmCredits' => $utmCredits,
        ]);
    }
}
