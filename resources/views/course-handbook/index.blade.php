<x-app-layout>
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
                <a href="{{ route('courses.create') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue disabled:opacity-25 transition">
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
                                    :class="{'bg-blue-500 text-white': activeYear === '{{ $year->intake_year }}', 'bg-gray-200 text-gray-800': activeYear !== '{{ $year->intake_year }}'}"
                                    @click="activeYear = '{{ $year->intake_year }}'; activeIntake = 'March/April';">
                                    {{ $year->intake_year }}
                                </button>
                            @endforeach
                        </div>
                        <div class="flex space-x-1">
                            <button class="text-sm py-2 px-4 rounded-lg"
                                :class="{'bg-blue-500 text-white': activeIntake === 'March/April', 'bg-gray-200 text-gray-800': activeIntake !== 'March/April'}"
                                @click="activeIntake = 'March/April'">
                                March/April
                            </button>
                            <button class="text-sm py-2 px-4 rounded-lg"
                                :class="{'bg-blue-500 text-white': activeIntake === 'September', 'bg-gray-200 text-gray-800': activeIntake !== 'September'}"
                                @click="activeIntake = 'September'">
                                September
                            </button>
                        </div>
                    </div>

                    <!-- Search and Add Course -->
                    <div class="flex justify-between mb-4">
                        <input x-model="search" type="text" placeholder="Search courses..." class="form-input block w-full sm:text-sm sm:leading-5">
                    </div>

                    <!-- Courses Table -->
                    <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                        @foreach ($coursesByYearAndIntake as $year => $intakes)
                            <div x-show="activeYear === '{{ $year }}'" x-cloak>
                                @foreach ($intakes as $intake => $semesters)
                                    <div x-show="activeIntake === '{{ $intake }}'">
                                        @foreach ($semesters as $semester => $courses)
                                            <h3 class="px-6 py-3 border-b border-gray-200 bg-cyan-100 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">
                                                {{ $semester }}
                                            </h3>
                                            <table class="min-w-full">
                                                <thead>
                                                    <tr>
                                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">
                                                            Course Code
                                                        </th>
                                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">
                                                            Course Name
                                                        </th>
                                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">
                                                            Credits
                                                        </th>
                                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-900 uppercase tracking-wider">
                                                            Prerequisites
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                    @foreach ($courses as $course)
                                                        <tr class="hover:bg-gray-100">
                                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600">
                                                                {{ $course->course_code }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600">
                                                                {{ $course->course_name }}
                                                                <div class="text-xs mt-1 space-x-1">
                                                                    <a href="{{ route('courses.show', $course->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                                                    <a> | </a>
                                                                    <a href="{{ route('courses.edit', $course->id) }}" class="text-green-500 hover:text-green-700">Update</a>
                                                                    <a> | </a>
                                                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600">
                                                                {{ $course->course_credit }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-600">
                                                                {{ $course->prerequisites }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
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
</x-app-layout>
