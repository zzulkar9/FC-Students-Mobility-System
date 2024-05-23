<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Study Plan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="rounded-md bg-green-50 p-4">
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
                        <div id="study-plan-container">
                            @foreach ($studyPlans as $yearSemester => $plans)
                                <div class="semester-block" data-semester="{{ $yearSemester }}">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 py-2">{{ $yearSemester }}</h3>
                                    <button type="button"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded mb-2"
                                        onclick="openAddSubjectModal('{{ $yearSemester }}')">Add Subject</button>
                                    <table class="min-w-full mt-2 text-sm">
                                        <thead class="bg-cyan-100">
                                            <tr>
                                                <th class="border px-4 py-2">Course Code</th>
                                                <th class="border px-4 py-2">Course Name</th>
                                                <th class="border px-4 py-2">Credits</th>
                                                <th class="border px-4 py-2">Prerequisites</th>
                                                <th class="border px-4 py-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="sortable">
                                            @foreach ($plans as $plan)
                                                <tr class="hover:bg-gray-50" data-course-id="{{ $plan->course_id }}" onclick="location.href='{{ route('courses.show', $plan->course_id) }}'" style="cursor:pointer;">
                                                    <td class="border px-4 py-2">{{ $plan->course->course_code }}</td>
                                                    <td class="border px-4 py-2">{{ $plan->course->course_name }}</td>
                                                    <td class="border px-4 py-2">{{ $plan->course->course_credit }}</td>
                                                    <td class="border px-4 py-2">{{ $plan->course->prerequisites ?? 'None' }}</td>
                                                    <td class="border px-4 py-2">
                                                        <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded" onclick="event.stopPropagation(); removeSubject(this)">Remove</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-gray-100">
                                                <td colspan="2" class="text-right px-4 py-2 font-medium">Total Credits:</td>
                                                <td class="px-4 py-2 font-medium">{{ $plans->sum('course.course_credit') }}</td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="mt-4">
                                        <label for="remark_{{ $yearSemester }}" class="block text-sm font-medium text-gray-700">Remark</label>
                                        <textarea id="remark_{{ $yearSemester }}" name="remarks[{{ $yearSemester }}]" rows="3" class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm" disabled>{{ $plans->first()->remark }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="study_plan_data" id="studyPlanData">
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Study Plan
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
                        <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                    @endforeach
                @endforeach
            </select>
            <div class="flex justify-end mt-4">
                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2" onclick="closeAddSubjectModal()">Cancel</button>
                <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="addSubject()">Add</button>
            </div>
        </div>
    </div>

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
                studyPlanDataInput.value = JSON.stringify(studyPlanData);
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
            newRow.classList.add('hover:bg-gray-50');
            newRow.innerHTML = `
                <td class="border px-4 py-2">${selectedCourse.course_code}</td>
                <td class="border px-4 py-2">${selectedCourse.course_name}</td>
                <td class="border px-4 py-2">${selectedCourse.course_credit}</td>
                <td class="border px-4 py-2">${selectedCourse.prerequisites ?? 'None'}</td>
                <td class="border px-4 py-2">
                    <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded" onclick="removeSubject(this)">Remove</button>
                </td>
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
            row.parentNode.removeChild(row);
            updateStudyPlanData();
        }
    </script>
</x-app-layout>
