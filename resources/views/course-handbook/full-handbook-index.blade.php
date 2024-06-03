{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Handbook') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        activeYear: '{{ $years->isNotEmpty() ? $years->first()->intake_year : '' }}',
        activeIntake: 'March/April',
        search: ''
    }">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Tabs and Content Area -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <!-- Year and Intake Tabs -->
                    <div class="flex gap-4 mb-4 flex-col">
                        <div class="flex space-x-1">
                            @foreach ($years as $year)
                                <button class="text-sm py-2 px-4 rounded-lg"
                                    :class="{ 'bg-blue-500 text-white': activeYear === '{{ $year->intake_year }}', 'bg-gray-200 text-gray-800': activeYear !== '{{ $year->intake_year }}' }"
                                    @click="activeYear = '{{ $year->intake_year }}'; activeIntake = 'March/April';">
                                    {{ $year->intake_year }}
                                </button>
                            @endforeach
                        </div>
                        <div class="flex space-x-1">
                            <button class="text-sm py-2 px-4 rounded-lg"
                                :class="{ 'bg-blue-500 text-white': activeIntake === 'March/April', 'bg-gray-200 text-gray-800': activeIntake !== 'March/April' }"
                                @click="activeIntake = 'March/April'">
                                March/April
                            </button>
                            <button class="text-sm py-2 px-4 rounded-lg"
                                :class="{ 'bg-blue-500 text-white': activeIntake === 'September', 'bg-gray-200 text-gray-800': activeIntake !== 'September' }"
                                @click="activeIntake = 'September'">
                                September
                            </button>
                        </div>
                    </div>

                    <!-- Search and Add Course -->
                    <div class="flex justify-between mb-4">
                        <input x-model="search" type="text" placeholder="Search courses..."
                            class="form-input block w-full sm:text-sm sm:leading-5">
                    </div>

                    <!-- Courses Table -->
                    <div
                        class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                        @foreach ($coursesByYearAndIntake as $year => $intakes)
                            <div x-show="activeYear === '{{ $year }}'" x-cloak>
                                @foreach ($intakes as $intake => $semesters)
                                    <div x-show="activeIntake === '{{ $intake }}'">
                                        <h3
                                            class="px-6 py-3 border-b border-gray-200 bg-cyan-100 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">
                                            {{ $intake }}
                                            <div class="mt-2">
                                                <div class="p-4 bg-gray-100 rounded-lg">
                                                    <strong>Note for {{ $intake }}:</strong>
                                                    <p>{{ isset($notes["$year-$intake"]) && $notes["$year-$intake"]->firstWhere('year_semester', null) ? $notes["$year-$intake"]->firstWhere('year_semester', null)->note : 'No notes available.' }}</p>
                                                </div>
                                            </div>
                                        </h3>
                                        @foreach ($semesters as $semester => $courses)
                                            <h3
                                                class="px-6 py-3 border-b border-gray-200 bg-cyan-100 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">
                                                {{ $semester }}
                                            </h3>
                                            <table class="min-w-full">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">
                                                            Course Code
                                                        </th>
                                                        <th
                                                            class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">
                                                            Course Name
                                                        </th>
                                                        <th
                                                            class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">
                                                            Credits
                                                        </th>
                                                        <th
                                                            class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">
                                                            Prerequisites
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                    @foreach ($courses as $course)
                                                        <tr class="hover:bg-gray-100">
                                                            <td
                                                                class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600">
                                                                {{ $course->course_code }}
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600">
                                                                {{ $course->course_name }}
                                                                <div class="text-xs mt-1 space-x-1">
                                                                    <a href="{{ route('courses.show', $course->id) }}"
                                                                        class="text-blue-500 hover:text-blue-700">View</a>
                                                                </div>
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600">
                                                                {{ $course->course_credit }}
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600">
                                                                {{ $course->prerequisites }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <!-- Add a row for displaying total credits -->
                                                    <tr class="bg-gray-100">
                                                        <td colspan="2" class="text-right px-6 py-4 font-medium">
                                                            Total Credits:</td>
                                                        <td class="px-6 py-4 font-medium">
                                                            {{ $totalCreditsBySemester[$year][$intake][$semester] }}
                                                        </td>
                                                        <td></td> <!-- Empty cell for alignment -->
                                                    </tr>
                                                    <!-- Note for the semester -->
                                                    <tr class="bg-gray-100">
                                                        <td colspan="4" class="px-6 py-4">
                                                            <div class="p-4 bg-gray-100 rounded-lg">
                                                                <strong>Note for {{ $semester }}:</strong>
                                                                <p>{{ isset($notes["$year-$intake-$semester"]) ? $notes["$year-$intake-$semester"]->first()->note : 'No notes available.' }}</p>
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
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
</x-app-layout> --}}



<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Course Handbook') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        activeYear: '{{ $years->isNotEmpty() ? $years->first()->intake_year : '' }}',
        activeIntake: 'March/April',
        search: '',
        get filteredCourses() {
            return this.search === '' ? {{ json_encode($coursesByYearAndIntake) }} : this.filterCourses()
        },
        filterCourses() {
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
            return this.filteredCourses[year][intake][semester].reduce((total, course) => total + parseInt(course.course_credit), 0);
        }
    }">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Year and Intake Tabs -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center space-x-2">
                        <p class="text-lg font-semibold text-gray-700">Year:</p>
                        @foreach ($years as $year)
                            <button class="text-sm py-2 px-4 rounded-lg border border-gray-300 transition duration-200"
                                :class="{ 'bg-blue-500 text-white': activeYear === '{{ $year->intake_year }}', 'bg-gray-200 text-gray-800': activeYear !== '{{ $year->intake_year }}' }"
                                @click="activeYear = '{{ $year->intake_year }}'; activeIntake = 'March/April';">
                                {{ $year->intake_year }}
                            </button>
                        @endforeach
                    </div>
                    <div class="flex items-center space-x-2">
                        <p class="text-lg font-semibold text-gray-700">Intake:</p>
                        <button class="text-sm py-2 px-4 rounded-lg border border-gray-300 transition duration-200"
                            :class="{ 'bg-blue-500 text-white': activeIntake === 'March/April', 'bg-gray-200 text-gray-800': activeIntake !== 'March/April' }"
                            @click="activeIntake = 'March/April'">
                            March/April
                        </button>
                        <button class="text-sm py-2 px-4 rounded-lg border border-gray-300 transition duration-200"
                            :class="{ 'bg-blue-500 text-white': activeIntake === 'September', 'bg-gray-200 text-gray-800': activeIntake !== 'September' }"
                            @click="activeIntake = 'September'">
                            September
                        </button>
                    </div>
                </div>
            </div>


            <!-- Search Input -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
                <input x-model="search" type="text" placeholder="Search courses..."
                    class="form-input block w-full sm:text-sm sm:leading-5 border border-gray-300 rounded-lg p-2">
            </div>

            <!-- Courses Table -->
            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <template x-for="(intakes, year) in filteredCourses" :key="year">
                    <div x-show="activeYear === year" x-cloak>
                        <template x-for="(semesters, intake) in intakes" :key="intake">
                            <div x-show="activeIntake === intake">
                                <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-2" x-text="intake"></h3>
                                <div class="bg-gray-100 p-4 rounded-lg mb-6">
                                    <strong x-text="'Note for ' + intake + ':'"></strong>
                                    <p x-text="notes[year + '-' + intake] && notes[year + '-' + intake].find(note => !note.year_semester) ? notes[year + '-' + intake].find(note => !note.year_semester).note : 'No notes available.'"></p>
                                </div>
                                <template x-for="(courses, semester) in semesters" :key="semester">
                                    <div>
                                        <h4 class="text-md font-semibold text-gray-700 mt-4 mb-2" x-text="semester"></h4>
                                        <table class="min-w-full mb-6 border-collapse border border-gray-300">
                                            <thead>
                                                <tr>
                                                    <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider border border-gray-300">Course Code</th>
                                                    <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider border border-gray-300">Course Name</th>
                                                    <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider border border-gray-300">Credits</th>
                                                    <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider border border-gray-300">Prerequisites</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white">
                                                <template x-for="course in courses" :key="course.course_code">
                                                    <tr class="hover:bg-gray-100">
                                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600 border border-gray-300" x-text="course.course_code"></td>
                                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600 border border-gray-300">
                                                            <span x-text="course.course_name"></span>
                                                            <div class="text-xs mt-1 space-x-1">
                                                                <a :href="`{{ route('courses.show', '') }}/${course.id}`" class="text-blue-500 hover:text-blue-700">View</a>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600 border border-gray-300" x-text="course.course_credit"></td>
                                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600 border border-gray-300" x-text="course.prerequisites"></td>
                                                    </tr>
                                                </template>
                                                <!-- Add a row for displaying total credits -->
                                                <tr class="bg-gray-100">
                                                    <td colspan="2" class="text-right px-6 py-4 font-medium border border-gray-300">Total Credits:</td>
                                                    <td class="px-6 py-4 font-medium border border-gray-300" x-text="getTotalCredits(year, intake, semester)"></td>
                                                    <td></td> <!-- Empty cell for alignment -->
                                                </tr>
                                                <!-- Note for the semester -->
                                                <tr class="bg-gray-100">
                                                    <td colspan="4" class="px-6 py-4 border border-gray-300">
                                                        <div class="p-4 bg-gray-100 rounded-lg">
                                                            <strong x-text="'Note for ' + semester + ':'"></strong>
                                                            <p x-text="notes[year + '-' + intake + '-' + semester] ? notes[year + '-' + intake + '-' + semester][0].note : 'No notes available.'"></p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
</x-app-layout>


