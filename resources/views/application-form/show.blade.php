<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Application Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Tab Navigation -->
                    <nav class="border-b border-gray-200">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                            data-tabs-toggle="#myTabContent" role="tablist">
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 active-tab" id="profile-tab"
                                    data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                                    aria-selected="true" style="background-color: #E1F5FE;">Profile</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2" id="courses-tab"
                                    data-tabs-target="#courses" type="button" role="tab" aria-controls="courses"
                                    aria-selected="false" style="background-color: #E1F5FE;">Courses</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2" id="curriculum-tab"
                                    data-tabs-target="#curriculum" type="button" role="tab"
                                    aria-controls="curriculum" aria-selected="false"
                                    style="background-color: #E1F5FE;">Curriculum</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2" id="financial-tab"
                                    data-tabs-target="#financial" type="button" role="tab"
                                    aria-controls="financial" aria-selected="false"
                                    style="background-color: #E1F5FE;">Financial</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2" id="approval-tab"
                                    data-tabs-target="#approval" type="button" role="tab" aria-controls="approval"
                                    aria-selected="false" style="background-color: #E1F5FE;">Approval</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2" id="report-tab"
                                    data-tabs-target="#report" type="button" role="tab" aria-controls="report"
                                    aria-selected="false" style="background-color: #E1F5FE;">Report</button>
                            </li>
                        </ul>
                    </nav>

                    <!-- Tab Content -->
                    <div id="myTabContent">
                        <!-- Profile Tab Content -->
                        <div class="block p-4 bg-gray-100 rounded-lg bg-white" id="profile" role="tabpanel"
                            aria-labelledby="profile-tab">
                            @include('application-form.show-partials.student_information', [
                                'details' => $applicationForm->applicantDetails,
                            ])
                        </div>

                        <!-- Courses Tab Content -->
                        <div class="hidden p-4 bg-gray-50 rounded-lg" id="courses" role="tabpanel"
                            aria-labelledby="courses-tab">
                            @include('application-form.show-partials.courses_table', [
                                'subjects' => $applicationForm->subjects,
                            ])
                        </div>

                        <!-- Curriculum Content -->
                        <div class="hidden p-4 bg-gray-50 rounded-lg" id="curriculum" role="tabpanel"
                            aria-labelledby="curriculum-tab">
                            @include('application-form.show-partials.show_curriculum', [
                                'curriculum' => $applicationForm->educationDetails,
                            ])
                        </div>

                        <!-- Financial Tab Content -->
                        <div class="hidden p-4 bg-gray-50 rounded-lg" id="financial" role="tabpanel"
                            aria-labelledby="financial-tab">
                            @include('application-form.show-partials.financial_details', [
                                'financialDetails' => $applicationForm->financialDetails,
                            ])
                        </div>

                        <!-- Approval Tab Content -->
                        <div class="hidden p-4 bg-gray-50 rounded-lg" id="approval" role="tabpanel"
                            aria-labelledby="approval-tab">
                            @include('application-form.show-partials.approval_details', [
                                'approvalDetails' => $applicationForm->supportApprovalDetails,
                            ])
                        </div>

                        <!-- Report Tab Content -->
                        <div class="hidden p-4 bg-gray-50 rounded-lg" id="report" role="tabpanel"
                            aria-labelledby="report-tab">
                            @include('application-form.show-partials.show_report', [
                                'approvalDetails' => $applicationForm->supportApprovalDetails,
                            ])
                        </div>
                    </div>

                    <!-- Edit Button -->
                    @if (auth()->user()->isUtmStudent())
                        <div class="my-4">
                            <a href="{{ route('application-form.edit', $applicationForm->id) }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Edit My Application
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts for Tabs Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('[data-tabs-target]');
            const tabContents = document.querySelectorAll('[role="tabpanel"]');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => {
                        t.classList.remove('active-tab');
                        t.style.backgroundColor = '#E1F5FE';
                        t.style.color = 'black';
                    });

                    tab.classList.add('active-tab');
                    tab.style.backgroundColor = '#4A90E2';
                    tab.style.color = 'white';

                    const target = document.querySelector(tab.dataset.tabsTarget);
                    tabContents.forEach(tc => {
                        tc.classList.add('hidden');
                        tc.classList.remove('block');
                    });
                    target.classList.remove('hidden');
                    target.classList.add('block');
                });
            });

            // Set initial active tab
            document.querySelector('#profile-tab').click();
        });
    </script>
</x-app-layout>



{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Application Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Tab Navigation -->
                    <nav class="border-b border-gray-200">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                            data-tabs-toggle="#myTabContent" role="tablist">
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 active-tab" id="profile-tab"
                                    data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                                    aria-selected="true" style="background-color: #E1F5FE;">Profile</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2" id="courses-tab"
                                    data-tabs-target="#courses" type="button" role="tab" aria-controls="courses"
                                    aria-selected="false" style="background-color: #E1F5FE;">Courses</button>
                            </li>
                        </ul>
                    </nav>

                    <!-- Tab Content -->
                    <div id="myTabContent">
                        <!-- Student Information Tab -->
                        <div class="block p-4 bg-gray-100 rounded-lg bg-white" id="profile" role="tabpanel"
                            aria-labelledby="profile-tab">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Student Information</h3>
                            <table class="w-full text-sm">
                                <tbody>
                                    <!-- Ensure that each field is properly accessing data from the applicantDetails relationship -->
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200 w-60">Program Type:</td>
                                        <td class="px-4 py-2">{{ $details->program_type ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Religion:</td>
                                        <td class="px-4 py-2">{{ $details->religion ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Citizenship:</td>
                                        <td class="px-4 py-2">{{ $details->citizenship ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">IC/Passport Number:</td>
                                        <td class="px-4 py-2">{{ $details->ic_passport_number ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Contact Number:</td>
                                        <td class="px-4 py-2">{{ $details->contact_number ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Race:</td>
                                        <td class="px-4 py-2">{{ $details->race ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Home Address:</td>
                                        <td class="px-4 py-2">{{ $details->home_address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Next of Kin:</td>
                                        <td class="px-4 py-2">{{ $details->next_of_kin ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Emergency Contact:</td>
                                        <td class="px-4 py-2">{{ $details->emergency_contact ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Parents Occupation:</td>
                                        <td class="px-4 py-2">{{ $details->parents_occupation ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Parents Monthly Income:</td>
                                        <td class="px-4 py-2">{{ $details->parents_monthly_income ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>



                        <div class="hidden p-4 bg-gray-50 rounded-lg" id="courses" role="tabpanel"
                            aria-labelledby="courses-tab">
                            @if ($applicationForm->link)
                                <div class="table-responsive">
                                    <table class="w-full">
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-4 py-2 font-medium bg-gray-200">Link:</td>
                                            <td class="px-4 py-2">
                                                <a href="{{ $applicationForm->link }}" target="_blank"
                                                    class="text-blue-500 hover:text-blue-700">{{ $applicationForm->link }}</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endif

                            <!-- Edit Button -->
                            @if (auth()->user()->isUtmStudent())
                                <div class="my-4">
                                    <a href="{{ route('application-form.edit', $applicationForm->id) }}"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit
                                        My Application</a>
                                </div>
                            @endif

                            <form action="{{ route('application-form.update-all-notes', $applicationForm->id) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="table-responsive">
                                    <table class="min-w-full table-auto break-words text-sm">
                                        <thead class="bg-gray-200 font-medium">
                                            <tr>
                                                <th class="px-4 py-2 text-left" style="width: 10%;">UTM Course</th>
                                                <th class="px-4 py-2 text-left" style="width: 30%;">UTM Description</th>
                                                <th class="px-4 py-2 text-left" style="width: 10%;">Target Course</th>
                                                <th class="px-4 py-2 text-left" style="width: 30%;">Target Course
                                                    Description</th>
                                                <th class="px-4 py-2 text-left" style="width: 20%;">Notes/Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($applicationForm->subjects as $subject)
                                                <tr class="hover:bg-gray-100">
                                                    <td class="border px-4 py-2">{{ $subject->utm_course_code }} -
                                                        {{ $subject->utm_course_name }}</td>
                                                    <td class="border px-4 py-2">{!! nl2br(e($subject->utm_course_description)) !!}</td>
                                                    <td class="border px-4 py-2">{{ $subject->target_course }}</td>
                                                    <td class="border px-4 py-2">{!! nl2br(e($subject->target_course_description)) !!}</td>
                                                    <td class="border px-4 py-2">
                                                        @if (auth()->user()->isUtmStudent())
                                                            {{ $subject->notes }}
                                                        @else
                                                            <textarea name="notes[{{ $subject->id }}]" class="w-full">{{ $subject->notes }}</textarea>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                                </div>
                            </form>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('[data-tabs-target]');
            const tabContents = document.querySelectorAll('[role="tabpanel"]');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => {
                        t.classList.remove('active-tab');
                        t.style.backgroundColor = '#E1F5FE';
                        t.style.color = 'black';
                    });

                    tab.classList.add('active-tab');
                    tab.style.backgroundColor = '#4A90E2';
                    tab.style.color = 'white';

                    const target = document.querySelector(tab.dataset.tabsTarget);
                    tabContents.forEach(tc => {
                        tc.classList.remove('block');
                        tc.classList.add('hidden');
                    });
                    target.classList.remove('hidden');
                    target.classList.add('block');
                });
            });

            // Set initial active tab
            document.querySelector('#profile-tab').click();
        });
    </script>
</x-app-layout> --}}
