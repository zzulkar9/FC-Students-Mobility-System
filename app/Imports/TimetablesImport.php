<?php

namespace App\Imports;

use App\Models\Timetable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TimetablesImport implements ToCollection
{
    private $year;
    private $semester;

    public function __construct($year, $semester)
    {
        $this->year = $year;
        $this->semester = $semester;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) 
        {
            // Skip header row
            if ($index === 0) {
                continue;
            }

            if (!isset($row[0]) || !isset($row[1]) || !isset($row[2]) || !isset($row[3])) {
                continue;
            }

            $sections = explode('-', $row[3]);
            $startSection = intval($sections[0]);
            $endSection = isset($sections[1]) ? intval($sections[1]) : $startSection;

            $timeslots = array_slice($row->toArray(), 4); // Timeslots start from the 5th column

            for ($section = $startSection; $section <= $endSection; $section++) {
                Timetable::create([
                    'course_code' => $row[0],
                    'course_name' => $row[1],
                    'program_type' => $row[2],
                    'section' => str_pad($section, 2, '0', STR_PAD_LEFT),
                    'time_slot' => implode(', ', $timeslots),
                    'year' => $this->year,
                    'semester' => $this->semester,
                ]);
            }
        }
    }
}
