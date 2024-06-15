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
                                <button class="tab-button active" id="profile-tab" data-tabs-target="#profile"
                                    type="button" role="tab" aria-controls="profile"
                                    aria-selected="true">Profile</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="tab-button" id="courses-tab" data-tabs-target="#courses" type="button"
                                    role="tab" aria-controls="courses" aria-selected="false">Courses</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="tab-button" id="curriculum-tab" data-tabs-target="#curriculum"
                                    type="button" role="tab" aria-controls="curriculum"
                                    aria-selected="false">Curriculum</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="tab-button" id="financial-tab" data-tabs-target="#financial"
                                    type="button" role="tab" aria-controls="financial"
                                    aria-selected="false">Financial</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="tab-button" id="approval-tab" data-tabs-target="#approval" type="button"
                                    role="tab" aria-controls="approval" aria-selected="false">Approval</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="tab-button" id="calculated-credits-tab"
                                    data-tabs-target="#calculated-credits" type="button" role="tab"
                                    aria-controls="calculated-credits" aria-selected="false">Calculated Credits</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="tab-button" id="report-tab" data-tabs-target="#report" type="button"
                                    role="tab" aria-controls="report" aria-selected="false">Report</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="tab-button" id="comments-tab" data-tabs-target="#comments" type="button"
                                    role="tab" aria-controls="comments" aria-selected="false">Comments</button>
                            </li>
                        </ul>
                    </nav>

                    <!-- Tab Content -->
                    <div id="myTabContent">
                        <!-- Profile Tab Content -->
                        <div class="block p-4 rounded-lg" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            @include('application-form.show-partials.student_information', [
                                'details' => $applicationForm->applicantDetails,
                            ])
                        </div>

                        <!-- Courses Tab Content -->
                        <div class="hidden p-4 rounded-lg" id="courses" role="tabpanel" aria-labelledby="courses-tab">
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

                        <!-- Calculated Credits Tab Content -->
                        <div class="hidden p-4 rounded-lg" id="calculated-credits" role="tabpanel"
                            aria-labelledby="calculated-credits-tab">
                            @include('application-form.show-partials.calculated_credits', [
                                'subjects' => $applicationForm->subjects,
                            ])
                        </div>

                        <!-- Report Tab Content -->
                        <div class="hidden p-4 rounded-lg" id="report" role="tabpanel"
                            aria-labelledby="report-tab">
                            @include('application-form.show-partials.show_report', [
                                'approvalDetails' => $applicationForm->supportApprovalDetails,
                            ])
                        </div>

                        <!-- Comments Tab Content -->
                        <div class="hidden p-4 rounded-lg" id="comments" role="tabpanel"
                            aria-labelledby="comments-tab">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 py-2">Comments</h3>
                            @foreach ($comments as $comment)
                                <div class="border-b py-2">
                                    <strong>{{ $comment->user->name }}</strong> comments:
                                    <p>{!! nl2br(e($comment->comment)) !!}</p>
                                    <span
                                        class="text-sm text-gray-500">{{ $comment->created_at->format('d M Y, h:i A') }}</span>
                                </div>
                            @endforeach


                            <form method="POST"
                                action="{{ route('application-form.comment.store', $applicationForm->id) }}">
                                @csrf
                                <div class="mt-4">
                                    <textarea name="comment" rows="4" class="form-textarea mt-1 block w-full" placeholder="Leave a comment..."></textarea>
                                </div>
                                <div class="mt-2 text-right">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Add Comment
                                    </button>
                                </div>
                            </form>


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
                    });

                    tab.classList.add('active-tab');

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

    <style>
        .tab-button {
            background-color: #E1F5FE;
            /* Light blue background */
            color: #1E3A8A;
            /* Dark blue text */
            padding: 10px 20px;
            margin: 0 5px;
            border: 1px solid transparent;
            border-radius: 5px 5px 0 0;
            /* Rounded top corners */
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .tab-button:hover {
            background-color: #1E3A8A;
            /* Dark blue background on hover */
            color: white;
            /* White text on hover */
        }

        .tab-button.active-tab {
            background-color: #1E3A8A;
            /* Dark blue background */
            color: white;
            /* White text */
            border-bottom: 2px solid #1E3A8A;
            /* Active tab border */
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>
</x-app-layout>
