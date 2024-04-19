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
                        <table id="courseFields" class="min-w-full">
                            <thead>
                                <tr>
                                    <th>UTM Course</th>
                                    <th>Target University Course</th>
                                    <th>Course Description at Target University</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Initial course field will be added here by JavaScript -->
                            </tbody>
                        </table>

                        <!-- Button to add more subjects -->
                        <button type="button" onclick="addCourseField()"
                            class="mt-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Add More Subject
                        </button>

                        <!-- Actions -->
                        <div class="mt-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Submit
                            </button>
                            <button type="submit" name="action" value="save_draft"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
            const tableBody = document.querySelector('#courseFields tbody');
            const row = document.createElement('tr');
            row.className = 'course-field';
            row.innerHTML = `
        <td>
            <select name="utm_course_id[]" required>
                <option value="">Select a Course</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <textarea name="target_course[]" rows="2" required></textarea>
        </td>
        <td>
            <textarea name="target_course_description[]" rows="2" required></textarea>
        </td>
        <td>
            <button type="button" onclick="removeCourseField(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Remove</button>
        </td>
    `;
            tableBody.appendChild(row);
        }


        function removeCourseField(button) {
            button.closest('tr').remove();
        }

        // Initial add of course field on page load
        window.onload = addCourseField;
    </script>
</x-app-layout>
