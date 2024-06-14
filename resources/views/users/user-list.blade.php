{{-- resources/views/dashboard/admin.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Search form --}}
            <form method="GET" action="{{ route('users.users-list') }}">
                <div class="flex space-x-4 items-center mb-4">
                    <input type="text" name="search" class="rounded-md shadow-sm border-gray-300" placeholder="Search users..." value="{{ request('search') }}">
                    <button type="submit" class="px-2 rounded-md">🔍</button>
                </div>
            </form>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Add User
                        </a>
                    </div>
                    <table class="min-w-full w-full border-collapse border border-gray-300 break-words">
                        <thead>
                            <tr>
                                <th class="p-3 font-bold uppercase bg-cyan-100 font-medium bg-cyan-100 text-xs border border-gray-300 text-center">Name</th>
                                <th class="p-3 font-bold uppercase bg-cyan-100 font-medium bg-cyan-100 text-xs border border-gray-300 text-center">Email</th>
                                <th class="p-3 font-bold uppercase bg-cyan-100 font-medium bg-cyan-100 text-xs border border-gray-300 text-center">User Type</th>
                                <th class="p-3 font-bold uppercase bg-cyan-100 font-medium bg-cyan-100 text-xs border border-gray-300 text-center">Matric Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-100">
                                    <td class="p-2 border-b border-gray-300 text-sm text-center">
                                        {{ $user->name }}
                                        <div class="text-xs mt-1 space-x-1">
                                            <a href="{{ route('users.edit', $user->id) }}" class="text-green-500 hover:text-green-700">Edit</a>
                                            <a> | </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="p-2 border-b border-gray-300 text-sm text-center">{{ $user->email }}</td>
                                    <td class="p-2 border-b border-gray-300 text-sm text-center">{{ $user->user_type }}</td>
                                    <td class="p-2 border-b border-gray-300 text-sm text-center">{{ $user->matric_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
