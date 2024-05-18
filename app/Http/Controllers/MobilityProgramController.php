<?php

namespace App\Http\Controllers;

use App\Models\MobilityProgram;
use Illuminate\Http\Request;

class MobilityProgramController extends Controller
{
    public function index()
    {
        $programs = MobilityProgram::all();
        return view('welcome', compact('programs'));
    }

    public function create()
    {
        return view('mobility-programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'due_date' => 'required|date',
            'extra_info' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('mobility_program_images', 'public');
        }

        MobilityProgram::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $imagePath,
            'due_date' => $request->input('due_date'),
            'extra_info' => $request->input('extra_info'),
        ]);

        return redirect()->route('mobility-programs.create')->with('success', 'Mobility program advertisement created successfully.');
    }
}
