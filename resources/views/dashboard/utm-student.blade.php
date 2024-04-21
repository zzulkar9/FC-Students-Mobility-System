<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Display student information -->
                    <div class="mb-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Student Information</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Name: {{ Auth::user()->name }}
                        </p>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Matric Number: {{ Auth::user()->matric_number }}
                        </p>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Current Semester: {{ Auth::user()->getCurrentSemester() }}
                        </p>
                    </div>
                    <!-- Table for displaying application forms -->
                    <table class="min-w-full w-full">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2">Form ID</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($applications as $application)
                                <tr class="hover:bg-gray-100">
                                    <td class="border px-4 py-2">{{ $application->id }}</td>
                                    <td class="border px-4 py-2">{{ $application->is_draft ? 'Draft' : 'Submitted' }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('application-form.show', $application->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="hover:bg-gray-100">
                                    <td colspan="3" class="border px-4 py-2 text-center">No applications found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
