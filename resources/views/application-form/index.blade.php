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
                        <table class="w-full text-sm mt-4">
                            <tbody>
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 font-medium bg-gray-200 w-60">Name:</td>
                                    <td class="px-4 py-2">{{ Auth::user()->name }}</td>
                                </tr>
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 font-medium bg-gray-200">Matric Number:</td>
                                    <td class="px-4 py-2">{{ Auth::user()->matric_number }}</td>
                                </tr>
                                @if (Auth::user()->isUtmStudent())
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Upcoming Semester:</td>
                                        <td class="px-4 py-2">{{ Auth::user()->getCurrentSemester() }}</td>
                                    </tr>
                                @endif
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 font-medium bg-gray-200">Intake:</td>
                                    <td class="px-4 py-2">{{ Auth::user()->intake_period }}</td>
                                </tr>
                                @if (isset($applicationForm) && $applicationForm->link)
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Link:</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ $applicationForm->link }}" target="_blank" class="text-blue-500 hover:text-blue-700">{{ $applicationForm->link }}</a>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    
                    @if (Auth::user()->isUtmStudent())
                        @if (!empty($courses))
                            <form method="POST" action="{{ route('application-form.submit') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="link" class="block text-sm font-medium text-gray-700">Enter Link:</label>
                                    <input type="url" id="link" name="link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter URL here">
                                </div>
                                <div class="overflow-hidden overflow-x-auto min-w-full align-middle">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-200">
                                            <tr>
                                                <th class="px-4 py-2 text-left" style="width: 25%;">UTM Course</th>
                                                <th class="px-4 py-2 text-left" style="width: 25%;">Target University Course</th>
                                                <th class="px-4 py-2 text-left" style="width: 45%;">Course Description at Target University</th>
                                                <th class="px-4 py-2 text-left" style="width: 5%;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($courses as $course)
                                                <tr class="course-field">
                                                    <td class="border px-4 py-2">
                                                        <select name="utm_course_id[]" class="utm-course-select w-full">
                                                            @foreach ($allCourses as $dropdownCourse)
                                                                <option value="{{ $dropdownCourse->id }}" {{ $dropdownCourse->id == $course->id ? 'selected' : '' }}>
                                                                    {{ $dropdownCourse->course_code }} - {{ $dropdownCourse->course_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        <textarea name="target_course[]" rows="4" class="w-full"></textarea>
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        <textarea name="target_course_description[]" rows="4" class="w-full"></textarea>
                                                    </td>
                                                    <td class="border px-4 py-2 text-center">
                                                        <button type="button" onclick="removeCourseField(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Remove</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" onclick="addCourseField()" class="mt-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add More Subject</button>
                                <div class="flex items-center justify-center mt-4 space-x-4">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                                    <button type="submit" name="action" value="save_draft" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Save Draft</button>
                                </div>
                            </form>
                        @else
                            <div class="text-center p-4">{{ $message ?? 'No courses scheduled for this semester.' }}</div>
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
                        <select name="utm_course_id[]" class="utm-course-select w-full">
                            @foreach ($allCourses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="border px-4 py-2">
                        <textarea name="target_course[]" rows="2" class="w-full"></textarea>
                    </td>
                    <td class="border px-4 py-2">
                        <textarea name="target_course_description[]" rows="4" class="w-full"></textarea>
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
