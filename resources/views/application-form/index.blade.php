<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Application Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Display student information -->
                    <div class="mb-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Student Information</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Name: {{ Auth::user()->name }}
                        </p>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Matric Number: {{ Auth::user()->matric_number }}
                        </p>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Current Semester: {{ Auth::user()->getCurrentSemester() }}
                        </p>
                    </div>
                    <form method="POST" action="{{ route('application-form.submit') }}" id="applicationForm">
                        @csrf
                        <table id="courseFields" class="min-w-full table-auto break-words">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-4 py-2 text-left">UTM Course</th>
                                    <th class="px-4 py-2 text-left">Target University Course</th>
                                    <th class="px-4 py-2 text-left">Course Description at Target University</th>
                                    <th class="px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Initial course field will be added here by JavaScript -->
                            </tbody>
                        </table>

                        <!-- Button to add more subjects -->
                        <button type="button" onclick="addCourseField()"
                            class="mt-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Add More Subject
                        </button>

                        <!-- Actions -->
                        <div class="mt-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Submit
                            </button>
                            <button type="submit" name="action" value="save_draft"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Save Draft
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2/dist/css/select2.min.css" rel="stylesheet" />

    <script>
        function addCourseField() {
            const tableBody = document.querySelector('#courseFields tbody');
            const row = document.createElement('tr');
            row.className = 'course-field';
            row.innerHTML = `
                <td class="border px-4 py-2" style="width: 20%;">
                    <select name="utm_course_id[]" class="utmCourseSelect" required>
                        <option value="">Select a Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="border px-4 py-2" style="width: 35%;">
                    <textarea name="target_course[]" rows="2" required></textarea>
                </td>
                <td class="border px-4 py-2" style="width: 35%;">
                    <textarea name="target_course_description[]" rows="2" required></textarea>
                </td>
                <td class="border px-4 py-2" style="width: 5%;">
                    <button type="button" onclick="removeCourseField(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Remove</button>
                </td>
            `;
            tableBody.appendChild(row);
            $(row).find('.utmCourseSelect').select2({ width: '100%' });  // Initialize Select2
        }

        function removeCourseField(button) {
            const row = button.closest('tr');
            $(row).find('.utmCourseSelect').select2('destroy');  // Destroy Select2 before removing row
            row.remove();
        }

        window.onload = function() {
            addCourseField(); // Add first set of input fields on page load
        };
    </script>

    <style>
        textarea {
            width: 100%;
        }
    </style>
</x-app-layout>
