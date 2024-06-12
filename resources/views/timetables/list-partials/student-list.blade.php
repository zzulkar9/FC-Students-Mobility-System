{{-- <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-4">
            <label for="search" class="block text-sm font-medium text-gray-700">Search Students</label>
            <input type="text" id="search" name="search" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Search by name or country">
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="mb-4 flex flex-start">
                    <a href="{{ route('timetables.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add New Student
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">Name</th>
                                <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">Country</th>
                                <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">Semester</th>
                                <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">Action</th>
                            </tr>
                        </thead>
                        <tbody id="student-list" class="bg-white divide-y divide-gray-200">
                            @foreach ($students as $student)
                                <tr class="hover:bg-gray-100">
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 border-b border-gray-300">{{ $student->name }}</td>
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 border-b border-gray-300">{{ $student->country }}</td>
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 border-b border-gray-300">{{ $student->semester }}</td>
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 border-b border-gray-300">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('inbound-students.edit', $student->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs">
                                                Review
                                            </a>
                                            <a href="{{ route('inbound-students.export', $student->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs">
                                                Download
                                            </a>
                                            <form action="{{ route('inbound-students.delete', $student->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs" onclick="return confirm('Are you sure you want to delete this student?');">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#student-list tr');

        rows.forEach(row => {
            const name = row.children[0].textContent.toLowerCase();
            const country = row.children[1].textContent.toLowerCase();

            if (name.includes(searchTerm) || country.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script> --}}
