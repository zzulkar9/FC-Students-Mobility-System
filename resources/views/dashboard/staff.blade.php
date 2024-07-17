{{-- resources/views/dashboard/admin.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
            role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Staff Info -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 mb-6 border border-gray-300">
                <div class="text-gray-900">
                    <h3 class="text-xl font-semibold mb-4">UTM Staff Information</h3>
                    <p class="mt-1 text-sm"><span class="font-bold">Name:</span> {{ Auth::user()->name }}</p>
                    <p class="mt-1 text-sm"><span class="font-bold">Email:</span> {{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Quick Info Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Mobility Programs Count -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                    <div class="text-gray-900">
                        <h3 class="text-xl font-semibold">Total Mobility Programs</h3>
                        <p class="text-4xl font-bold text-blue-600 mt-4">{{ $programs->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Manage Mobility Programs -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 mb-6 border border-gray-300">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">Manage Mobility Programs</h3>
                    <a href="{{ route('mobility-programs.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Add New Program
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                        <thead class="bg-blue-100 text-gray-700">
                            <tr>
                                <th class="w-1/3 px-4 py-3 text-left text-sm font-medium border-b border-gray-300">Title</th>
                                <th class="w-1/4 px-4 py-3 text-left text-sm font-medium border-b border-gray-300">Due Date</th>
                                <th class="w-1/4 px-4 py-3 text-left text-sm font-medium border-b border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($programs as $program)
                                <tr class="border-t border-gray-300">
                                    <td class="px-4 py-3 text-sm border-b border-gray-300">{{ $program->title }}</td>
                                    <td class="px-4 py-3 text-sm border-b border-gray-300">{{ \Carbon\Carbon::parse($program->due_date)->format('F j, Y') }}</td>
                                    <td class="px-4 py-3 text-sm border-b border-gray-300">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('mobility-programs.show', $program->id) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded text-xs">View</a>
                                            <a href="{{ route('mobility-programs.edit', $program->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-xs">Edit</a>
                                            <form action="{{ route('mobility-programs.destroy', $program->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this program?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 text-right">
                        <a href="{{ route('mobility-programs.Programindex') }}" class="text-blue-600 hover:text-blue-900 font-semibold">View More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
