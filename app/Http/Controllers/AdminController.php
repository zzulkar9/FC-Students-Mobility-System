<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Display admin dashboard with a list of users
    public function index(Request $request)
    {
        $searchQuery = $request->input('search', '');

        $users = User::query()
            ->when($searchQuery, function ($query) use ($searchQuery) {
                return $query->where('name', 'like', "%{$searchQuery}%")
                    ->orWhere('email', 'like', "%{$searchQuery}%");
            })
            ->paginate(6);

        // Assuming you're passing other data to the view, add 'users' to the array
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
