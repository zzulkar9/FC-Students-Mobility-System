<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Application Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Student Information</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Name: {{ Auth::user()->name }}</p>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Matric Number: {{ Auth::user()->matric_number }}
                        </p>
                        @if (Auth::user()->isUtmStudent())
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Upcoming Semester:
                                {{ Auth::user()->getCurrentSemester() }}</p>
                        @endif
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Intake: {{ Auth::user()->intake_period }}</p>
                    </div>
                    @if (Auth::user()->isUtmStudent())
                        @if (!empty($courses))
                            <form method="POST" action="{{ route('application-form.submit') }}">
                                @csrf
                                <!-- Add Link Input Field -->
                                <div class="mb-4">
                                    <label for="link" class="block text-sm font-medium text-gray-700">Enter
                                        Link:</label>
                                    <input type="url" id="link" name="link"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                        placeholder="Enter URL here">
                                </div>
                                <table id="courseFields" class="min-w-full table-auto">
                                    <thead class="bg-gray-200">
                                        <tr>
                                            <th class="px-4 py-2 text-left">UTM Course</th>
                                            <th class="px-4 py-2 text-left">Target University Course</th>
                                            <th class="px-4 py-2 text-left">Course Description at Target University</th>
                                            <th class="px-4 py-2 text-left">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($courses as $course)
                                            <tr class="course-field">
                                                <td class="border px-4 py-2">
                                                    <select name="utm_course_id[]" class="utm-course-select">
                                                        @foreach ($allCourses as $dropdownCourse)
                                                            <option value="{{ $dropdownCourse->id }}"
                                                                {{ $dropdownCourse->id == $course->id ? 'selected' : '' }}>
                                                                {{ $dropdownCourse->course_code }} -
                                                                {{ $dropdownCourse->course_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <textarea name="target_course[]" rows="2" class="w-full"></textarea>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <textarea name="target_course_description[]" rows="2" class="w-full"></textarea>
                                                </td>
                                                <td class="border px-4 py-2 text-center">
                                                    <button type="button" onclick="removeCourseField(this)"
                                                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Remove</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="button" onclick="addCourseField()"
                                    class="mt-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add
                                    More Subject</button>
                                <div class="flex items-center justify-center mt-4">
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                                    <button type="submit" name="action" value="save_draft"
                                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Save
                                        Draft</button>
                                </div>
                            </form>
                        @else
                            <div class="text-center p-4">
                                {{ $message ?? 'No courses scheduled for this semester.' }}
                            </div>
                        @endif
                    @else
                        <p class="text-center">Only UTM students can access this page.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2/dist/css/select2.min.css" rel="stylesheet" />
    <script>
        $(document).ready(function() {
            $('.utm-course-select').select2(); // Initialize Select2 on existing selects

            function addCourseField() {
                const tableBody = document.querySelector('#courseFields tbody');
                const row = document.createElement('tr');
                row.className = 'course-field';
                row.innerHTML = `
                    <td class="border px-4 py-2">
                        <select name="utm_course_id[]" class="utm-course-select">
                            @foreach ($allCourses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="border px-4 py-2">
                        <textarea name="target_course[]" rows="2" required class="w-full"></textarea>
                    </td>
                    <td class="border px-4 py-2">
                        <textarea name="target_course_description[]" rows="2" required class="w-full"></textarea>
                    </td>
                    <td class="border px-4 py-2 text-center">
                        <button type="button" onclick="removeCourseField(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Remove</button>
                    </td>
                `;
                tableBody.appendChild(row);
                $(row).find('.utm-course-select').select2(); // Initialize Select2 on the new select
            }

            window.addCourseField = addCourseField; // Make the function global for inline onclick
        });

        function removeCourseField(button) {
            const row = button.closest('tr');
            $(row).find('.utm-course-select').select2('destroy'); // Destroy Select2 before removing row
            row.remove();
        }
    </script>
</x-app-layout>
