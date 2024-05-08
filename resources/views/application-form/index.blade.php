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
                    <div class="mb-6">
                        <!-- Tab Navigation -->
                        <nav class="border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                                data-tabs-toggle="#myTabContent" role="tablist">
                                <li class="mr-2" role="presentation">
                                    <button
                                        class="inline-block p-4 rounded-t-lg border-b-2 active-tab"
                                        data-tabs-target="#tab1" type="button" role="tab">
                                        Student Info
                                    </button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button
                                        class="inline-block p-4 rounded-t-lg border-b-2"
                                        data-tabs-target="#tab2" type="button" role="tab">
                                        Course Selection
                                    </button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button
                                        class="inline-block p-4 rounded-t-lg border-b-2"
                                        data-tabs-target="#tab3" type="button" role="tab">
                                        Submission Details
                                    </button>
                                </li>
                            </ul>
                        </nav>

                        <!-- Tab Content -->
                        <div id="myTabContent">
                            <div class="block p-4 bg-gray-100 rounded-lg bg-white" id="tab1" role="tabpanel">
                                @include('application-form.partials.tab1')
                            </div>
                            <div class="hidden p-4 bg-gray-100 rounded-lg bg-white" id="tab2" role="tabpanel">
                                @include('application-form.partials.tab2')
                            </div>
                            <div class="hidden p-4 bg-gray-100 rounded-lg bg-white" id="tab3" role="tabpanel">
                                @include('application-form.partials.tab3')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                const tableBody = document.querySelector('.min-w-full tbody'); // Ensure this selector correctly points to your table body
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
    </script>
</x-app-layout>
