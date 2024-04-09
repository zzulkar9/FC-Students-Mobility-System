<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Handbook') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('course-handbook.index') }}">
                <div class="flex space-x-4 items-center mb-4">
                    <input type="text" name="search" class="rounded-md shadow-sm border-gray-300"
                        placeholder="Search courses..." value="{{ request('search') }}">
                    <button type="submit" class="px-2 py-2 bg-blue-500 rounded-md">🔍</button>
                </div>
            </form>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Optionally, link to a page for adding a new course --}}
                    <div class="mb-4">
                        <a href="{{ route('courses.create') }}" class="text-blue-600 hover:text-blue-900">
                            Add Course
                        </a>
                    </div>
                    <table class="min-w-full w-full border-collapse border border-gray-300">
                        <thead>
                            <tr>
                                <th
                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 bg-gray-100 border border-gray-300 text-center">
                                    Course Code</th>
                                <th
                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 bg-gray-100 border border-gray-300 text-center">
                                    Course Name</th>
                                <th
                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 bg-gray-100 border border-gray-300 text-center">
                                    Year and Semester</th>
                                <th
                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 bg-gray-100 border border-gray-300 text-center">
                                    Course Credit</th>
                                <th
                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 bg-gray-100 border border-gray-300 text-center">
                                    Pre-requisites</th>
                                <th
                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 bg-gray-100 border border-gray-300 text-center">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr class="hover:bg-gray-100">
                                    <td class="p-2 border-b border-gray-300 text-sm text-center">
                                        {{ $course->course_code }}</td>
                                    <td class="p-2 border-b border-gray-300 text-sm text-center">
                                        {{ $course->course_name }}</td>
                                    <td class="p-2 border-b border-gray-300 text-sm text-center">
                                        {{ $course->year_semester }}</td>
                                    <td class="p-2 border-b border-gray-300 text-sm text-center">
                                        {{ $course->course_credit }}</td>
                                    <td class="p-2 border-b border-gray-300 text-sm text-center">
                                        {{ $course->prerequisites }}</td>
                                    <td class="p-2 border-b border-gray-300 text-sm text-center">
                                        <a href="{{ route('courses.edit', $course->id) }}"
                                            class="text-green-600">Update</a>
                                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 py-1"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                        <a href="{{ route('courses.show', $course->id) }}"
                                            class="text-fuchsia-500">View Full Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <div class="mt-4 pb-3">
                            {{ $courses->appends(['search' => request('search')])->links() }}
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
