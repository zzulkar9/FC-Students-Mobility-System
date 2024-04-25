<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Application Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('application-form.update', $applicationForm->id) }}">
                        @csrf
                        @method('PUT')

                        <h3 class="text-lg leading-6 font-medium text-gray-900">Student Information</h3>
                        <p>Name: {{ $applicationForm->user->name }}</p>
                        <p>Matric Number: {{ $applicationForm->user->matric_number }}</p>
                        <p>Current Semester: {{ Auth::user()->getCurrentSemester() }}</p>

                        <!-- Input for Link -->
                        <div class="mb-4">
                            <label for="link" class="block text-sm font-medium text-gray-700">Link:</label>
                            <input type="url" id="link" name="link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter URL here" value="{{ $applicationForm->link }}">
                        </div>

                        <!-- Table for dynamically adding/removing courses -->
                        <table class="mt-4 min-w-full table-auto">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-4 py-2 text-left">UTM Course</th>
                                    <th class="px-4 py-2 text-left">Target Course</th>
                                    <th class="px-4 py-2 text-left">Target Course Description</th>
                                    <th class="px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applicationForm->subjects as $subject)
                                <tr class="hover:bg-gray-100 course-field">
                                    <td class="border px-4 py-2">
                                        <select name="utm_course_id[]" class="utm-course-select">
                                            @foreach ($courses as $dropdownCourse)
                                                <option value="{{ $dropdownCourse->id }}" {{ $subject->utm_course_id == $dropdownCourse->id ? 'selected' : '' }}>
                                                    {{ $dropdownCourse->course_code }} - {{ $dropdownCourse->course_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <textarea name="target_course[]" rows="2" class="w-full">{{ $subject->target_course }}</textarea>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <textarea name="target_course_description[]" rows="2" class="w-full">{{ $subject->target_course_description }}</textarea>
                                    </td>
                                    <td class="border px-4 py-2 text-center">
                                        <button type="button" onclick="removeSubject(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Remove</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button type="button" onclick="addSubject()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 mt-4 rounded">
                            Add Subject
                        </button>

                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
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
        function addSubject() {
            const tableBody = document.querySelector('table tbody');
            const row = document.createElement('tr');
            row.className = 'course-field hover:bg-gray-100';
            row.innerHTML = `
                <td class="border px-4 py-2">
                    <select name="utm_course_id[]" class="utmCourseSelect" required>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="border px-4 py-2"><textarea name="target_course[]" rows="2" class="w-full"></textarea></td>
                <td class="border px-4 py-2"><textarea name="target_course_description[]" rows="2" class="w-full"></textarea></td>
                <td class="border px-4 py-2 text-center">
                    <button type="button" onclick="removeSubject(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Remove</button>
                </td>
            `;
            tableBody.appendChild(row);
            $(row).find('.utmCourseSelect').select2({ width: '100%' }); // Initialize Select2
        }

        function removeSubject(button) {
            const row = button.closest('tr');
            $(row).find('.utmCourseSelect').select2('destroy'); // Destroy Select2 before removing the row
            row.remove();
        }

        $(document).ready(function() {
            $('.utmCourseSelect').select2({ width: '100%' }); // Initialize Select2 for existing rows
        });
    </script>
</x-app-layout>
