<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Study Plan for ') }} {{ $student->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Study Plan</h3>
                    @foreach ($studyPlans as $yearSemester => $plans)
                        <div class="semester-block" data-semester="{{ $yearSemester }}">
                            <h4 class="text-md leading-6 font-medium text-gray-900 py-2">{{ $yearSemester }}</h4>
                            <table class="min-w-full mt-2 text-sm">
                                <thead class="bg-cyan-100">
                                    <tr>
                                        <th class="border px-4 py-2">Course Code</th>
                                        <th class="border px-4 py-2">Course Name</th>
                                        <th class="border px-4 py-2">Credits</th>
                                        <th class="border px-4 py-2">Prerequisites</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($plans as $plan)
                                        <tr class="hover:bg-gray-50" data-course-id="{{ $plan->course_id }}">
                                            <td class="border px-4 py-2">{{ $plan->course->course_code }}</td>
                                            <td class="border px-4 py-2">{{ $plan->course->course_name }}</td>
                                            <td class="border px-4 py-2">{{ $plan->course->course_credit }}</td>
                                            <td class="border px-4 py-2">{{ $plan->course->prerequisites ?? 'None' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
