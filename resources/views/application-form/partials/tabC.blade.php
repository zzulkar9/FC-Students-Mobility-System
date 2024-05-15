<!-- Content for Tab C -->
<div>
    <h3 class="text-lg leading-6 font-medium text-gray-900">Mobility Program Information</h3>
    @if (Auth::user()->isUtmStudent())
        @if (!empty($courses))
            <div class="mb-4">
                <label for="link" class="block text-sm font-medium text-gray-700">Enter Link:</label>
                <input type="url" id="link" name="link"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter URL here">
            </div>
            <div class="overflow-hidden overflow-x-auto min-w-full align-middle sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left" style="width: 25%;">UTM Course</th>
                            <th class="px-4 py-2 text-left" style="width: 25%;">Target University Course</th>
                            <th class="px-4 py-2 text-left" style="width: 45%;">Course Description at Target University</th>
                            <th class="px-4 py-2 text-left" style="width: 5%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($courses as $course)
                            <tr class="course-field">
                                <td class="border px-4 py-2">
                                    <select name="utm_course_id[]" class="utm-course-select w-full">
                                        @foreach ($allCourses as $dropdownCourse)
                                            <option value="{{ $dropdownCourse->id }}"
                                                {{ $dropdownCourse->id == $course->id ? 'selected' : '' }}>
                                                {{ $dropdownCourse->course_code }} - {{ $dropdownCourse->course_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="border px-4 py-2">
                                    <textarea name="target_course[]" rows="4" class="w-full"></textarea>
                                </td>
                                <td class="border px-4 py-2">
                                    <textarea name="target_course_description[]" rows="4" class="w-full"></textarea>
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <button type="button" onclick="removeCourseField(this)"
                                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="button" onclick="addCourseField()"
                class="mt-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add More
                Subject</button>
        @else
            <div class="text-center p-4">{{ $message ?? 'No courses scheduled for this semester.' }}</div>
        @endif
    @else
        <p class="text-center">Only UTM students can access this page.</p>
    @endif
</div>






{{-- <div>
    @if (Auth::user()->isUtmStudent())
        @if (!empty($courses))
            <form method="POST" action="{{ route('application-form.submit') }}">
                @csrf
                <div class="mb-4">
                    <label for="link" class="block text-sm font-medium text-gray-700">Enter Link:</label>
                    <input type="url" id="link" name="link"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter URL here">
                </div>
                <div class="overflow-hidden overflow-x-auto min-w-full align-middle">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left" style="width: 25%;">UTM Course</th>
                                <th class="px-4 py-2 text-left" style="width: 25%;">Target University Course</th>
                                <th class="px-4 py-2 text-left" style="width: 45%;">Course Description at Target
                                    University</th>
                                <th class="px-4 py-2 text-left" style="width: 5%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($courses as $course)
                                <tr class="course-field">
                                    <td class="border px-4 py-2">
                                        <select name="utm_course_id[]" class="utm-course-select w-full">
                                            @foreach ($allCourses as $dropdownCourse)
                                                <option value="{{ $dropdownCourse->id }}"
                                                    {{ $dropdownCourse->id == $course->id ? 'selected' : '' }}>
                                                    {{ $dropdownCourse->course_code }} -
                                                    {{ $dropdownCourse->course_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <textarea name="target_course[]" rows="4" class="w-full"></textarea>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <textarea name="target_course_description[]" rows="4" class="w-full"></textarea>
                                    </td>
                                    <td class="border px-4 py-2 text-center">
                                        <button type="button" onclick="removeCourseField(this)"
                                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Remove</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="button" onclick="addCourseField()"
                    class="mt-4 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add More
                    Subject</button>
                <div class="flex items-center justify-center mt-4 space-x-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                    <button type="submit" name="action" value="save_draft"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Save Draft</button>
                </div>
            </form>
        @else
            <div class="text-center p-4">{{ $message ?? 'No courses scheduled for this semester.' }}</div>
        @endif
    @else
        <p class="text-center">Only UTM students can access this page.</p>
    @endif
</div> --}}
