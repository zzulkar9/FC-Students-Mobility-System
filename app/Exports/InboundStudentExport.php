<?php

namespace App\Exports;

use App\Models\InboundStudent;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InboundStudentExport implements FromArray, WithHeadings, WithStyles
{
    protected $student;

    public function __construct(InboundStudent $student)
    {
        $this->student = $student;
    }

    public function array(): array
    {
        $times = ['08:00-08:50', '09:00-09:50', '10:00-10:50', '11:00-11:50', '12:00-12:50', '13:00-13:50', '14:00-14:50', '15:00-15:50', '16:00-16:50'];
        $days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];

        $timetable = [];
        foreach ($times as $time) {
            $row = [$time];
            foreach ($days as $day) {
                $row[] = '';
            }
            $timetable[] = $row;
        }

        foreach ($this->student->timetables as $timetableItem) {
            $slots = explode(', ', $timetableItem->time_slot);
            foreach ($slots as $slot) {
                $parts = explode(' ', $slot);
                if (count($parts) == 2) {
                    [$day, $slotNumber] = $parts;
                    $dayIndex = array_search(strtoupper($day), $days) + 1;
                    $timeIndex = intval($slotNumber) - 1;

                    if (isset($timetable[$timeIndex]) && isset($timetable[$timeIndex][$dayIndex])) {
                        $timetable[$timeIndex][$dayIndex] = $timetableItem->course_code . ' - ' . $timetableItem->course_name;
                    }
                }
            }
        }

        return $timetable;
    }

    public function headings(): array
    {
        return ['Time', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
