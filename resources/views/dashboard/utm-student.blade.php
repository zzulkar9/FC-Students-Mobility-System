<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="flex mx-auto sm:px-6 lg:px-8">
            <!-- Left Navigation for tabs -->
            <div class="w-64 flex flex-col mr-8">
                <!-- Navigation Tabs -->
                <ul class="flex flex-col bg-white rounded-lg border shadow-sm">
                    <li class="border-b">
                        <a href="#studentInfo" class="student-dashboard-tab block p-4 hover:bg-gray-100">Student Information</a>
                    </li>
                    <li class="border-b">
                        <a href="#applicationForm" class="student-dashboard-tab block p-4 hover:bg-gray-100">Application Form</a>
                    </li>
                    <li class="border-b">
                        <a href="#coursesBySemester" class="student-dashboard-tab block p-4 hover:bg-gray-100">Courses by Semester</a>
                    </li>
                    <li>
                        <a href="#studyPlans" class="student-dashboard-tab block p-4 hover:bg-gray-100">Study Plans</a>
                    </li>
                </ul>
            </div>

            <!-- Right Content Area -->
            <div class="flex-1 bg-white overflow-hidden shadow-sm sm:rounded-lg border-b border-gray-200 p-6">
                <div id="studentInfo" class="tab-content active">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 py-2">Student Information</h3>
                    <table class="w-full text-sm px-4 py-2">
                        <tbody>
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 font-medium bg-gray-200 w-60">Name:</td>
                                <td class="px-4 py-2">{{ Auth::user()->name }}</td>
                            </tr>
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 font-medium bg-gray-200">Matric Number:</td>
                                <td class="px-4 py-2">{{ Auth::user()->matric_number }}</td>
                            </tr>
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 font-medium bg-gray-200">Upcoming Semester:</td>
                                <td class="px-4 py-2">{{ Auth::user()->getCurrentSemester() }}</td>
                            </tr>
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 font-medium bg-gray-200">Intake:</td>
                                <td class="px-4 py-2">{{ Auth::user()->intake_period }}</td>
                            </tr>
                            @if (isset($applicationForm) && $applicationForm->link)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 font-medium bg-gray-200">Link:</td>
                                    <td class="px-4 py-2"><a href="{{ $applicationForm->link }}" target="_blank"
                                            class="text-blue-500 hover:text-blue-700">{{ $applicationForm->link }}</a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div id="applicationForm" class="tab-content hidden">
                    <div class="flex justify-between items-center">
                        <h4 class="text-lg leading-6 font-medium text-gray-900">Application Form:</h4>
                    </div>
                    <table class="min-w-full w-full mt-2 text-sm mb-4">
                        <thead class="bg-cyan-100">
                            <tr>
                                <th class="px-4 py-2">Form ID</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($applicationForm))
                                <tr class="hover:bg-gray-100">
                                    <td class="border px-4 py-2 text-center">{{ $applicationForm->id }}</td>
                                    <td class="border px-4 py-2 text-center">{{ $applicationForm->is_draft ? 'Draft' : 'Submitted' }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <a href="{{ route('application-form.show', $applicationForm->id) }}" class="text-indigo-600 hover:text-indigo-900">Review</a>
                                    </td>
                                </tr>
                            @else
                                <tr class="hover:bg-gray-100">
                                    <td colspan="3" class="border px-4 py-2 text-center">No Application found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    @if (isset($incompleteTabs))
                        @if (in_array('A', $incompleteTabs))
                            <div class="rounded-md bg-yellow-50 p-4 mb-4">
                                <div class="flex">
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-800">
                                            Tab A is not fully filled yet. Please complete it.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (in_array('B', $incompleteTabs))
                            <div class="rounded-md bg-yellow-50 p-4 mb-4">
                                <div class="flex">
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-800">
                                            Tab B is not fully filled yet. Please complete it.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (in_array('C', $incompleteTabs))
                            <div class="rounded-md bg-yellow-50 p-4 mb-4">
                                <div class="flex">
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-800">
                                            Tab C is not fully filled yet. Please complete it.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (in_array('D', $incompleteTabs))
                            <div class="rounded-md bg-yellow-50 p-4 mb-4">
                                <div class="flex">
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-800">
                                            Tab D is not fully filled yet. Please complete it.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (in_array('E', $incompleteTabs))
                            <div class="rounded-md bg-yellow-50 p-4 mb-4">
                                <div class="flex">
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-800">
                                            Tab E is not fully filled yet. Please complete it.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>

                <div id="coursesBySemester" class="tab-content hidden">
                    @if (isset($allCourses))
                        <h4 class="text-lg leading-6 font-medium text-gray-900">Courses by Semester:</h4>
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
                                                    <div><a href="{{ route('courses.show', $course->id) }}" class="text-blue-500 hover:text-blue-700 text-xs">View</a></div>
                                                </td>
                                                <td class="border px-4 py-2">{{ $course->course_credit }}</td>
                                                <td class="border px-4 py-2">{{ $course->prerequisites ?? 'None' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </details>
                        @endforeach
                    @endif
                </div>

                <div id="studyPlans" class="tab-content hidden">
                    @if (isset($studyPlans))
                        <h4 class="text-lg leading-6 font-medium text-gray-900">Study Plans:</h4>
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
                                                    <div><a href="{{ route('courses.show', $plan->course_id) }}" class="text-blue-500 hover:text-blue-700 text-xs">View</a></div>
                                                </td>
                                                <td class="border px-4 py-2">{{ $plan->course->course_credit }}</td>
                                                <td class="border px-4 py-2">{{ $plan->course->prerequisites ?? 'None' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </details>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        ul li .active {
            background-color: #dedfe1;
            /* Light gray background */
            color: blue;
            /* Dark text color for readability */
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.student-dashboard-tab');
            const contents = document.querySelectorAll('.tab-content');

            function activateTab(tab) {
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => {
                    c.classList.add('hidden'); // Hide all content areas
                    c.classList.remove('active');
                });
                tab.classList.add('active');
                const targetContent = document.querySelector(tab.getAttribute('href'));
                targetContent.classList.remove('hidden');
                targetContent.classList.add('active');
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function(event) {
                    event.preventDefault();
                    activateTab(this);
                });
            });

            // Activate the first tab by default on page load
            activateTab(tabs[0]); // Assuming the first tab is "Student Information"
        });
    </script>

</x-app-layout>
