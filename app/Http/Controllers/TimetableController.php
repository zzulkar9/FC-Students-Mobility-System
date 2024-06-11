<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timetable;
use App\Models\InboundStudentTimetable;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TimetablesImport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TimetableController extends Controller
{
    public function create()
    {
        return view('timetables.upload');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|integer',
            'semester' => 'required|string|in:March/April,September',
            'file' => 'required|mimes:xlsx',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Store the file temporarily
        $filePath = $request->file('file')->store('temp');

        // Import the data
        $import = new TimetablesImport($request->input('year'), $request->input('semester'));
        Excel::import($import, Storage::path($filePath));

        Storage::delete($filePath);

        return redirect()->back()->with('success', 'Timetable data uploaded successfully.');
    }

    public function show()
    {
        $timetables = Timetable::paginate(3); // Adjust the number per page as needed
        $allTimetables = Timetable::all(); // For the manual add form
        return view('timetables.show', compact('timetables', 'allTimetables'));
    }


    public function saveTimetable(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|integer',
            'course_code' => 'required|string',
            'course_name' => 'required|string',
            'section' => 'required|string',
            'time_slot' => 'required|string',
            'year' => 'required|integer',
            'semester' => 'required|string|in:March/April,September',
        ]);

        $existing = InboundStudentTimetable::where('student_id', $data['student_id'])
            ->where('time_slot', $data['time_slot'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Timeslot clash detected.');
        }

        InboundStudentTimetable::create($data);

        return redirect()->back()->with('success', 'Timetable saved successfully.');
    }
}
