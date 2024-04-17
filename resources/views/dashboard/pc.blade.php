<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Search form --}}
            <form method="GET" action="{{ route('dashboard-pc') }}"> <!-- Ensure the route name and logic supports search -->
                <div class="flex space-x-4 items-center mb-4">
                    <input type="text" name="search" class="rounded-md shadow-sm border-gray-300" placeholder="Search applications..." value="{{ request('search') }}">
                    <button type="submit" class="py-2 rounded-md">🔍</button>
                </div>
            </form>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full w-full border-collapse border border-gray-300 break-words">
                        <thead>
                            <tr>
                                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 bg-gray-100 border border-gray-300 text-center">Student Name</th>
                                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 bg-gray-100 border border-gray-300 text-center">Matric Number</th>
                                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 bg-gray-100 border border-gray-300 text-center">Intake</th>
                                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 bg-gray-100 border border-gray-300 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $application)
                                <tr class="hover:bg-gray-100">
                                    <td class="p-2 border-b border-gray-300 text-sm text-center">{{ $application->user->name }}</td>
                                    <td class="p-2 border-b border-gray-300 text-sm text-center">{{ $application->user->matric_number }}</td>
                                    <td class="p-2 border-b border-gray-300 text-sm text-center">{{ $application->intake_period }}</td>
                                    <td class="p-2 border-b border-gray-300 text-sm text-center">
                                        <a href="{{ route('application-form.show', $application->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Review</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 pb-3">
                        {{ $applications->appends(['search' => request('search')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
