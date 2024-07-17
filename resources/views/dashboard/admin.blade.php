{{-- resources/views/dashboard/admin.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
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
            <!-- Admin Info -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                <div class="text-gray-900">
                    <h3 class="text-xl font-semibold mb-4">Admin Information</h3>
                    <p class="mt-1 text-sm"><span class="font-bold">Name:</span> {{ Auth::user()->name }}</p>
                    <p class="mt-1 text-sm"><span class="font-bold">Email:</span> {{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Quick Info Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Total Users -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                    <div class="text-gray-900">
                        <h3 class="text-xl font-semibold">Total Users</h3>
                        <p class="text-4xl font-bold text-blue-600 mt-4">{{ $users->count() }}</p>
                        <a href="{{ route('users.users-list') }}"
                            class="text-blue-600 hover:text-blue-900 font-semibold mt-4 block">Manage Users</a>
                    </div>
                </div>
                <!-- Total Mobility Programs -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                    <div class="text-gray-900">
                        <h3 class="text-xl font-semibold">Total Mobility Programs</h3>
                        <p class="text-4xl font-bold text-blue-600 mt-4">{{ $programs->count() }}</p>
                        <a href="{{ route('mobility-programs.Programindex') }}"
                            class="text-blue-600 hover:text-blue-900 font-semibold mt-4 block">Manage Programs</a>
                    </div>
                </div>
            </div>

            <!-- Manage Mobility Programs -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">Manage Mobility Programs</h3>
                    <a href="{{ route('mobility-programs.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Add New Program
                    </a>
                </div>
                <p class="text-gray-700">View and manage all mobility programs currently available.</p>
                <a href="{{ route('mobility-programs.Programindex') }}"
                    class="text-blue-600 hover:text-blue-900 font-semibold mt-4 block">View Programs</a>
            </div>

            <!-- Users Overview Chart -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Users Overview</h3>
                <canvas id="usersChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Users Overview Chart
            const ctxUsers = document.getElementById('usersChart').getContext('2d');
            const usersChart = new Chart(ctxUsers, {
                type: 'bar',
                data: {
                    labels: ['Admin', 'Program Coordinator', 'UTM Student', 'TDA', 'UTM Staff',
                        'Academic Advisor'
                    ],
                    datasets: [{
                        label: 'User Types',
                        data: [
                            {{ $users->where('user_type', 'Admin')->count() }},
                            {{ $users->where('user_type', 'program_coordinator')->count() }},
                            {{ $users->where('user_type', 'utm_student')->count() }},
                            {{ $users->where('user_type', 'TDA')->count() }},
                            {{ $users->where('user_type', 'UTM Staff')->count() }},
                            {{ $users->where('user_type', 'Academic Advisor')->count() }}
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 159, 64, 0.6)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
