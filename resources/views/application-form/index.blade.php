<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Application Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Form Start -->
                    <form method="POST" action="{{ route('application-form.submit') }}">
                        @csrf

                        <!-- Tab Navigation -->
                        <nav class="border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                                data-tabs-toggle="#myTabContent" role="tablist">
                                @foreach (['A' => 'Applicant Details', 'B' => 'Education & Co-Curriculum', 'C' => 'Mobility Program Information', 'D' => 'Financial', 'E' => 'Support / Approval', 'H' => 'Full Report'] as $key => $title)
                                    <li class="mr-2" role="presentation">
                                        <button
                                            class="inline-block p-4 rounded-t-lg border-b-2 {{ $loop->first ? 'active-tab' : '' }}"
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
                                <div class="{{ $loop->first ? 'block' : 'hidden' }} p-4 bg-gray-100 rounded-lg bg-white"
                                    id="tab{{ $key }}" role="tabpanel">
                                    @include('application-form.partials.tab' . $key)
                                </div>
                            @endforeach
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end mt-4">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
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
                    tabs.forEach(t => t.classList.remove('active-tab'));
                    tab.classList.add('active-tab');

                    const target = document.querySelector(tab.dataset.tabsTarget);
                    tabContents.forEach(tc => tc.classList.add('hidden'));
                    target.classList.remove('hidden');
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2/dist/css/select2.min.css" rel="stylesheet" />
    <script>
        $(document).ready(function() {
            $('.utm-course-select').select2(); // Initialize Select2 on existing selects

            window.addCourseField = function() {
                const tableBody = document.querySelector(
                '.min-w-full tbody'); // Ensure this selector correctly points to your table body
                const row = document.createElement('tr');
                row.className = 'course-field';
                row.innerHTML = `
                    <td class="border px-4 py-2">
                        <select name="utm_course_id[]" class="utm-course-select w-full">
                            @foreach ($allCourses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="border px-4 py-2">
                        <textarea name="target_course[]" rows="2" class="w-full"></textarea>
                    </td>
                    <td class="border px-4 py-2">
                        <textarea name="target_course_description[]" rows="4" class="w-full"></textarea>
                    </td>
                    <td class="border px-4 py-2 text-center">
                        <button type="button" onclick="removeCourseField(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Remove</button>
                    </td>
                `;
                tableBody.appendChild(row);
                $(row).find('.utm-course-select').select2(); // Initialize Select2 on the new select
            };

            function removeCourseField(button) {
                const row = button.closest('tr');
                $(row).find('.utm-course-select').select2('destroy'); // Destroy Select2 before removing the row
                row.remove();
            }
            window.removeCourseField = removeCourseField; // Make it global for inline onclick
        });

        document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
            console.log('Submit button clicked');
            // event.preventDefault(); // Uncomment to test without submitting the form
        });
    </script>
</x-app-layout>
