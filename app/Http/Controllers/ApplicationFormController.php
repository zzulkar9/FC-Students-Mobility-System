<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import the User model.

class ApplicationFormController extends Controller
{
    public function index()
    {
        // Define the user types based on your constants in User model
        $userTypes = [
            User::TYPE_UTM_STUDENT => 'UTM Student',
            User::TYPE_OTHER_STUDENT => 'Other University Student',
            User::TYPE_ADMIN => 'Admin',
            User::TYPE_TDA => 'TDA',
            User::TYPE_PROGRAM_COORDINATOR => 'Program Coordinator',
            User::TYPE_UTM_STAFF => 'UTM Staff',
        ];

        // Pass the user types to the view
        return view('application-form.index', compact('userTypes'));
    }
}
