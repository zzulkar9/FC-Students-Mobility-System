<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timetable;
use App\Models\InboundStudent;
use App\Models\InboundStudentTimetable;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TimetablesImport;
use App\Exports\InboundStudentExport;
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

    public function index()
    {
        $timetables = Timetable::paginate(); // Adjust the number per page as needed
        $allTimetables = Timetable::all(); // For the manual add form
        return view('timetables.index', compact('timetables', 'allTimetables'));
    }


    public function saveAll(Request $request)
    {
        // Log request data
        \Log::info('Request Data:', $request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'semester' => 'required|string|in:March/April,September',
            'selected_timetables' => 'required|array',
        ]);

        // Decode selected_timetables JSON strings
        $timetables = array_map(function ($timetable) {
            return json_decode($timetable, true);
        }, $validatedData['selected_timetables']);

        // Log decoded timetables
        \Log::info('Decoded Timetables:', $timetables);

        if ($request->student_id) {
            $student = InboundStudent::find($request->student_id);
            $student->update([
                'name' => $validatedData['name'],
                'country' => $validatedData['country'],
                'semester' => $validatedData['semester'],
            ]);
            InboundStudentTimetable::where('inbound_student_id', $student->id)->delete();
        } else {
            $student = InboundStudent::create([
                'name' => $validatedData['name'],
                'country' => $validatedData['country'],
                'semester' => $validatedData['semester'],
            ]);
        }

        \Log::info('Inbound Student Created:', $student->toArray());

        foreach ($timetables as $timetable) {
            InboundStudentTimetable::create([
                'inbound_student_id' => $student->id,
                'course_code' => $timetable['course_code'],
                'course_name' => $timetable['course_name'],
                'section' => $timetable['section'],
                'time_slot' => $timetable['time_slot'],
                'year' => $timetable['year'],
                'semester' => $timetable['semester'],
            ]);
        }

        \Log::info('Inbound Student Timetables Created');

        return redirect()->back()->with('success', 'Inbound student info and timetable saved successfully.');
    }


    public function listInboundStudents(Request $request)
    {
        $search = $request->input('search');
    
        $timetablesQuery = Timetable::query();
        if ($search) {
            $timetablesQuery->where('course_code', 'like', "%$search%")
                ->orWhere('course_name', 'like', "%$search%");
        }
    
        $timetables = $timetablesQuery->paginate(7); // Adjust the number per page as needed
        $allTimetables = Timetable::all(); // For the manual add form
    
        $studentsQuery = InboundStudent::query();
        if ($search) {
            $studentsQuery->where('name', 'like', "%$search%")
                ->orWhere('country', 'like', "%$search%");
        }
    
        $students = $studentsQuery->paginate(7); // Adjust the pagination as needed
    
        return view('timetables.list-partials.student-list', compact('students', 'timetables', 'allTimetables', 'search'));
    }
    

    public function listInboundCourses(Request $request)
    {
        $search = $request->input('search');

        $timetablesQuery = Timetable::query();
        if ($search) {
            $timetablesQuery->where('course_code', 'like', "%$search%")
                ->orWhere('course_name', 'like', "%$search%");
        }

        $timetables = $timetablesQuery->paginate(7); // Adjust the number per page as needed
        $allTimetables = Timetable::all(); // For the manual add form
        $students = InboundStudent::paginate(7); // Adjust the pagination as needed

        return view('timetables.list-partials.course-list', compact('students', 'timetables', 'allTimetables', 'search'));
    }


    public function reviewInboundStudent($id)
    {
        $student = InboundStudent::findOrFail($id);
        $timetables = InboundStudentTimetable::where('inbound_student_id', $id)->get();
        return view('timetables.review', compact('student', 'timetables'));
    }

    public function edit($id)
    {
        $student = InboundStudent::with('timetables')->findOrFail($id);
        $timetables = Timetable::paginate(3); // Adjust the number per page as needed
        $allTimetables = Timetable::all(); // For the manual add form
        return view('timetables.index', compact('student', 'timetables', 'allTimetables'));
    }



    public function update(Request $request, InboundStudent $student)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'semester' => 'required|string|in:March/April,September',
            'selected_timetables' => 'required|array',
        ]);

        $student->update([
            'name' => $validatedData['name'],
            'country' => $validatedData['country'],
            'semester' => $validatedData['semester'],
        ]);

        // Remove existing timetables for the student
        InboundStudentTimetable::where('inbound_student_id', $student->id)->delete();

        // Decode selected_timetables JSON strings
        $timetables = array_map(function ($timetable) {
            return json_decode($timetable, true);
        }, $validatedData['selected_timetables']);

        foreach ($timetables as $timetable) {
            InboundStudentTimetable::create([
                'inbound_student_id' => $student->id,
                'course_code' => $timetable['course_code'],
                'course_name' => $timetable['course_name'],
                'section' => $timetable['section'],
                'time_slot' => $timetable['time_slot'],
                'year' => $timetable['year'],
                'semester' => $timetable['semester'],
            ]);
        }

        return redirect()->route('inbound-students.list')->with('success', 'Inbound student info and timetable updated successfully.');
    }

    public function deleteInboundStudent($id)
    {
        $student = InboundStudent::findOrFail($id);
        $student->timetables()->delete(); // Assuming you have a relationship method named timetables in InboundStudent model
        $student->delete();

        return redirect()->back()->with('success', 'Inbound student deleted successfully.');
    }

    public function exportStudent(InboundStudent $student)
    {
        return Excel::download(new InboundStudentExport($student), $student->name . '_timetable.xlsx');
    }

    public function editCourse($id)
    {
        $timetable = Timetable::findOrFail($id);
        return view('timetables.edit', compact('timetable'));
    }

    public function updateCourse(Request $request, $id)
    {
        $request->validate([
            'course_code' => 'required|string|max:255',
            'course_name' => 'required|string|max:255',
            'program_type' => 'required|string|max:255',
            'year' => 'required|integer',
            'semester' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'time_slot' => 'required|string|max:255',
        ]);

        $timetable = Timetable::findOrFail($id);
        $timetable->update($request->all());

        return redirect()->route('inbound-students.list')->with('success', 'Timetable updated successfully.');
    }

    public function destroy($id)
    {
        $timetable = Timetable::findOrFail($id);
        $timetable->delete();

        return redirect()->route('inbound-students.list')->with('success', 'Timetable deleted successfully.');
    }



}
