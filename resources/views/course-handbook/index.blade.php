{{-- course-handbook.index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Menu') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        activeYear: '{{ $years->first()->intake_year }}', 
        activeIntake: 'March/April', 
        search: '',
        filteredCourses(semesters) {
            return semesters.filter(course => course.course_code.toLowerCase().includes(this.search.toLowerCase()) || course.course_name.toLowerCase().includes(this.search.toLowerCase()));
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Year Tabs -->
            <div class="flex space-x-1 bg-blue-900 p-1">
                @foreach ($years as $year)
                    <button class="text-white py-2 px-4 hover:bg-blue-700 rounded-lg"
                        :class="{ 'bg-blue-500': activeYear === '{{ $year->intake_year }}' }"
                        @click="activeYear = '{{ $year->intake_year }}'; activeIntake = 'March/April';">
                        {{ $year->intake_year }}
                    </button>
                @endforeach
            </div>

            <!-- Intake Period Tabs -->
            <div class="mt-4 flex space-x-1 bg-gray-900 p-1">
                <button class="text-white py-2 px-4 hover:bg-gray-700 rounded-lg"
                    :class="{ 'bg-gray-500': activeIntake === 'March/April' }" @click="activeIntake = 'March/April'">
                    March/April
                </button>
                <button class="text-white py-2 px-4 hover:bg-gray-700 rounded-lg"
                    :class="{ 'bg-gray-500': activeIntake === 'September' }" @click="activeIntake = 'September'">
                    September
                </button>
            </div>

            <!-- Search Input -->
            <div class="mb-4">
                <input x-model="search" type="text" placeholder="Search courses..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Add Subject -->
            <div class="mb-4">
                <a href="{{ route('courses.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add Course
                </a>
            </div>

            <!-- Courses Table -->
            @foreach ($coursesByYearAndIntake as $year => $intakes)
                <div x-show="activeYear === '{{ $year }}'" x-cloak>
                    @foreach ($intakes as $intake => $semesters)
                        <div x-show="activeIntake === '{{ $intake }}'">
                            @foreach ($semesters as $semester => $courses)
                                <h3 class="text-lg mt-4 font-semibold">{{ $semester }}</h3>
                                <table class="min-w-full mt-2">
                                    <thead class="bg-gray-200">
                                        <tr>
                                            <th class="px-4 py-2">Course Code</th>
                                            <th class="px-4 py-2">Course Name</th>
                                            <th class="px-4 py-2">Credits</th>
                                            <th class="px-4 py-2">Prerequisites</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($courses as $course)
                                            <tr class="hover:bg-gray-100">
                                                <td class="border px-4 py-2">{{ $course->course_code }}</td>
                                                <td class="border px-4 py-2">
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
                                                <td class="border px-4 py-2">{{ $course->course_credit }}</td>
                                                <td class="border px-4 py-2">{{ $course->prerequisites ?? 'None' }}</td>
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

    {{-- Ensure Alpine.js is included in your layout or here directly --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
</x-app-layout>

