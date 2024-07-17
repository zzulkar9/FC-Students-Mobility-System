{{-- resources/views/dashboard/pc.blade.php --}}
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
            <!-- Program Coordinator Info -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                <div class="text-gray-900">
                    <h3 class="text-xl font-semibold mb-4">Program Coordinator Information</h3>
                    <p class="mt-1 text-sm"><span class="font-bold">Name:</span> {{ $programCoordinator->name }}</p>
                    <p class="mt-1 text-sm"><span class="font-bold">Email:</span> {{ $programCoordinator->email }}</p>
                </div>
            </div>

            <!-- Quick Info Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Outbound Applications -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                    <div class="text-gray-900">
                        <h3 class="text-xl font-semibold">Outbound Applications</h3>
                        <p class="text-4xl font-bold text-blue-600 mt-4">{{ $applications->total() }}</p>
                        <a href="{{ route('application-form.index') }}"
                            class="text-blue-600 hover:text-blue-900 font-semibold mt-4 block">Manage Applications</a>
                    </div>
                </div>
                <!-- Review Study Plans -->
                {{-- <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                    <div class="text-gray-900">
                        <h3 class="text-xl font-semibold">Review Study Plans</h3>
                        <p class="text-4xl font-bold text-blue-600 mt-4">{{ $studentsWithStudyPlans->count() }}</p>
                        <a href="{{ route('study-plans.index') }}"
                            class="text-blue-600 hover:text-blue-900 font-semibold mt-4 block">Manage Study Plans</a>
                    </div>
                </div> --}}
                <!-- Inbound Students -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                    <div class="text-gray-900">
                        <h3 class="text-xl font-semibold">Inbound Students</h3>
                        <p class="text-4xl font-bold text-blue-600 mt-4">{{ $inboundStudents->total() }}</p>
                        <a href="{{ route('inbound-students.list') }}"
                            class="text-blue-600 hover:text-blue-900 font-semibold mt-4 block">Manage Inbound
                            Students</a>
                    </div>
                </div>
            </div>

            <!-- Graph Section -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Graphical Overview</h3>
                <canvas id="overviewChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctxOverview = document.getElementById('overviewChart').getContext('2d');
            const overviewChart = new Chart(ctxOverview, {
                type: 'bar',
                data: {
                    labels: ['Outbound Applications', 'Inbound Students'],
                    datasets: [{
                        label: 'Total',
                        data: [{{ $applications->total() }},
                            {{ $inboundStudents->total() }}
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(153, 102, 255, 0.6)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(153, 102, 255, 1)'
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
