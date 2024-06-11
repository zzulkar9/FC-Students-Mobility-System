<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Inbound Student') }}: {{ $student->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $student->name }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Country</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $student->country }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Semester</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $student->semester }}</p>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Timetable</h3>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Code</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timeslot</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($timetables as $timetable)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $timetable->course_code }}</td>
                                            <td class="border px-4 py-2">{{ $timetable->course_name }}</td>
                                            <td class="border px-4 py-2">{{ $timetable->section }}</td>
                                            <td class="border px-4 py-2">{{ $timetable->time_slot }}</td>
                                            <td class="border px-4 py-2">{{ $timetable->year }}</td>
                                            <td class="border px-4 py-2">{{ $timetable->semester }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
