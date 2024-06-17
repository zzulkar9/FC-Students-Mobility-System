<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Application Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Search form --}}
                    <form method="GET" action="{{ route('application-form.index') }}" class="mb-4 flex space-x-4 items-center">
                        <input type="text" name="search" class="form-input w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Search applications..." value="{{ request('search') }}">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 shadow-sm">Search</button>
                    </form>

                    <!-- Table for applications -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300 border border-gray-300 rounded-lg">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                        Student Name
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                        Matric Number
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($applications as $application)
                                    <tr class="hover:bg-gray-100 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            {{ $application->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            {{ $application->user->matric_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            <a href="{{ route('application-form.show', $application->id) }}"
                                                class="text-blue-600 hover:text-blue-900 transition duration-150">
                                                Review
                                            </a>
                                            <form action="{{ route('application-form.destroy', $application->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ml-2 text-red-600 hover:text-red-900 transition duration-150"
                                                    onclick="return confirm('Are you sure you want to delete this application?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $applications->appends(['search' => request('search')])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
