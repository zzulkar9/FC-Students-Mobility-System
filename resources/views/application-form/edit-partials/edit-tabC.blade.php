<!-- Content for Edit Tab C -->
<div>
    @if (!empty($applicationForm->subjects))
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">UTM Course</th>
                    <th class="px-4 py-2 text-left">Target University Course</th>
                    <th class="px-4 py-2 text-left">Course Description at Target University</th>
                    <th class="px-4 py-2 text-left">Notes</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applicationForm->subjects as $subject)
                    <tr class="hover:bg-gray-100 course-field">
                        <td class="border px-4 py-2">
                            <select name="utm_course_id[]" class="utm-course-select w-full">
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" {{ $subject->utm_course_id == $course->id ? 'selected' : '' }}>
                                        {{ $course->course_code }} - {{ $course->course_name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="border px-4 py-2">
                            <textarea name="target_course[]" rows="2" class="w-full">{{ $subject->target_course }}</textarea>
                        </td>
                        <td class="border px-4 py-2">
                            <textarea name="target_course_description[]" rows="2" class="w-full">{{ $subject->target_course_description }}</textarea>
                        </td>
                        <td class="border px-4 py-2">
                            <textarea name="target_course_notes[]" rows="2" class="w-full">{{ $subject->notes }}</textarea>
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <button type="button" onclick="removeSubject(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Remove</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" onclick="addSubject()" class="mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add Subject</button>
    @else
        <p>No subjects found for this application form.</p>
    @endif
</div>
