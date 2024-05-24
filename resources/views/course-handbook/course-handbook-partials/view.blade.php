<div x-data="{ activeYear: '{{ $years->isNotEmpty() ? $years->first()->intake_year : '' }}', activeIntake: 'March/April', search: '' }">
    <div class="flex flex-col mb-4">
        <div class="flex space-x-1 mb-2">
            @foreach ($years as $year)
                <button class="text-sm py-2 px-4 rounded-lg" :class="{ 'bg-blue-500 text-white': activeYear === '{{ $year->intake_year }}', 'bg-gray-200 text-gray-800': activeYear !== '{{ $year->intake_year }}' }" @click="activeYear = '{{ $year->intake_year }}'; activeIntake = 'March/April';">
                    {{ $year->intake_year }}
                </button>
            @endforeach
        </div>
        <div class="flex space-x-1 mb-2">
            <button class="text-sm py-2 px-4 rounded-lg" :class="{ 'bg-blue-500 text-white': activeIntake === 'March/April', 'bg-gray-200 text-gray-800': activeIntake !== 'March/April' }" @click="activeIntake = 'March/April'">
                March/April
            </button>
            <button class="text-sm py-2 px-4 rounded-lg" :class="{ 'bg-blue-500 text-white': activeIntake === 'September', 'bg-gray-200 text-gray-800': activeIntake !== 'September' }" @click="activeIntake = 'September'">
                September
            </button>
        </div>
    </div>
    <div class="flex justify-between mb-4">
        <input x-model="search" type="text" placeholder="Search courses..." class="form-input block w-full sm:text-sm sm:leading-5">
    </div>
    <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
        @foreach ($coursesByYearAndIntake as $year => $intakes)
            <div x-show="activeYear === '{{ $year }}'" x-cloak>
                @foreach ($intakes as $intake => $semesters)
                    <div x-show="activeIntake === '{{ $intake }}'">
                        <h3 class="px-6 py-3 border-b border-gray-200 bg-cyan-100 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">
                            {{ $intake }}
                        </h3>
                        <div class="mt-2 px-6 py-4 border border-gray-300 bg-gray-100 text-gray-700">
                            <strong>Notes for {{ $intake }}:</strong>
                            <p class="mt-2">{{ isset($notes["$year-$intake"]) && $notes["$year-$intake"]->firstWhere('year_semester', null) ? $notes["$year-$intake"]->firstWhere('year_semester', null)->note : 'No notes available' }}</p>
                        </div>
                        @foreach ($semesters as $semester => $courses)
                            <h3 class="px-6 py-3 border-b border-gray-200 bg-cyan-100 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider mt-4">
                                {{ $semester }}
                            </h3>
                            <table class="min-w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border border-gray-300 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">Course Code</th>
                                        <th class="px-6 py-3 border border-gray-300 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">Course Name</th>
                                        <th class="px-6 py-3 border border-gray-300 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">Credits</th>
                                        <th class="px-6 py-3 border border-gray-300 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">Prerequisites</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($courses as $course)
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-6 py-4 border border-gray-300 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600">{{ $course->course_code }}</td>
                                            <td class="px-6 py-4 border border-gray-300 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600">
                                                {{ $course->course_name }}
                                                <div class="text-xs mt-1 space-x-1">
                                                    <a href="{{ route('courses.show', $course->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 border border-gray-300 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600">{{ $course->course_credit }}</td>
                                            <td class="px-6 py-4 border border-gray-300 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600">{{ $course->prerequisites }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-gray-100">
                                        <td colspan="2" class="text-right px-6 py-4 font-medium">Total Credits:</td>
                                        <td class="px-6 py-4 font-medium">{{ $totalCreditsBySemester[$year][$intake][$semester] }}</td>
                                        <td></td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td colspan="4" class="px-6 py-4 border border-gray-300">
                                            <div class="mt-2 text-gray-700">
                                                <strong>Notes for {{ $semester }}:</strong>
                                                <p class="mt-2">{{ isset($notes["$year-$intake-$semester"]) ? $notes["$year-$intake-$semester"]->first()->note : 'No notes available' }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
