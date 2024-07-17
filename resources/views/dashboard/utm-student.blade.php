<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            <!-- Student Info -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                <div class="text-gray-900">
                    <h3 class="text-xl font-semibold mb-4">Student Information</h3>
                    <p class="mt-1 text-sm"><span class="font-bold">Name:</span> {{ Auth::user()->name }}</p>
                    <p class="mt-1 text-sm"><span class="font-bold">Email:</span> {{ Auth::user()->email }}</p>
                    <p class="mt-1 text-sm"><span class="font-bold">Matric Number:</span>
                        {{ Auth::user()->matric_number }}</p>
                    <p class="mt-1 text-sm"><span class="font-bold">Upcoming Semester:</span>
                        {{ Auth::user()->getCurrentSemester() }}</p>
                    <p class="mt-1 text-sm"><span class="font-bold">Intake:</span> {{ Auth::user()->intake_period }}</p>
                </div>
            </div>

            <!-- Application Form Status and Comments -->
            @if (isset($applicationForm))
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300 col-span-1 md:col-span-2">
                    <div class="text-gray-900">
                        <h3 class="text-lg leading-6 font-medium mb-4">Application Form Status</h3>
                        <table class="min-w-full w-full mt-2 text-sm mb-4">
                            <thead class="bg-cyan-100">
                                <tr>
                                    <th class="px-4 py-2">Form ID</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-gray-100">
                                    <td class="border px-4 py-2 text-center">{{ $applicationForm->id }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        {{ $applicationForm->approval_status ? 'Approved' : 'Pending' }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <a href="{{ route('application-form.show', $applicationForm->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900">Review</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Incomplete Tabs Alert -->
                        @if (isset($incompleteTabs))
                            <div class="bg-yellow-50 p-4 rounded-md mt-4">
                                <div class="text-yellow-800">
                                    <p class="text-sm">
                                        The following tabs are not fully filled yet:
                                        {{ implode(', ', $incompleteTabs) }}. Please complete them.
                                    </p>
                                </div>
                            </div>
                        @endif

                        <!-- Comments Section -->
                        <h3 class="text-lg leading-6 font-medium mt-4">Last Comments</h3>
                        <div class="bg-yellow-100 p-4 rounded-lg mt-4">
                            @if ($latestComment)
                                <div class="mb-4">
                                    <p class="text-sm"><span class="font-bold">Commenter:</span>
                                        {{ $latestComment->user->name }}</p>
                                    <p class="text-sm"><span class="font-bold">Date:</span>
                                        {{ $latestComment->created_at->format('d-m-Y H:i') }}</p>
                                    <p class="mt-2">{{ $latestComment->comment }}</p>
                                </div>
                            @else
                                <p class="text-center text-sm">No comments from academic advisor.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Courses by Semester Chart -->
            <div hidden>
                @if (isset($allCourses))
                    <div
                        class="bg-white overflow-hidden shadow-lg rounded-lg p-6 col-span-1 md:col-span-3 border border-gray-300">
                        <div class="text-gray-900">
                            <h3 class="text-lg leading-6 font-medium">Courses by Semester</h3>
                            <canvas id="coursesChart"></canvas>
                        </div>
                        <div class="mt-6">
                            @foreach ($allCourses as $yearSemester => $courses)
                                <details class="mt-2 group">
                                    <summary class="cursor-pointer text-gray-700 font-medium py-2 hover:bg-gray-100">
                                        {{ $yearSemester }}
                                    </summary>
                                    <table class="min-w-full mt-2 text-sm">
                                        <thead>
                                            <tr class="bg-cyan-100">
                                                <th class="border px-4 py-2">Course Code</th>
                                                <th class="border px-4 py-2">Course Name</th>
                                                <th class="border px-4 py-2">Credits</th>
                                                <th class="border px-4 py-2">Prerequisites</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($courses as $course)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="border px-4 py-2">{{ $course->course_code }}</td>
                                                    <td class="border px-4 py-2">
                                                        {{ $course->course_name }}
                                                        <div><a href="{{ route('courses.show', $course->id) }}"
                                                                class="text-blue-500 hover:text-blue-700 text-xs">View</a>
                                                        </div>
                                                    </td>
                                                    <td class="border px-4 py-2">{{ $course->course_credit }}</td>
                                                    <td class="border px-4 py-2">{{ $course->prerequisites ?? 'None' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </details>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Study Plans Chart -->
            @if (isset($studyPlans))
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-lg p-6 col-span-1 md:col-span-3 border border-gray-300">
                    <div class="text-gray-900">
                        <h3 class="text-lg leading-6 font-medium">Study Plans</h3>
                        <canvas id="studyPlansChart"></canvas>
                    </div>
                    <div class="mt-6">
                        @foreach ($studyPlans as $yearSemester => $plans)
                            <details class="mt-2 group">
                                <summary class="cursor-pointer text-gray-700 font-medium py-2 hover:bg-gray-100">
                                    {{ $yearSemester }}
                                </summary>
                                <table class="min-w-full mt-2 text-sm">
                                    <thead>
                                        <tr class="bg-cyan-100">
                                            <th class="border px-4 py-2">Course Code</th>
                                            <th class="border px-4 py-2">Course Name</th>
                                            <th class="border px-4 py-2">Credits</th>
                                            <th class="border px-4 py-2">Prerequisites</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($plans as $plan)
                                            <tr class="hover:bg-gray-50">
                                                <td class="border px-4 py-2">{{ $plan->course->course_code }}</td>
                                                <td class="border px-4 py-2">
                                                    {{ $plan->course->course_name }}
                                                    <div><a href="{{ route('courses.show', $plan->course_id) }}"
                                                            class="text-blue-500 hover:text-blue-700 text-xs">View</a>
                                                    </div>
                                                </td>
                                                <td class="border px-4 py-2">{{ $plan->course->course_credit }}</td>
                                                <td class="border px-4 py-2">
                                                    {{ $plan->course->prerequisites ?? 'None' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </details>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const allCourses = @json($allCourses);
            const studyPlans = @json($studyPlans);

            const ctxCourses = document.getElementById('coursesChart').getContext('2d');
            const coursesChart = new Chart(ctxCourses, {
                type: 'bar',
                data: {
                    labels: Object.keys(allCourses || {}),
                    datasets: [{
                        label: 'Courses by Semester',
                        data: Object.values(allCourses || {}).map(courses => courses.length),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const ctxStudyPlans = document.getElementById('studyPlansChart').getContext('2d');
            const studyPlansChart = new Chart(ctxStudyPlans, {
                type: 'line',
                data: {
                    labels: Object.keys(studyPlans || {}),
                    datasets: [{
                        label: 'Total Subjects by Semester',
                        data: Object.values(studyPlans || {}).map(plans => plans.length),
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
