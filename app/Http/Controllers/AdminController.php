<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Display admin dashboard with a list of users
    public function index()
    {
        $users = User::all();
        return view('dashboard.admin', compact('users'));
    }

    // Show form for editing the specified user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user')); // Ensure 'user' is passed to the view
    }


    // Update the specified user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('dashboard-admin')->with('success', 'User updated successfully.');
    }

    // Remove the specified user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('dashboard-admin')->with('success', 'User deleted successfully.');
    }
}
