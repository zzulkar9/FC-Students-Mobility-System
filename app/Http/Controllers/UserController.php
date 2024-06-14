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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/'
            ],
            'user_type' => 'required|string|in:utm_student,other_uni_student,Admin,TDA,program_coordinator,UTM Staff,Academic Advisor',
            'matric_number' => 'nullable|string|required_if:user_type,utm_student|max:255',
            'intake_period' => 'nullable|string|required_if:user_type,utm_student',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'matric_number' => $request->matric_number,
            'intake_period' => $request->intake_period,
        ]);

        if ($user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();
        }

        return redirect()->route('dashboard-admin')->with('success', 'User created successfully.');
    }


}
