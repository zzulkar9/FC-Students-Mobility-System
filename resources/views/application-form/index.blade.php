<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Application Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('application-form.submit') }}" id="applicationForm">
                        @csrf
                        <div id="courseFields">
                            <!-- Placeholder for dynamically added course fields -->
                        </div>

                        <!-- Button to add more subjects -->
                        <button type="button" onclick="addCourseField()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
                            Add More Subject
                        </button>

                        <!-- Actions -->
                        <div class="mt-4">
                            <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Submit
                            </button>
                            <button type="submit" name="action" value="save_draft" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Save Draft
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addCourseField() {
            const container = document.getElementById('courseFields');
            const fieldHTML = `
                <div class="course-field">
                    <label>UTM Course:</label>
                    <select name="utm_course_id[]" required>
                        <option value="">Select a Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                        @endforeach
                    </select>
                    <label>Target University Course:</label>
                    <input type="text" name="target_course[]" required>
                    <label>Course Description at Target University:</label>
                    <input type="text" name="target_course_description[]" required>
                    <label>Notes:</label>
                    <input type="text" name="target_course_notes[]">
                    <button type="button" onclick="removeCourseField(this)">Remove</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', fieldHTML);
        }

        function removeCourseField(button) {
            button.parentElement.remove();
        }

        // Initial add of course field on page load
        window.onload = function() {
            addCourseField(); // Add first set of input fields
        };
    </script>
</x-app-layout>
