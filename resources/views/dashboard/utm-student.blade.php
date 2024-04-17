<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
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
