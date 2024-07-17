<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Academic Advisor Dashboard') }}
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
            <!-- Academic Advisor Info -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                <div class="text-gray-900">
                    <h3 class="text-xl font-semibold mb-4">Academic Advisor Information</h3>
                    <p class="mt-1 text-sm"><span class="font-bold">Name:</span> {{ Auth::user()->name }}</p>
                    <p class="mt-1 text-sm"><span class="font-bold">Email:</span> {{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Quick Info Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Outbound Applications -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                    <div class="text-gray-900">
                        <h3 class="text-xl font-semibold">Outbound Applications</h3>
                        <p class="text-4xl font-bold text-blue-600 mt-4">{{ $applications->total() }}</p>
                        <a href="{{ route('application-form.index') }}" class="text-blue-600 hover:text-blue-900 font-semibold mt-4 block">Manage Applications</a>
                    </div>
                </div>
                <!-- Study Plans -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                    <div class="text-gray-900">
                        <h3 class="text-xl font-semibold">Study Plans</h3>
                        <p class="text-4xl font-bold text-green-600 mt-4">{{ $studentsWithStudyPlans->total() }}</p>
                        <a href="{{ route('study-plans.index') }}" class="text-blue-600 hover:text-blue-900 font-semibold mt-4 block">Review Study Plans</a>
                    </div>
                </div>
            </div>

            <!-- Outbound Applications Approval Status -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border border-gray-300">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Outbound Applications Approval Status</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white divide-y divide-gray-200 border border-gray-300 rounded-lg">
                        <thead class="bg-blue-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Student Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Matric Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Approval Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Advisor Remarks</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Last Updated</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($applications->take(5) as $application)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $application->user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $application->user->matric_number }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $application->approval_status ? 'Approved' : 'Pending' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $application->advisorFacultyApprovalDetails->advisor_remarks ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $application->updated_at->format('d-m-Y H:i') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <a href="{{ route('application-form.show', $application->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs">Review</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 text-right">
                        <a href="{{ route('application-form.index') }}" class="text-blue-600 hover:text-blue-900 font-semibold">View More</a>
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
                    labels: ['Outbound Applications', 'Study Plans'],
                    datasets: [{
                        label: 'Count',
                        data: [{{ $applications->total() }}, {{ $studentsWithStudyPlans->total() }}],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(75, 192, 192, 0.6)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)'
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
