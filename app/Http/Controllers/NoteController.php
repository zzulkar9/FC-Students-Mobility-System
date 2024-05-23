<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'intake_year' => 'required|string',
            'intake_semester' => 'required|string',
            'note' => 'required|string',
            'year_semester' => 'nullable|string',
        ]);

        // Find existing note or create a new one
        $note = Note::updateOrCreate(
            [
                'intake_year' => $request->intake_year,
                'intake_semester' => $request->intake_semester,
                'year_semester' => $request->year_semester,
            ],
            [
                'note' => $request->note,
            ]
        );

        return back()->with('success', 'Note saved successfully.');
    }

    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);

        $request->validate([
            'note' => 'required|string',
        ]);

        $note->update($request->only('note'));

        return back()->with('success', 'Note updated successfully.');
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return back()->with('success', 'Note deleted successfully.');
    }
}
