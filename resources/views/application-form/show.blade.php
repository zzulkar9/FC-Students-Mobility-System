<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Application Form') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>Student Information</h3>
                    <p>Name: {{ $applicationForm->user->name }}</p>
                    <p>Matric Number: {{ $applicationForm->user->matric_number }}</p>
                    <!-- Table for displaying UTM and Target University Courses -->
                    <table class="min-w-full table-auto break-words">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">UTM Course Code</th>
                                <th class="px-4 py-2 text-left">UTM Course Name</th>
                                <th class="px-4 py-2 text-left">UTM Description</th>
                                <th class="px-4 py-2 text-left">Target Course</th>
                                <th class="px-4 py-2 text-left">Target Course Description</th>
                                <th class="px-4 py-2 text-left">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applicationForm->subjects as $subject)
                                <tr class="hover:bg-gray-100">
                                    <td class="border px-4 py-2">{{ $subject->utm_course_code }}</td>
                                    <td class="border px-4 py-2">{{ $subject->utm_course_name }}</td>
                                    <td class="border px-4 py-2">{{ $subject->utm_course_description }}</td>
                                    <td class="border px-4 py-2">{{ $subject->target_course }}</td>
                                    <td class="border px-4 py-2">{{ $subject->target_course_description }}</td>
                                    <td class="border px-4 py-2">{{ $subject->notes }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
