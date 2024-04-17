<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Application Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('application-form.update', $applicationForm->id) }}">
                        @csrf
                        @method('PUT')

                        <h3>Student Information</h3>
                        <p>Name: {{ $applicationForm->user->name }}</p>
                        <p>Matric Number: {{ $applicationForm->user->matric_number }}</p>
                        
                        <!-- Table for dynamically adding/removing courses -->
                        <table class="min-w-full table-auto break-words">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-4 py-2 text-left">UTM Course</th>
                                    <th class="px-4 py-2 text-left">Target Course</th>
                                    <th class="px-4 py-2 text-left">Target Course Description</th>
                                    <th class="px-4 py-2 text-left">Notes</th>
                                    <th class="px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applicationForm->subjects as $subject)
                                <tr class="hover:bg-gray-100">
                                    <td class="border px-4 py-2">
                                        <select name="utm_course_id[]">
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}" {{ $subject->utm_course_id == $course->id ? 'selected' : '' }}>
                                                    {{ $course->course_code }} - {{ $course->course_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <input type="text" name="target_course[]" value="{{ $subject->target_course }}" class="w-full">
                                    </td>
                                    <td class="border px-4 py-2">
                                        <input type="text" name="target_course_description[]" value="{{ $subject->target_course_description }}" class="w-full">
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ $subject->notes }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        <button type="button" onclick="removeSubject(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Remove</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button type="button" onclick="addSubject()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Add Subject
                        </button>

                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addSubject() {
            const tableBody = document.querySelector('table tbody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="border px-4 py-2">
                    <select name="utm_course_id[]">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="border px-4 py-2"><input type="text" name="target_course[]" class="w-full"></td>
                <td class="border px-4 py-2"><input type="text" name="target_course_description[]" class="w-full"></td>
                <td class="border px-4 py-2"><input type="text" name="notes[]" class="w-full"></td>
                <td class="border px-4 py-2">
                    <button type="button" onclick="removeSubject(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Remove</button>
                </td>
            `;
            tableBody.appendChild(row);
        }

        function removeSubject(button) {
            button.closest('tr').remove();
        }
    </script>
</x-app-layout>
