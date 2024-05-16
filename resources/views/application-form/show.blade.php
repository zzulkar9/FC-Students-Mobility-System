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
                    <nav class="border-b border-gray-200 mb-4">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                            data-tabs-toggle="#myTabContent" role="tablist">
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 active-tab" id="profile-tab"
                                    data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                                    aria-selected="true">Profile</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2" id="courses-tab"
                                    data-tabs-target="#courses" type="button" role="tab" aria-controls="courses"
                                    aria-selected="false">Courses</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2" id="curriculum-tab"
                                    data-tabs-target="#curriculum" type="button" role="tab" aria-controls="curriculum"
                                    aria-selected="false">Curriculum</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2" id="financial-tab"
                                    data-tabs-target="#financial" type="button" role="tab" aria-controls="financial"
                                    aria-selected="false">Financial</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2" id="approval-tab"
                                    data-tabs-target="#approval" type="button" role="tab" aria-controls="approval"
                                    aria-selected="false">Approval</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2" id="report-tab"
                                    data-tabs-target="#report" type="button" role="tab" aria-controls="report"
                                    aria-selected="false">Report</button>
                            </li>
                        </ul>
                    </nav>

                    <!-- Tab Content -->
                    <div id="myTabContent">
                        <!-- Profile Tab Content -->
                        <div class="block p-4 rounded-lg" id="profile" role="tabpanel"
                            aria-labelledby="profile-tab">
                            @include('application-form.show-partials.student_information', [
                                'details' => $applicationForm->applicantDetails,
                            ])
                        </div>

                        <!-- Courses Tab Content -->
                        <div class="hidden p-4 rounded-lg" id="courses" role="tabpanel"
                            aria-labelledby="courses-tab">
                            @include('application-form.show-partials.courses_table', [
                                'subjects' => $applicationForm->subjects,
                            ])
                        </div>

                        <!-- Curriculum Content -->
                        <div class="hidden p-4 rounded-lg" id="curriculum" role="tabpanel"
                            aria-labelledby="curriculum-tab">
                            @include('application-form.show-partials.show_curriculum', [
                                'curriculum' => $applicationForm->educationDetails,
                            ])
                        </div>

                        <!-- Financial Tab Content -->
                        <div class="hidden p-4 rounded-lg" id="financial" role="tabpanel"
                            aria-labelledby="financial-tab">
                            @include('application-form.show-partials.financial_details', [
                                'financialDetails' => $applicationForm->financialDetails,
                            ])
                        </div>

                        <!-- Approval Tab Content -->
                        <div class="hidden p-4 rounded-lg" id="approval" role="tabpanel"
                            aria-labelledby="approval-tab">
                            @include('application-form.show-partials.approval_details', [
                                'approvalDetails' => $applicationForm->supportApprovalDetails,
                            ])
                        </div>

                        <!-- Report Tab Content -->
                        <div class="hidden p-4 rounded-lg" id="report" role="tabpanel"
                            aria-labelledby="report-tab">
                            @include('application-form.show-partials.show_report', [
                                'approvalDetails' => $applicationForm->supportApprovalDetails,
                            ])
                        </div>
                    </div>

                    <!-- Edit Button -->
                    @if (auth()->user()->isUtmStudent())
                        <div class="my-6 text-center">
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
