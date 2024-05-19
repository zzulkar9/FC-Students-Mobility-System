<!-- resources/views/study-plans/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Study Plan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="rounded-md bg-green-50 p-4">
                            <div class="flex">
                                <div class="ml-3">
                                    <p class="text-sm text-green-800">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('study-plans.update') }}">
                        @csrf

                        @foreach ($allCourses as $yearSemester => $courses)
                            <h3 class="text-lg leading-6 font-medium text-gray-900 py-2">{{ $yearSemester }}</h3>
                            <table class="min-w-full mt-2 text-sm">
                                <thead class="bg-cyan-100">
                                    <tr>
                                        <th class="border px-4 py-2">Course Code</th>
                                        <th class="border px-4 py-2">Course Name</th>
                                        <th class="border px-4 py-2">Credits</th>
                                        <th class="border px-4 py-2">Prerequisites</th>
                                        <th class="border px-4 py-2">Semester</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $course)
                                        @php
                                            $studyPlanCourse = $studyPlans->flatten()->firstWhere('course_id', $course->id);
                                            $selectedYearSemester = $studyPlanCourse ? $studyPlanCourse->year_semester : $yearSemester;
                                        @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="border px-4 py-2">{{ $course->course_code }}</td>
                                            <td class="border px-4 py-2">{{ $course->course_name }}</td>
                                            <td class="border px-4 py-2">{{ $course->course_credit }}</td>
                                            <td class="border px-4 py-2">{{ $course->prerequisites ?? 'None' }}</td>
                                            <td class="border px-4 py-2">
                                                <select name="courses[{{ $course->id }}][year_semester]" class="form-select mt-1 block w-full">
                                                    @foreach ($allCourses as $ys => $cs)
                                                        <option value="{{ $ys }}" {{ $ys == $selectedYearSemester ? 'selected' : '' }}>
                                                            {{ $ys }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="courses[{{ $course->id }}][course_id]" value="{{ $course->id }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endforeach

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Study Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
