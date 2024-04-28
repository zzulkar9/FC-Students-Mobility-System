<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8', // minimum length 8 characters
                'confirmed',
                'regex:/[A-Z]/',       // must contain at least one uppercase letter
                'regex:/[a-z]/',       // must contain at least one lowercase letter
                'regex:/[0-9]/',       // must contain at least one digit
                'regex:/[@$!%*#?&]/',  // must contain a special character
            ],
            'user_type' => ['required', 'string', 'in:utm_student,other_uni_student'],
            'matric_number' => ['nullable', 'string', 'required_if:user_type,utm_student', 'max:255'],
            'intake_period' => ['nullable', 'string', 'required_if:user_type,utm_student'],
        ]);
        
        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'matric_number' => $request->matric_number,
            'intake_period' => $request->intake_period,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
