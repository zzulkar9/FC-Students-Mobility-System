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
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('courses.create') }}"
                    class="ml-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue disabled:opacity-25 transition">
                    + Add Course
                </a>
            </div>
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
                                            <form method="POST" action="{{ route('notes.store') }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="intake_year" value="{{ $year }}">
                                                <input type="hidden" name="intake_semester" value="{{ $intake }}">
                                                <textarea name="note" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter note for {{ $intake }} here...">{{ isset($notes["$year-$intake"]) && $notes["$year-$intake"]->firstWhere('year_semester', null) ? $notes["$year-$intake"]->firstWhere('year_semester', null)->note : '' }}</textarea>
                                                <button type="submit" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">Save Note</button>
                                            </form>
                                        </h3>
                                        @foreach ($semesters as $semester => $courses)
                                            <h3
                                                class="px-6 py-3 border-b border-gray-200 bg-cyan-100 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">
                                                {{ $semester }}
                                                <a href="{{ route('courses.createForSemester', ['intakeYear' => $year, 'intakeSemester' => $intake, 'yearSemester' => $semester]) }}"
                                                    class="mr-6 bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs">
                                                     + Add
                                                 </a>                                                 
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
                                                                    <a> | </a>
                                                                    <a href="{{ route('courses.edit', $course->id) }}"
                                                                        class="text-green-500 hover:text-green-700">Update</a>
                                                                    <a> | </a>
                                                                    <form
                                                                        action="{{ route('courses.destroy', $course->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Are you sure?');"
                                                                        class="inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="text-red-500 hover:text-red-700">Delete</button>
                                                                    </form>
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

{{-- NEW --}}

{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Handbook') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="flex">
            <!-- Tabs Navigation -->
            <div class="w-1/6 bg-gray-200 p-4 border-r border-gray-300">
                <button class="tab-button active-tab w-full px-4 py-2 mb-2 rounded-lg hover:bg-blue-500" data-tab="view-tab-content">View</button>
                <button class="tab-button inactive-tab w-full px-4 py-2 mb-2 rounded-lg hover:bg-blue-200" data-tab="edit-tab-content">Edit</button>
                <a href="{{ route('courses.create') }}" class="inactive-tab w-full px-4 py-2 rounded-lg block text-center mt-2 bg-blue-500 hover:bg-blue-700 text-white">Add</a>
            </div>

            <!-- Tabs Content -->
            <div class="w-5/6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-gray-200">
                <div id="view-tab-content" class="tab-content active">
                    @include('course-handbook.course-handbook-partials.view', ['years' => $years, 'coursesByYearAndIntake' => $coursesByYearAndIntake, 'totalCreditsBySemester' => $totalCreditsBySemester, 'notes' => $notes])
                </div>
                <div id="edit-tab-content" class="tab-content">
                    @include('course-handbook.course-handbook-partials.edit', ['years' => $years, 'coursesByYearAndIntake' => $coursesByYearAndIntake, 'totalCreditsBySemester' => $totalCreditsBySemester, 'notes' => $notes])
                </div>
            </div>
        </div>
    </div>

    <style>
        .active-tab {
            background-color: #1D4ED8; /* Tailwind Blue-500 */
            color: #FFFFFF; /* White */
            border: 1px solid #1D4ED8; /* Border color to match the background */
        }

        .active-tab:hover {
            background-color: #1D4ED8; /* Tailwind Blue-500 */
        }

        .inactive-tab {
            background-color: #E5E7EB; /* Tailwind Gray-200 */
            color: #1F2937; /* Tailwind Gray-800 */
            border: 1px solid #D1D5DB; /* Tailwind Gray-300 */
        }

        .inactive-tab:hover {
            background-color: #BFDBFE; /* Tailwind Blue-200 */
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function switchTab(tabId) {
                const tabs = document.querySelectorAll('.tab-content');
                tabs.forEach(tab => {
                    tab.classList.remove('active');
                });
                document.getElementById(tabId).classList.add('active');

                const tabButtons = document.querySelectorAll('.tab-button');
                tabButtons.forEach(button => {
                    button.classList.remove('active-tab');
                    button.classList.add('inactive-tab');
                });
                document.querySelector(`[data-tab="${tabId}"]`).classList.add('active-tab');
                document.querySelector(`[data-tab="${tabId}"]`).classList.remove('inactive-tab');
            }

            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', function () {
                    switchTab(this.dataset.tab);
                });
            });

            // Activate the default tab
            switchTab('view-tab-content');
        });
    </script>
</x-app-layout> --}}


{{-- NEWEST --}}


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Handbook') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tabs Navigation -->
            <div class="tabs mb-8 flex justify-center border-b-2 border-gray-200">
                <button class="tab-button active" data-tab="view-tab-content">View</button>
                <button class="tab-button" data-tab="edit-tab-content">Edit</button>
                <button class="tab-button" data-tab="year-tab-content">Year by Year</button>
                <button class="tab-button" onclick="location.href='{{ route('courses.create') }}'">Add</button>
            </div>

            <!-- Tabs Content -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-gray-200">
                <div id="view-tab-content" class="tab-content active">
                    @include('course-handbook.course-handbook-partials.view', [
                        'years' => $years,
                        'coursesByYearAndIntake' => $coursesByYearAndIntake,
                        'totalCreditsBySemester' => $totalCreditsBySemester,
                        'notes' => $notes,
                    ])
                </div>
                <div id="edit-tab-content" class="tab-content">
                    @include('course-handbook.course-handbook-partials.edit', [
                        'years' => $years,
                        'coursesByYearAndIntake' => $coursesByYearAndIntake,
                        'totalCreditsBySemester' => $totalCreditsBySemester,
                        'notes' => $notes,
                    ])
                </div>
                <div id="year-tab-content" class="tab-content">
                    @include('course-handbook.course-handbook-partials.year-by-year', [
                        'years' => $years,
                        'coursesByYearAndIntake' => $coursesByYearAndIntake,
                        'totalCreditsBySemester' => $totalCreditsBySemester,
                        'notes' => $notes,
                    ])
                </div>
            </div>
        </div>
    </div>

    <style>
        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
            /* Tailwind gray-200 */
        }

        .tab-button {
            background-color: transparent;
            color: #4b5563;
            /* Tailwind gray-700 */
            padding: 10px 20px;
            margin: 0 10px;
            /* Added margin to separate buttons */
            border: none;
            border-bottom: 2px solid transparent;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .tab-button:hover {
            color: #2563eb;
            /* Tailwind indigo-600 */
            border-bottom: 2px solid #2563eb;
            /* Tailwind indigo-600 */
        }

        .tab-button.active {
            color: #2563eb;
            /* Tailwind indigo-600 */
            border-bottom: 2px solid #2563eb;
            /* Tailwind indigo-600 */
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function switchTab(tabId) {
                const tabs = document.querySelectorAll('.tab-content');
                tabs.forEach(tab => {
                    tab.classList.remove('active');
                });
                document.getElementById(tabId).classList.add('active');

                const tabButtons = document.querySelectorAll('.tab-button');
                tabButtons.forEach(button => {
                    button.classList.remove('active');
                });
                document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
            }

            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', function() {
                    const tabId = this.dataset.tab;
                    if (tabId) {
                        switchTab(tabId);
                    }
                });
            });

            // Activate the default tab
            switchTab('view-tab-content');
        });
    </script>
</x-app-layout>
