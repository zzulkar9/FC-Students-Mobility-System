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
                    <form method="POST" action="{{ route('application-form.submit') }}">
                        @csrf
                        <!-- UTM Course Selection -->
                        <div>
                            <label for="utm_course">UTM Course:</label>
                            <select name="utm_course" id="utm_course" required onchange="fetchCourseDetails(this.value);">
                                <option value="">Select a Course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                                @endforeach
                            </select>                            
                        </div>
                        
                        <!-- Dynamically filled fields for the selected UTM course -->
                        <div>
                            <label for="utm_course_code">Course Code:</label>
                            <input type="text" id="utm_course_code" name="utm_course_code" readonly>
                        </div>
                        
                        <div>
                            <label for="utm_course_name">Course Name:</label>
                            <input type="text" id="utm_course_name" name="utm_course_name" readonly>
                        </div>

                        <!-- Target University Course -->
                        <div>
                            <label for="target_course">Course at Target University:</label>
                            <input type="text" id="target_course" name="target_course" required>
                        </div>

                        <div>
                            <label for="target_course_description">Course Description at Target University:</label>
                            <input type="text" id="target_course" name="target_course_description" required>
                        </div>

                        <div>
                            <label for="target_course_notes">Notes:</label>
                            <input type="text" id="target_course" name="target_course_notes">
                        </div>

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
        function fetchCourseDetails(courseId) {
            fetch('/api/courses/' + courseId)
            .then(response => response.json())
            .then(data => {
                document.getElementById('utm_course_code').value = data.course_code;
                document.getElementById('utm_course_name').value = data.course_name;
                // Set other fields if necessary
            })
            .catch(error => console.error('Error loading course details:', error));
        }
        </script>
</x-app-layout>
