<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Study Plan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg overflow-hidden">
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-semibold text-gray-900 py-2">Study Plan for {{ $student->name }}</h3>
                    <form method="POST" action="{{ route('study-plans.save-remarks', $student->id) }}" class="mt-6">
                        @csrf
                        <!-- Orphan Subjects Section -->
                        <div class="mt-8">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 py-2">Subjects to be taken/swap/remove
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
                                            <tr class="hover:bg-gray-50"
                                                data-course-id="{{ $orphan->course_id ?? $orphan->target_university_course_id }}"
                                                data-target-university-course-id="{{ $orphan->target_university_course_id ?? '' }}">
                                                <td class="border px-2 py-1 text-sm">
                                                    {{ $orphan->target_university_course_id ? 'Mobility Course' : $orphan->course->course_code }}
                                                </td>
                                                <td class="border px-2 py-1 text-sm">
                                                    {{ $orphan->target_university_course_id ? $orphan->targetCourse->course_name : $orphan->course->course_name }}
                                                    <div class="text-xs mt-1 space-x-1">
                                                        <a href="{{ route('courses.show', $orphan->course_id ?? $orphan->target_university_course_id) }}"
                                                            class="text-blue-500 hover:text-blue-700">View</a>
                                                    </div>
                                                </td>
                                                <td class="border px-2 py-1 text-sm">
                                                    {{ $orphan->target_university_course_id ? $orphan->course->course_credit : $orphan->course->course_credit }}
                                                </td>
                                                <td class="border px-2 py-1 text-sm">
                                                    {{ $orphan->course->prerequisites ?? 'None' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Past Semesters -->
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
                                                    <tbody>
                                                        @foreach ($plans as $plan)
                                                            <tr class="hover:bg-gray-50"
                                                                data-course-id="{{ $plan->course_id ?? $plan->target_university_course_id }}"
                                                                data-target-university-course-id="{{ $plan->target_university_course_id ?? '' }}">
                                                                <td class="border px-2 py-1 text-sm">
                                                                    {{ $plan->target_university_course_id ? 'Mobility Course' : $plan->course->course_code }}
                                                                </td>
                                                                <td class="border px-2 py-1 text-sm">
                                                                    {{ $plan->target_university_course_id ? $plan->targetCourse->course_name : $plan->course->course_name }}
                                                                    <div class="text-xs mt-1 space-x-1">
                                                                        <a href="{{ route('courses.show', $plan->course_id ?? $plan->target_university_course_id) }}"
                                                                            class="text-blue-500 hover:text-blue-700">View</a>
                                                                    </div>
                                                                </td>
                                                                <td class="border px-2 py-1 text-sm">
                                                                    {{ $plan->target_university_course_id ? $plan->course->course_credit : $plan->course->course_credit }}
                                                                </td>
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
                                                        <!-- Warning message placeholder -->
                                                        <tr>
                                                            <td colspan="4" class="text-sm text-red-500 font-medium">
                                                                <span class="credit-warning" data-semester="{{ $yearSemester }}"></span>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </details>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Upcoming Semesters -->
                            <div class="w-1/2">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 py-2">Upcoming Semesters</h3>
                                @foreach ($studyPlans as $yearSemester => $plans)
                                    @if (!$isPastSemester($yearSemester))
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
                                                    <tbody>
                                                        @foreach ($plans as $plan)
                                                            <tr class="hover:bg-gray-50"
                                                                data-course-id="{{ $plan->course_id ?? $plan->target_university_course_id }}"
                                                                data-target-university-course-id="{{ $plan->target_university_course_id ?? '' }}">
                                                                <td class="border px-2 py-1 text-sm">
                                                                    {{ $plan->target_university_course_id ? 'Mobility Course' : $plan->course->course_code }}
                                                                </td>
                                                                <td class="border px-2 py-1 text-sm">
                                                                    {{ $plan->target_university_course_id ? $plan->targetCourse->course_name : $plan->course->course_name }}
                                                                    <div class="text-xs mt-1 space-x-1">
                                                                        <a href="{{ route('courses.show', $plan->course_id ?? $plan->target_university_course_id) }}"
                                                                            class="text-blue-500 hover:text-blue-700">View</a>
                                                                    </div>
                                                                </td>
                                                                <td class="border px-2 py-1 text-sm">
                                                                    {{ $plan->target_university_course_id ? $plan->course->course_credit : $plan->course->course_credit }}
                                                                </td>
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
                                                        <!-- Warning message placeholder -->
                                                        <tr>
                                                            <td colspan="4" class="text-sm text-red-500 font-medium">
                                                                <span class="credit-warning" data-semester="{{ $yearSemester }}"></span>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="mt-4">
                                                <label for="remark_{{ $yearSemester }}"
                                                    class="block text-xs font-medium text-gray-700">Remark</label>
                                                <textarea id="remark_{{ $yearSemester }}" name="remarks[{{ $yearSemester }}]" rows="2"
                                                    class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $plans->first()->remark }}</textarea>
                                            </div>
                                        </details>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="flex items-center justify-center mt-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save Remarks
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const maxCredits = 18; // Example maximum credits
            const minCredits = 12; // Example minimum credits
        
            document.querySelectorAll('.semester-block').forEach(block => {
                const semester = block.getAttribute('data-semester');
                const totalCredits = Array.from(block.querySelectorAll('tbody tr')).reduce((sum, row) => {
                    const credits = parseInt(row.querySelector('td:nth-child(3)').textContent);
                    return sum + (isNaN(credits) ? 0 : credits);
                }, 0);
        
                const warningElement = block.querySelector(`.credit-warning[data-semester="${semester}"]`);
                if (totalCredits > maxCredits) {
                    warningElement.textContent = `Warning: Exceeds maximum credits (${totalCredits}/${maxCredits})`;
                } else if (totalCredits < minCredits) {
                    warningElement.textContent = `Warning: Below minimum credits (${totalCredits}/${minCredits})`;
                } else {
                    warningElement.textContent = '';
                }
            });
        });
        </script>
        
</x-app-layout>
