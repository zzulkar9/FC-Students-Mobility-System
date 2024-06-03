{{-- <div x-data="{ activeYear: '{{ $years->isNotEmpty() ? $years->first()->intake_year : '' }}', activeIntake: 'March/April', search: '' }">
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
                                            <td class="px-6 py-4 border border-gray-300 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600">
                                                <span class="relative" x-data="{ showTooltip: false }" @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
                                                    {{ $course->course_credit }}
                                                    @if ($totalCreditsBySemester[$year][$intake][$semester] < $targetCreditsBySemester[$year][$intake][$semester])
                                                        <div x-show="showTooltip" class="absolute bg-gray-800 text-white text-xs rounded py-1 px-2 bottom-full left-1/2 transform -translate-x-1/2">
                                                            Below target credit
                                                        </div>
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 border border-gray-300 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600">{{ $course->prerequisites }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-gray-100">
                                        <td colspan="2" class="text-right px-6 py-4 font-medium">Total Credits:</td>
                                        <td class="px-6 py-4 font-medium {{ $totalCreditsBySemester[$year][$intake][$semester] < $targetCreditsBySemester[$year][$intake][$semester] ? 'text-red-500' : '' }}">
                                            <span class="relative" x-data="{ showTooltip: false }" @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
                                                {{ $totalCreditsBySemester[$year][$intake][$semester] }}
                                                @if ($totalCreditsBySemester[$year][$intake][$semester] < $targetCreditsBySemester[$year][$intake][$semester])
                                                    <div x-show="showTooltip" class="absolute bg-gray-800 text-white text-xs rounded py-1 px-2 bottom-full left-1/2 transform -translate-x-1/2">
                                                        Below target credit
                                                    </div>
                                                @endif
                                            </span>
                                        </td>
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
</div> --}}


<div x-data="{ 
    activeYear: '{{ $years->isNotEmpty() ? $years->first()->intake_year : '' }}', 
    activeIntake: 'March/April', 
    search: '',
    filteredCourses() {
        const searchTerm = this.search.toLowerCase();
        let filtered = {};
        @foreach ($coursesByYearAndIntake as $year => $intakes)
            filtered['{{ $year }}'] = {};
            @foreach ($intakes as $intake => $semesters)
                filtered['{{ $year }}']['{{ $intake }}'] = {};
                @foreach ($semesters as $semester => $courses)
                    filtered['{{ $year }}']['{{ $intake }}']['{{ $semester }}'] = {{ json_encode($courses) }}.filter(course => 
                        course.course_code.toLowerCase().includes(searchTerm) ||
                        course.course_name.toLowerCase().includes(searchTerm) ||
                        course.course_credit.toString().includes(searchTerm) ||
                        (course.prerequisites && course.prerequisites.toLowerCase().includes(searchTerm))
                    );
                @endforeach
            @endforeach
        @endforeach
        return filtered;
    },
    getTotalCredits(year, intake, semester) {
        return this.filteredCourses()[year][intake][semester].reduce((total, course) => total + parseInt(course.course_credit), 0);
    }
}">
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
                            <details class="mt-4 group">
                                <summary class="cursor-pointer text-gray-700 font-medium py-2 flex items-center justify-between hover:bg-gray-100">
                                    <div class="flex items-center space-x-2">
                                        <span class="mr-2 transform transition-transform duration-200" :class="{'rotate-90': open}">&#9654;</span>
                                        <span>{{ $semester }}</span>
                                    </div>
                                </summary>
                                <table class="min-w-full mt-2 text-sm border-collapse border border-gray-300">
                                    <thead>
                                        <tr class="bg-cyan-100">
                                            <th class="border px-4 py-2">Course Code</th>
                                            <th class="border px-4 py-2">Course Name</th>
                                            <th class="border px-4 py-2">Credits</th>
                                            <th class="border px-4 py-2">Prerequisites</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="course in filteredCourses()['{{ $year }}']['{{ $intake }}']['{{ $semester }}']" :key="course.course_code">
                                            <tr class="hover:bg-gray-50">
                                                <td class="border px-4 py-2" x-text="course.course_code"></td>
                                                <td class="border px-4 py-2">
                                                    <span x-text="course.course_name"></span>
                                                    <div><a :href="`{{ route('courses.show', '') }}/${course.id}`" class="text-blue-500 hover:text-blue-700 text-xs">View</a></div>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="relative" x-data="{ showTooltip: false }" @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
                                                        <span x-text="course.course_credit"></span>
                                                        <div x-show="showTooltip" class="absolute bg-gray-800 text-white text-xs rounded py-1 px-2 bottom-full left-1/2 transform -translate-x-1/2" x-show="course.course_credit < targetCreditsBySemester[year][intake][semester]">
                                                            Below target credit
                                                        </div>
                                                    </span>
                                                </td>
                                                <td class="border px-4 py-2" x-text="course.prerequisites ?? 'None'"></td>
                                            </tr>
                                        </template>
                                        <tr class="bg-gray-100">
                                            <td colspan="2" class="text-right px-6 py-4 font-medium">Total Credits:</td>
                                            <td class="px-6 py-4 font-medium" :class="getTotalCredits('{{ $year }}', '{{ $intake }}', '{{ $semester }}') < targetCreditsBySemester['{{ $year }}']['{{ $intake }}']['{{ $semester }}'] ? 'text-red-500' : ''" x-text="getTotalCredits('{{ $year }}', '{{ $intake }}', '{{ $semester }}')"></td>
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
                            </details>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>




