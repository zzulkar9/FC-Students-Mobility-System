<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Study Plan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="rounded-md bg-green-50 p-4 mb-4">
                            <div class="flex">
                                <div class="ml-3">
                                    <p class="text-sm text-green-800">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('study-plans.update') }}" id="studyPlanForm">
                        @csrf
                        <!-- Orphan Subjects Section -->
                        <div class="mt-8">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 py-2">Subjects Not in Any Semester
                            </h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full mt-2 text-xs">
                                    <thead class="bg-cyan-100">
                                        <tr>
                                            <th class="border px-2 py-1">Course Code</th>
                                            <th class="border px-2 py-1">Course Name</th>
                                            <th class="border px-2 py-1">Credits</th>
                                            <th class="border px-2 py-1">Pre-requisites</th>
                                        </tr>
                                    </thead>
                                    <tbody class="sortable" data-semester="None">
                                        @foreach ($orphanSubjects as $orphan)
                                            <tr class="hover:bg-gray-50" data-course-id="{{ $orphan->course_id }}">
                                                <td class="border px-2 py-1 text-sm">{{ $orphan->course->course_code }}
                                                </td>
                                                <td class="border px-2 py-1 text-sm">
                                                    {{ $orphan->course->course_name }}
                                                    <div class="text-xs mt-1 space-x-1">
                                                        <a href="{{ route('courses.show', $orphan->course_id) }}"
                                                            class="text-blue-500 hover:text-blue-700">View</a>
                                                        <a> | </a>
                                                        <a href="#" class="text-red-500 hover:text-red-700"
                                                            onclick="event.stopPropagation(); removeSubject(this)">Remove</a>
                                                    </div>
                                                </td>
                                                <td class="border px-2 py-1 text-sm">
                                                    {{ $orphan->course->course_credit }}</td>
                                                <td class="border px-2 py-1 text-sm">
                                                    {{ $orphan->course->prerequisites ?? 'None' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="study-plan-container" class="flex space-x-8 mt-8">
                            <div class="w-1/2">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 py-2">Past Semesters</h3>
                                @foreach ($studyPlans as $yearSemester => $plans)
                                    @if ($isPastSemester($yearSemester))
                                        <details class="semester-block mb-4" data-semester="{{ $yearSemester }}">
                                            <summary
                                                class="text-sm leading-5 font-medium text-gray-900 py-2 cursor-pointer">
                                                {{ $yearSemester }}
                                            </summary>
                                            <div class="overflow-x-auto">
                                                <table class="min-w-full mt-2 text-xs">
                                                    <thead class="bg-cyan-100">
                                                        <tr>
                                                            <th class="border px-2 py-1">Course Code</th>
                                                            <th class="border px-2 py-1">Course Name</th>
                                                            <th class="border px-2 py-1">Credits</th>
                                                            <th class="border px-2 py-1">Pre-Requisites</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="sortable">
                                                        @foreach ($plans as $plan)
                                                            <tr class="hover:bg-gray-50"
                                                                data-course-id="{{ $plan->course_id }}">
                                                                <td class="border px-2 py-1 text-sm">
                                                                    {{ $plan->course->course_code }}</td>
                                                                <td class="border px-2 py-1 text-sm">
                                                                    {{ $plan->course->course_name }}
                                                                    <div class="text-xs mt-1 space-x-1">
                                                                        <a href="{{ route('courses.show', $plan->course_id) }}"
                                                                            class="text-blue-500 hover:text-blue-700">View</a>
                                                                        <a> | </a>
                                                                        <a href="#"
                                                                            class="text-red-500 hover:text-red-700"
                                                                            onclick="event.stopPropagation(); removeSubject(this)">Remove</a>
                                                                    </div>
                                                                </td>
                                                                <td class="border px-2 py-1 text-sm">
                                                                    {{ $plan->course->course_credit }}</td>
                                                                <td class="border px-2 py-1 text-sm">
                                                                    {{ $plan->course->prerequisites ?? 'None' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="bg-gray-100">
                                                            <td colspan="2"
                                                                class="text-right px-2 py-1 font-medium text-sm">Total
                                                                Credits:</td>
                                                            <td class="px-2 py-1 font-medium text-sm">
                                                                {{ $plans->sum('course.course_credit') }}</td>
                                                            <td colspan="1"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </details>
                                    @endif
                                @endforeach
                            </div>
                            <div class="w-1/2">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 py-2">Upcoming Semesters</h3>
                                @foreach ($studyPlans as $yearSemester => $plans)
                                    @if (!$isPastSemester($yearSemester))
                                        <details class="semester-block mb-4" data-semester="{{ $yearSemester }}">
                                            <summary
                                                class="text-sm leading-5 font-medium text-gray-900 py-2 cursor-pointer">
                                                {{ $yearSemester }}
                                            </summary>
                                            <button type="button"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded mb-2 text-xs"
                                                onclick="openAddSubjectModal('{{ $yearSemester }}')">Add
                                                Subject</button>
                                            <div class="overflow-x-auto">
                                                <table class="min-w-full mt-2 text-xs">
                                                    <thead class="bg-cyan-100">
                                                        <tr>
                                                            <th class="border px-2 py-1">Course Code</th>
                                                            <th class="border px-2 py-1">Course Name</th>
                                                            <th class="border px-2 py-1">Credits</th>
                                                            <th class="border px-2 py-1">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="sortable">
                                                        @foreach ($plans as $plan)
                                                            <tr class="hover:bg-gray-50"
                                                                data-course-id="{{ $plan->course_id }}">
                                                                <td class="border px-2 py-1 text-sm">
                                                                    {{ $plan->course->course_code }}</td>
                                                                <td class="border px-2 py-1 text-sm">
                                                                    {{ $plan->course->course_name }}
                                                                    <div class="text-xs mt-1 space-x-1">
                                                                        <a href="{{ route('courses.show', $plan->course_id) }}"
                                                                            class="text-blue-500 hover:text-blue-700">View</a>
                                                                        <a> | </a>
                                                                        <a href="#"
                                                                            class="text-red-500 hover:text-red-700"
                                                                            onclick="event.stopPropagation(); removeSubject(this)">Remove</a>
                                                                    </div>
                                                                </td>
                                                                <td class="border px-2 py-1 text-sm">
                                                                    {{ $plan->course->course_credit }}</td>
                                                                <td class="border px-2 py-1 text-sm">
                                                                    {{ $plan->course->prerequisites ?? 'None' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="bg-gray-100">
                                                            <td colspan="2"
                                                                class="text-right px-2 py-1 font-medium text-sm">Total
                                                                Credits:</td>
                                                            <td class="px-2 py-1 font-medium text-sm">
                                                                {{ $plans->sum('course.course_credit') }}</td>
                                                            <td colspan="1"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="mt-4">
                                                <label for="remark_{{ $yearSemester }}"
                                                    class="block text-xs font-medium text-gray-700">Remark</label>
                                                <textarea id="remark_{{ $yearSemester }}" name="remarks[{{ $yearSemester }}]" rows="2"
                                                    class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm" disabled>{{ $plans->first()->remark }}</textarea>
                                            </div>
                                        </details>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="study_plan_data" id="studyPlanData">
                        <div class="flex items-center justify-center mt-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save Study Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Subject Modal -->
    <div id="addSubjectModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full p-6">
            <h2 class="text-xl font-semibold mb-4">Add Subject</h2>
            <input type="hidden" id="selectedSemester">
            <select id="courseSelect" class="w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Select a Course</option>
                @foreach ($allCourses as $courses)
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}
                        </option>
                    @endforeach
                @endforeach
            </select>
            <div class="flex justify-end mt-4">
                <button type="button"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2"
                    onclick="closeAddSubjectModal()">Cancel</button>
                <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    onclick="addSubject()">Add</button>
            </div>
        </div>
    </div>

    <style>
        .draggable {
            cursor: grab;
        }

        .draggable:active {
            cursor: grabbing;
        }
    </style>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const studyPlanForm = document.getElementById('studyPlanForm');
            const studyPlanContainer = document.getElementById('study-plan-container');
            const studyPlanDataInput = document.getElementById('studyPlanData');

            // Initialize Select2 on courseSelect
            $('#courseSelect').select2({
                width: '100%',
                placeholder: 'Select a course',
                allowClear: true
            });

            // Initialize Sortable.js on each semester block
            const semesterBlocks = document.querySelectorAll('.sortable');
            semesterBlocks.forEach(block => {
                new Sortable(block, {
                    group: 'courses',
                    animation: 150,
                    onEnd: updateStudyPlanData
                });
            });

            // Add draggable class to existing rows
            document.querySelectorAll('.sortable tr').forEach(row => {
                row.classList.add('draggable');
            });

            // Function to update hidden input with current study plan data
            function updateStudyPlanData() {
                const studyPlanData = [];
                document.querySelectorAll('.semester-block').forEach(block => {
                    const semester = block.getAttribute('data-semester');
                    block.querySelectorAll('tr[data-course-id]').forEach(row => {
                        studyPlanData.push({
                            course_id: row.getAttribute('data-course-id'),
                            year_semester: semester
                        });
                    });
                });

                document.querySelectorAll('tbody[data-semester="None"] tr[data-course-id]').forEach(row => {
                    studyPlanData.push({
                        course_id: row.getAttribute('data-course-id'),
                        year_semester: 'None'
                    });
                });

                document.getElementById('studyPlanData').value = JSON.stringify(studyPlanData);
            }

            // Update study plan data on form submission
            studyPlanForm.addEventListener('submit', updateStudyPlanData);
        });

        function openAddSubjectModal(semester) {
            document.getElementById('selectedSemester').value = semester;
            document.getElementById('addSubjectModal').classList.remove('hidden');
        }

        function closeAddSubjectModal() {
            document.getElementById('addSubjectModal').classList.add('hidden');
        }

        function addSubject() {
            const semester = document.getElementById('selectedSemester').value;
            const courseSelect = $('#courseSelect');
            const courseId = courseSelect.val();
            const courseText = courseSelect.find('option:selected').text();

            if (!courseId) {
                alert('Please select a course.');
                return;
            }

            // Fetch course details
            const allCourses = @json($allCourses);
            console.log('allCourses:', allCourses); // Log the structure of allCourses

            // Determine the structure and flatten accordingly
            let flattenedCourses = [];
            if (Array.isArray(allCourses)) {
                if (Array.isArray(allCourses[0])) {
                    // Array of arrays
                    flattenedCourses = allCourses.reduce((acc, curr) => acc.concat(curr), []);
                } else {
                    // Single array of objects
                    flattenedCourses = allCourses;
                }
            } else if (typeof allCourses === 'object' && allCourses !== null) {
                // Object with arrays as values
                flattenedCourses = Object.values(allCourses).reduce((acc, curr) => acc.concat(curr), []);
            } else {
                console.error('Unexpected allCourses structure:', allCourses);
                return;
            }

            const selectedCourse = flattenedCourses.find(course => course.id == courseId);

            if (!selectedCourse) {
                console.error('Selected course not found:', courseId);
                return;
            }

            // Create a new row for the selected course
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-course-id', courseId);
            newRow.classList.add('hover:bg-gray-50', 'draggable');
            newRow.innerHTML = `
        <td class="border px-2 py-1 text-sm">${selectedCourse.course_code}</td>
        <td class="border px-2 py-1 text-sm">
            ${selectedCourse.course_name}
            <div class="text-xs mt-1 space-x-1">
                <a href="{{ route('courses.show', $plan->course_id) }}"
                    class="text-blue-500 hover:text-blue-700">View</a>
                <a> | </a>
                <a href="#" class="text-red-500 hover:text-red-700" onclick="event.stopPropagation(); removeSubject(this)">Remove</a>
            </div>
        </td>
        <td class="border px-2 py-1 text-sm">${selectedCourse.course_credit}</td>
        <td class="border px-2 py-1 text-sm">${selectedCourse.prerequisites ?? 'None'}</td>
    `;

            // Append the new row to the corresponding semester block
            document.querySelector(`.semester-block[data-semester="${semester}"] .sortable`).appendChild(newRow);

            // Close the modal
            closeAddSubjectModal();

            // Update the study plan data
            updateStudyPlanData();
        }

        function removeSubject(button) {
            const row = button.closest('tr');
            const orphanTable = document.querySelector('tbody[data-semester="None"]');

            // Move the row to the orphan subjects table
            orphanTable.appendChild(row);

            updateStudyPlanData();
        }
    </script>
</x-app-layout>
