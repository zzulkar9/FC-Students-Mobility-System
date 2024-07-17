<!-- Content for Tab C -->

<h3 class="text-2xl font-semibold text-gray-900 mb-4">Mobility Program Information</h3>

<div class="mb-6">
    <label for="link" class="block text-sm font-medium text-gray-700 mb-2">Enter Link:</label>
    <input type="url" id="link" name="link"
           class="form-input block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
           placeholder="Please enter the target university course website link"
           value="{{ $applicationForm ? $applicationForm->link : '' }}">
</div>

<!-- Additional Information Section -->
<div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 flex flex-col">
    <p><strong>Useful website to convert into ECTS credits if necessary:</strong></p>
    <a href="https://www.germangradecalculator.com/ects-calculator/"
        class="text-blue-500 underline" target="_blank">ECTS Calculator</a>
    <a href="https://www.uts.edu.au/study/international/study-abroad-and-exchange-uts/subjects-and-academic-information"
        class="text-blue-500 underline" target="_blank">UTS International Subjects and Academic Information</a>        
</div>

@if (Auth::user()->isUtmStudent())
    @if (!empty($courses))
        <div class="overflow-hidden overflow-x-auto min-w-full align-middle sm:rounded-lg shadow-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-100 text-blue-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider" style="width: 22%;">UTM Course</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider" style="width: 20%;">Target University Course</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider" style="width: 10%;">Target University Course Credit (ECTS)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider" style="width: 38%;">Course Description at Target University</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider" style="width: 10%;">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($courses as $course)
                        <tr class="course-field">
                            <td class="px-4 py-4 whitespace-nowrap relative">
                                <select name="utm_course_id[]"
                                    class="utm-course-select form-select w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 truncate-ellipsis">
                                    @foreach ($allCourses as $dropdownCourse)
                                        <option value="{{ $dropdownCourse->id }}"
                                            {{ $dropdownCourse->id == $course->id ? 'selected' : '' }}>
                                            {{ $dropdownCourse->course_code }} - {{ $dropdownCourse->course_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <textarea name="target_course[]" rows="2"
                                    class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none text-sm"
                                    placeholder="Enter target university course"></textarea>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <input name="target_course_credit[]"
                                    class="form-input w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    placeholder="Credit">
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <textarea name="target_course_description[]" rows="2"
                                    class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    placeholder="Enter course description at target university"></textarea>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <button type="button" onclick="removeCourseField(this)"
                                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-sm">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="button" onclick="addCourseField()"
            class="mt-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">Add More Subject</button>
    @else
        <div class="text-center p-4 text-gray-500">{{ $message ?? 'No courses scheduled for this semester.' }}</div>
    @endif
@else
    <p class="text-center text-gray-500">Only UTM students can access this page.</p>
@endif


<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addCourseField = function() {
            const tableBody = document.querySelector('table tbody');
            const row = document.createElement('tr');
            row.className = 'course-field';
            row.innerHTML = `
                <td class="px-4 py-4 whitespace-nowrap relative">
                    <select name="utm_course_id[]" class="utm-course-select form-select w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 truncate-ellipsis text-sm">
                        @foreach ($allCourses as $dropdownCourse)
                            <option value="{{ $dropdownCourse->id }}">{{ $dropdownCourse->course_code }} - {{ $dropdownCourse->course_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <textarea name="target_course[]" rows="1" class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none text-sm" placeholder="Enter target university course"></textarea>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <input type="number" name="target_course_credit[]" class="form-input w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Credit">
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <textarea name="target_course_description[]" rows="2" class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Enter course description at target university"></textarea>
                </td>
                <td class="px-4 py-4 whitespace-nowrap text-center">
                    <button type="button" onclick="removeCourseField(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-sm">Remove</button>
                </td>
            `;
            tableBody.appendChild(row);
            $(row).find('.utm-course-select').select2(); // Initialize Select2 on the new select
        };

        window.removeCourseField = function(button) {
            const row = button.closest('tr');
            $(row).find('.utm-course-select').select2('destroy'); // Destroy Select2 before removing the row
            row.remove();
        };
    });
</script>




{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addCourseField = function() {
            const tableBody = document.querySelector('table tbody');
            const row = document.createElement('tr');
            row.className = 'course-field';
            row.innerHTML = `
                <td class="px-4 py-4 whitespace-nowrap relative">
                    <select name="utm_course_id[]" class="utm-course-select form-select w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 truncate-ellipsis"
                            onmouseover="showTooltip(event)" onmouseout="hideTooltip(event)">
                        @foreach ($allCourses as $dropdownCourse)
                            <option value="{{ $dropdownCourse->id }}">{{ $dropdownCourse->course_code }} - {{ $dropdownCourse->course_name }}</option>
                        @endforeach
                    </select>
                    <div class="tooltip-text bg-black text-white p-2 rounded shadow-lg"></div>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <textarea name="target_course[]" rows="4" class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter target university course"></textarea>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <textarea name="target_course_credit[]" rows="1" class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter target university course credit"></textarea>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <textarea name="target_course_description[]" rows="4" class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter course description at target university"></textarea>
                </td>
                <td class="px-4 py-4 whitespace-nowrap text-center">
                    <button type="button" onclick="removeCourseField(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Remove</button>
                </td>
            `;
            tableBody.appendChild(row);
            $(row).find('.utm-course-select').select2();
        };

        window.removeCourseField = function(button) {
            const row = button.closest('tr');
            $(row).find('.utm-course-select').select2('destroy');
            row.remove();
        };

    });
</script> --}}
