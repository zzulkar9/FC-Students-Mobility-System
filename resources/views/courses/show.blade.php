<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-center mb-6">Course Details</h1>

                <!-- Course Details Table -->
                <table class="min-w-full divide-y divide-gray-200 min-w-full w-full border-collapse border border-gray-300">
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 border border-gray-300 bg-gray-400 whitespace-nowrap text-sm font-medium text-gray-900">Course Code</td>
                            <td class="px-6 py-4 border-b border-gray-300 whitespace-nowrap text-sm text-gray-500">{{ $course->course_code }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 border border-gray-300 bg-gray-400 whitespace-nowrap text-sm font-medium text-gray-900">Course Name</td>
                            <td class="px-6 py-4 border-b border-gray-300 whitespace-nowrap text-sm text-gray-500">{{ $course->course_name }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 border border-gray-300 bg-gray-400 whitespace-nowrap text-sm font-medium text-gray-900">Year and Semester</td>
                            <td class="px-6 py-4 border-b border-gray-300 whitespace-nowrap text-sm text-gray-500">{{ $course->year_semester }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 border border-gray-300 bg-gray-400 whitespace-nowrap text-sm font-medium text-gray-900">Course Credit</td>
                            <td class="px-6 py-4 border-b border-gray-300 whitespace-nowrap text-sm text-gray-500">{{ $course->course_credit }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 border border-gray-300 bg-gray-400 whitespace-nowrap text-sm font-medium text-gray-900">Prerequisites</td>
                            <td class="px-6 py-4 border-b border-gray-300 whitespace-nowrap text-sm text-gray-500">{{ $course->prerequisites ?? 'None' }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 border border-gray-300 bg-gray-400 whitespace-nowrap text-sm font-medium text-gray-900">Description</td>
                            <td class="px-6 py-4 border-b border-gray-300 whitespace-nowrap text-sm text-gray-500">{{ $course->description ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Edit Button -->
                <div class="flex items-center mt-4 justify-center">
                    <a href="{{ route('courses.edit', $course->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
