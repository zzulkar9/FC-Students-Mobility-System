<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Application Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-sm"> <!-- Adjusted text size -->
                    <!-- Form Start -->
                    <form method="POST" action="{{ route('application-form.submit') }}">
                        @csrf

                        <!-- Tab Navigation -->
                        <nav class="border-b border-gray-200 mb-4">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                                data-tabs-toggle="#myTabContent" role="tablist">
                                @foreach (['A' => 'Applicant Details', 'B' => 'Education & Co-Curriculum', 'C' => 'Mobility Program Information', 'D' => 'Financial', 'E' => 'Support / Approval', 'H' => 'Full Report'] as $key => $title)
                                    <li class="mr-2" role="presentation">
                                        <button class="inline-block p-4 rounded-t-lg border-b-2 {{ $loop->first ? 'active-tab' : '' }} hover:bg-blue-100 hover:text-blue-700 transition-colors duration-300"
                                            data-tabs-target="#tab{{ $key }}" type="button" role="tab">
                                            {{ $key }}. {{ $title }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>

                        <!-- Tab Content -->
                        <div id="myTabContent">
                            @foreach (['A', 'B', 'C', 'D', 'E'] as $key)
                                <div class="{{ $loop->first ? 'block' : 'hidden' }} p-4 bg-gray-50 rounded-lg"
                                    id="tab{{ $key }}" role="tabpanel">
                                    @include('application-form.partials.tab' . $key)
                                </div>
                            @endforeach
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-center mt-4"> <!-- Centered the button -->
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition-all duration-300">
                                Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts for Tabs and Additional Functionalities -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('[data-tabs-target]');
            const tabContents = document.querySelectorAll('[role="tabpanel"]');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => {
                        t.classList.remove('active-tab', 'text-blue-600', 'border-blue-600', 'bg-blue-100');
                        t.style.color = 'black'; // Reset text color
                    });
                    tab.classList.add('active-tab', 'text-blue-600', 'border-blue-600', 'bg-blue-100');

                    const target = document.querySelector(tab.dataset.tabsTarget);
                    tabContents.forEach(tc => tc.classList.add('hidden'));
                    target.classList.remove('hidden');
                });
            });

            // Set initial active tab
            const initialActiveTab = document.querySelector('.active-tab');
            if (initialActiveTab) {
                initialActiveTab.click();
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

    <!-- Select2 JS -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

    <!-- Tailwind CSS -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet"> --}}

    <!-- jQuery (required by Select2) -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('.utm-course-select').select2({
                width: '100%',
                placeholder: "Select a course",
                allowClear: true
            }); // Initialize Select2 on existing selects
    
            window.addCourseField = function() {
                const tableBody = document.querySelector('.min-w-full tbody');
                const row = document.createElement('tr');
                row.className = 'course-field';
                row.innerHTML = `
                    <td class="px-4 py-4 whitespace-nowrap">
                        <select name="utm_course_id[]" class="utm-course-select form-select w-full rounded-md border-gray-300 shadow-sm">
                            @foreach ($allCourses as $dropdownCourse)
                                <option value="{{ $dropdownCourse->id }}">{{ $dropdownCourse->course_code }} - {{ $dropdownCourse->course_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <textarea name="target_course[]" rows="4" class="form-textarea w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter target university course"></textarea>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                    <textarea name="target_course_credit[]" rows="1" class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter target university course credit"></textarea>
                </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <textarea name="target_course_description[]" rows="4" class="form-textarea w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter course description at target university"></textarea>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-center">
                        <button type="button" onclick="removeCourseField(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Remove</button>
                    </td>
                `;
                tableBody.appendChild(row);
                $(row).find('.utm-course-select').select2({
                    width: '100%',
                    placeholder: "Select a course",
                    allowClear: true
                }); // Initialize Select2 on the new select
            };
    
            window.removeCourseField = function(button) {
                const row = button.closest('tr');
                $(row).find('.utm-course-select').select2('destroy'); // Destroy Select2 before removing the row
                row.remove();
            }
        });
    
        document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
            console.log('Submit button clicked');
        });
    </script>    
</x-app-layout>
