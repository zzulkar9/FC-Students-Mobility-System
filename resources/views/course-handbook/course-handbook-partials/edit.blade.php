<div x-data="{ 
    activeYear: '{{ $years->isNotEmpty() ? $years->first()->intake_year : '' }}', 
    activeIntake: 'March/April', 
    search: '',
    get filteredCourses() {
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
                            <form method="POST" action="{{ route('notes.store') }}">
                                @csrf
                                <input type="hidden" name="intake_year" value="{{ $year }}">
                                <input type="hidden" name="intake_semester" value="{{ $intake }}">
                                <textarea name="note" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter note for {{ $intake }} here...">{{ isset($notes["$year-$intake"]) && $notes["$year-$intake"]->firstWhere('year_semester', null) ? $notes["$year-$intake"]->firstWhere('year_semester', null)->note : '' }}</textarea>
                                <button type="submit" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">Save Note</button>
                            </form>
                        </div>
                        @foreach ($semesters as $semester => $courses)
                            <details class="mt-4 group">
                                <summary class="cursor-pointer text-gray-700 font-medium py-2 flex items-center justify-between hover:bg-gray-100">
                                    <div class="flex items-center space-x-2">
                                        <span class="mr-2 transform transition-transform duration-200" :class="{'rotate-90': open}">&#9654;</span>
                                        <span>{{ $semester }}</span>
                                    </div>
                                    <span class="flex space-x-2">
                                        <a href="{{ route('courses.createForSemester', ['intakeYear' => $year, 'intakeSemester' => $intake, 'yearSemester' => $semester]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs">
                                            + Add
                                        </a>
                                        <a href="{{ route('courses.editForSemester', ['intakeYear' => $year, 'intakeSemester' => $intake, 'yearSemester' => $semester]) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs">
                                            Edit
                                        </a>
                                    </span>
                                </summary>
                                <div class="px-6 py-4 border border-gray-300 bg-gray-100 text-gray-700">
                                    <form method="POST" action="{{ route('courses.setTargetCredits') }}">
                                        @csrf
                                        <input type="hidden" name="intake_year" value="{{ $year }}">
                                        <input type="hidden" name="intake_semester" value="{{ $intake }}">
                                        <input type="hidden" name="year_semester" value="{{ $semester }}">
                                        <label for="target_credits">Target Credits for {{ $semester }}:</label>
                                        <input type="number" name="target_credits" value="{{ $targetCreditsBySemester[$year][$intake][$semester] }}" class="w-1/4 rounded-md border-gray-300 shadow-sm">
                                        <button type="submit" class="ml-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">Set Target</button>
                                    </form>
                                </div>
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
                                        <template x-for="course in filteredCourses['{{ $year }}']['{{ $intake }}']['{{ $semester }}']" :key="course.course_code">
                                            <tr class="hover:bg-gray-50">
                                                <td class="border px-4 py-2" x-text="course.course_code"></td>
                                                <td class="border px-4 py-2">
                                                    <span x-text="course.course_name"></span>
                                                    <div class="text-xs mt-1 space-x-1">
                                                        <a :href="`{{ route('courses.show', '') }}/${course.id}`" class="text-blue-500 hover:text-blue-700">View</a>
                                                        <a> | </a>
                                                        <a :href="`{{ route('courses.edit', '') }}/${course.id}`" class="text-green-500 hover:text-green-700">Update</a>
                                                        <a> | </a>
                                                        <form :action="`{{ route('courses.destroy', '') }}/${course.id}`" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td class="border px-4 py-2" x-text="course.course_credit"></td>
                                                <td class="border px-4 py-2" x-text="course.prerequisites ?? 'None'"></td>
                                            </tr>
                                        </template>
                                        <tr class="bg-gray-100">
                                            <td colspan="2" class="text-right px-6 py-4 font-medium">Total Credits:</td>
                                            <td class="px-6 py-4 font-medium {{ $totalCreditsBySemester[$year][$intake][$semester] < $targetCreditsBySemester[$year][$intake][$semester] ? 'text-red-500' : '' }}">
                                                {{ $totalCreditsBySemester[$year][$intake][$semester] }}
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="bg-gray-100">
                                            <td colspan="4" class="px-6 py-4 border border-gray-300">
                                                <form method="POST" action="{{ route('notes.store') }}">
                                                    @csrf
                                                    <input type="hidden" name="intake_year" value="{{ $year }}">
                                                    <input type="hidden" name="intake_semester" value="{{ $intake }}">
                                                    <input type="hidden" name="year_semester" value="{{ $semester }}">
                                                    <textarea name="note" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter note here...">{{ isset($notes["$year-$intake-$semester"]) ? $notes["$year-$intake-$semester"]->first()->note : '' }}</textarea>
                                                    <button type="submit" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">Save Note</button>
                                                </form>
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
