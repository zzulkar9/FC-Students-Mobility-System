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
                            @foreach ($mergedCourses as $yearSemester => $courses)
                                <div class="semester-block" data-semester="{{ $yearSemester }}">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 py-2">{{ $yearSemester }}</h3>
                                    <table class="min-w-full mt-2 text-sm">
                                        <thead class="bg-cyan-100">
                                            <tr>
                                                <th class="border px-4 py-2">Course Code</th>
                                                <th class="border px-4 py-2">Course Name</th>
                                                <th class="border px-4 py-2">Credits</th>
                                                <th class="border px-4 py-2">Prerequisites</th>
                                            </tr>
                                        </thead>
                                        <tbody class="sortable" data-semester="{{ $yearSemester }}">
                                            @foreach ($courses as $plan)
                                                <tr class="hover:bg-gray-50" data-course-id="{{ $plan->course->id }}">
                                                    <td class="border px-4 py-2">{{ $plan->course->course_code }}</td>
                                                    <td class="border px-4 py-2">{{ $plan->course->course_name }}</td>
                                                    <td class="border px-4 py-2">{{ $plan->course->course_credit }}</td>
                                                    <td class="border px-4 py-2">{{ $plan->course->prerequisites }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const studyPlanForm = document.getElementById('studyPlanForm');
            const studyPlanContainer = document.getElementById('study-plan-container');
            const studyPlanDataInput = document.getElementById('studyPlanData');

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
    </script>
</x-app-layout>
