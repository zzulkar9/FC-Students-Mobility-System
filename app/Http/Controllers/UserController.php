<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validate the request including 'user_type'
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required', 'string', 'in:utm_student,other_uni_student,Admin,TDA,program_coordinator,UTM Staff'],
            'matric_number' => ['nullable', 'string', 'required_if:user_type,utm_student', 'max:255'],
            'intake_period' => ['nullable', 'string', 'required_if:user_type,utm_student'],
        ]);

        // Include 'user_type' in user creation
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type, // Save this
            'matric_number' => $request->matric_number, // Save this
            'intake_period' => $request->intake_period, // Save this
        ]);

        // Check if the User model implements MustVerifyEmail
        if ($user instanceof MustVerifyEmail) {
            // Send verification email
            $user->sendEmailVerificationNotification();
        }

        // Redirect with success message
        return redirect()->route('dashboard-admin')->with('success', 'User created successfully.');
    }
}
