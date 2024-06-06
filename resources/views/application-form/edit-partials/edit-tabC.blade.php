<!-- Content for Edit Tab C -->
<div>
    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Mobility Program Information</h3>

    @if (Auth::user()->isUtmStudent())
        @if (!empty($applicationForm->subjects))
            <div class="mb-6">
                <label for="link" class="block text-sm font-medium text-gray-700 mb-2">Enter Link:</label>
                <input type="url" id="link" name="link"
                    class="form-input block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Please enter the target university course website link"
                    value="{{ $applicationForm->link }}">
            </div>
            <!-- Additional Information Section -->
            <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 flex flex-col">
                <p><strong>Useful website to convert into ECTS credits if necessary:</strong></p>
                <a href="https://www.germangradecalculator.com/ects-calculator/" class="text-blue-500 underline"
                    target="_blank">ECTS Calculator</a>
                <a href="https://www.uts.edu.au/study/international/study-abroad-and-exchange-uts/subjects-and-academic-information"
                    class="text-blue-500 underline" target="_blank">UTS International Subjects and Academic
                    Information</a>
            </div>
            <div class="overflow-hidden overflow-x-auto min-w-full align-middle sm:rounded-lg shadow-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-100 text-blue-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
                                style="width: 20%;">UTM Course</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
                                style="width: 15%;">Target University Course</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
                                style="width: 10%;">Target University Course Credit (ECTS)</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
                                style="width: 30%;">Course Description at Target University</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
                                style="width: 20%;">Notes</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
                                style="width: 5%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($applicationForm->subjects as $subject)
                            <tr class="course-field">
                                <td class="px-4 py-4 whitespace-nowrap relative">
                                    <select name="utm_course_id[]"
                                        class="utm-course-select form-select w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}"
                                                {{ $subject->utm_course_id == $course->id ? 'selected' : '' }}>
                                                {{ $course->course_code }} - {{ $course->course_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <textarea name="target_course[]" rows="2"
                                        class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none text-sm"
                                        placeholder="Enter target university course">{{ $subject->target_course }}</textarea>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="target_course_credit[]"
                                        class="form-input w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="Credit" value="{{ $subject->target_course_credit }}">
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <textarea name="target_course_description[]" rows="2"
                                        class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="Enter course description at target university">{{ $subject->target_course_description }}</textarea>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <textarea name="target_course_notes[]" rows="2"
                                        class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="Enter notes" readonly>{{ $subject->notes }}</textarea>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <button type="button" onclick="removeSubject(this)"
                                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-sm">Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="button" onclick="addSubject()"
                class="mt-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">Add
                Subject</button>
        @else
            <p class="text-center text-gray-500">No subjects found for this application form.</p>
        @endif
    @else
        <p class="text-center text-gray-500">Only UTM students can access this page.</p>
    @endif

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addSubject = function() {
            const tableBody = document.querySelector('table tbody');
            const row = document.createElement('tr');
            row.className = 'course-field';
            row.innerHTML = `
                <td class="px-4 py-4 whitespace-nowrap relative">
                    <select name="utm_course_id[]" class="utm-course-select form-select w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
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
                <td class="px-4 py-4 whitespace-nowrap">
                    <textarea name="target_course_notes[]" rows="2" class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Enter notes" readonly></textarea>
                </td>
                <td class="px-4 py-4 whitespace-nowrap text-center">
                    <button type="button" onclick="removeSubject(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-sm">Remove</button>
                </td>
            `;
            tableBody.appendChild(row);
            $(row).find('.utm-course-select').select2(); // Initialize Select2 on the new select
        };

        window.removeSubject = function(button) {
            const row = button.closest('tr');
            $(row).find('.utm-course-select').select2('destroy'); // Destroy Select2 before removing the row
            row.remove();
        };
    });
</script>


<!-- Scripts for adding/removing subjects -->
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        $('.utm-course-select').select2({
            width: '100%',
            placeholder: "Select a course",
            allowClear: true
        });

        window.addSubject = function() {
            const tableBody = document.querySelector('table tbody');
            const row = document.createElement('tr');
            row.className = 'course-field';
            row.innerHTML = `
                <td class="px-4 py-4 whitespace-nowrap">
                    <select name="utm_course_id[]" class="utm-course-select form-select w-full rounded-md border-gray-300 shadow-sm">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <textarea name="target_course[]" rows="4" class="form-textarea w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter target university course"></textarea>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <textarea name="target_course_credit[]" rows="4" class="form-textarea w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter target university course credit"></textarea>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <textarea name="target_course_description[]" rows="4" class="form-textarea w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter course description at target university"></textarea>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <textarea name="target_course_notes[]" rows="4" class="form-textarea w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter notes"></textarea>
                </td>
                <td class="px-4 py-4 whitespace-nowrap text-center">
                    <button type="button" onclick="removeSubject(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Remove</button>
                </td>
            `;
            tableBody.appendChild(row);
            $(row).find('.utm-course-select').select2({
                width: '100%',
                placeholder: "Select a course",
                allowClear: true
            });
        };

        window.removeSubject = function(button) {
            const row = button.closest('tr');
            $(row).find('.utm-course-select').select2('destroy');
            row.remove();
        };
    });
</script> --}}
