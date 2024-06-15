<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\TargetCredit;
use App\Models\Note;

class CourseHandbookController extends Controller
{

    public function index($searchQuery = null)
    {
        $years = Course::select('intake_year')->distinct()->orderBy('intake_year', 'desc')->get();

        $coursesByYearAndIntake = [];
        $totalCreditsBySemester = [];
        $targetCreditsBySemester = [];

        foreach ($years as $year) {
            $intakes = Course::where('intake_year', $year->intake_year)
                ->select('intake_semester')
                ->distinct()
                ->pluck('intake_semester');

            foreach ($intakes as $intake) {
                $semesters = Course::where('intake_year', $year->intake_year)
                    ->where('intake_semester', $intake)
                    ->orderBy('year_semester', 'asc')
                    ->get()
                    ->groupBy('year_semester');

                foreach ($semesters as $semester => $courses) {
                    $totalCredits = $courses->sum('course_credit');
                    $coursesByYearAndIntake[$year->intake_year][$intake][$semester] = $courses;
                    $totalCreditsBySemester[$year->intake_year][$intake][$semester] = $totalCredits;

                    // Fetch the target credits for this semester
                    $targetCredit = TargetCredit::where('intake_year', $year->intake_year)
                        ->where('intake_semester', $intake)
                        ->where('year_semester', $semester)
                        ->first();

                    $targetCreditsBySemester[$year->intake_year][$intake][$semester] = $targetCredit ? $targetCredit->target_credits : 0;
                }
            }
        }

        // Fetch all notes
        $notes = Note::all()->groupBy(function ($note) {
            return $note->intake_year . '-' . $note->intake_semester . ($note->year_semester ? '-' . $note->year_semester : '');
        });

        return view('course-handbook.index', compact('coursesByYearAndIntake', 'years', 'totalCreditsBySemester', 'targetCreditsBySemester', 'notes'));
    }

    public function FullHandbookIndex($searchQuery = null)
    {
        $years = Course::select('intake_year')->distinct()->orderBy('intake_year', 'desc')->get();

        $coursesByYearAndIntake = [];
        $totalCreditsBySemester = [];
        $targetCreditsBySemester = [];

        foreach ($years as $year) {
            $intakes = Course::where('intake_year', $year->intake_year)
                ->select('intake_semester')
                ->distinct()
                ->pluck('intake_semester');

            foreach ($intakes as $intake) {
                $semesters = Course::where('intake_year', $year->intake_year)
                    ->where('intake_semester', $intake)
                    ->orderBy('year_semester', 'asc')
                    ->get()
                    ->groupBy('year_semester');

                foreach ($semesters as $semester => $courses) {
                    $totalCredits = $courses->sum('course_credit');
                    $coursesByYearAndIntake[$year->intake_year][$intake][$semester] = $courses;
                    $totalCreditsBySemester[$year->intake_year][$intake][$semester] = $totalCredits;

                    // Fetch the target credits for this semester
                    $targetCredit = TargetCredit::where('intake_year', $year->intake_year)
                        ->where('intake_semester', $intake)
                        ->where('year_semester', $semester)
                        ->first();

                    $targetCreditsBySemester[$year->intake_year][$intake][$semester] = $targetCredit ? $targetCredit->target_credits : 0;
                }
            }
        }

        // Fetch all notes
        $notes = Note::all()->groupBy(function ($note) {
            return $note->intake_year . '-' . $note->intake_semester . ($note->year_semester ? '-' . $note->year_semester : '');
        });

        return view('course-handbook.full-handbook-index', compact('coursesByYearAndIntake', 'years', 'totalCreditsBySemester', 'targetCreditsBySemester', 'notes'));
    }


}
