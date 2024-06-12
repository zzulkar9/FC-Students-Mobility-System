<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-4">
            <label for="search_course" class="block text-sm font-medium text-gray-700">Search Subjects</label>
            <input type="text" id="search_course" name="search" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Search by course code or name">
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                <div class="mb-4">
                    <a href="{{ route('timetables.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add New Course
                    </a>
                </div>

                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Code</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Name</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Type</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year/Semester</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timeslot</th>
                        </tr>
                    </thead>
                    <tbody id="subject-list">
                        @foreach ($timetables as $timetable)
                            <tr class="hover:bg-gray-100">
                                <td class="border px-4 py-2">{{ $timetable->course_code }}</td>
                                <td class="border px-4 py-2">
                                    <div class="text-sm font-medium text-gray-900">{{ $timetable->course_name }}</div>
                                    <div class="text-xs text-gray-500">
                                        <a href="{{ route('timetables.editCourse', $timetable->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                                        <span class="mx-1">|</span>
                                        <form action="{{ route('timetables.destroy', $timetable->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="border px-4 py-2">{{ $timetable->program_type }}</td>
                                <td class="border px-4 py-2">{{ $timetable->year }} / {{ $timetable->semester }}</td>
                                <td class="border px-4 py-2">{{ $timetable->section }}</td>
                                <td class="border px-4 py-2">{{ $timetable->time_slot }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('search_course').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#subject-list tr');

        rows.forEach(row => {
            const courseCode = row.children[0].textContent.toLowerCase();
            const courseName = row.children[1].querySelector('.text-sm').textContent.toLowerCase();

            if (courseCode.includes(searchTerm) || courseName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
