<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Study Plans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-xl leading-6 font-semibold text-gray-900 mb-4">List of Students</h3>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('study-plans.index') }}" class="mb-4">
                        <div class="flex items-center">
                            <input type="text" name="search" value="{{ $searchTerm }}" placeholder="Search by name or matric number" class="form-input block w-full sm:text-sm sm:leading-5 rounded-md shadow-sm border-gray-300">
                            <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200">
                                Search
                            </button>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white divide-y divide-gray-200 text-sm border border-gray-200">
                            <thead class="bg-cyan-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-200">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-200">Matric Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($students as $student)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap border border-gray-200">{{ $student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border border-gray-200">{{ $student->matric_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                            <a href="{{ route('study-plans.review.detail', $student->id) }}"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200">
                                                Review
                                            </a>
                                            <form action="{{ route('study-plans.destroy', $student->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200" onclick="return confirm('Are you sure you want to delete this student\'s study plans?');">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $students->appends(['search' => $searchTerm])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
