<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard / Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="flex mx-auto sm:px-6 lg:px-8">
            <!-- Left Navigation for tabs -->
            <div class="w-64 flex flex-col mr-8">
                <!-- Navigation Tabs -->
                <ul class="flex flex-col bg-white rounded-lg border shadow-sm">
                    <li class="border-b">
                        <a href="#outbound" class="dashboard-tab block p-4 hover:bg-gray-100">Outbound</a>
                    </li>
                    <li>
                        <a href="#inbound" class="dashboard-tab block p-4 hover:bg-gray-100">Inbound</a>
                    </li>
                </ul>
            </div>

            <!-- Right Content Area -->
            <div class="flex-1 bg-white overflow-hidden shadow-sm sm:rounded-lg border-b border-gray-200 p-6">
                <!-- Outbound Tab Content -->
                <div id="outbound" class="tab-content active">
                    {{-- Search form --}}
                    <form method="GET" action="{{ route('dashboard-pc') }}" class="mb-4">
                        <div class="flex space-x-4">
                            <input type="text" name="search" class="form-input w-1/2 rounded-md border-gray-300"
                                placeholder="Search applications..." value="{{ request('search') }}">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Search</button>
                        </div>
                    </form>
                    <!-- Table for outbound applications -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="py-6 bg-white border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-300 border">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Student Name
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Matric Number
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($applications as $application)
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $application->user->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $application->user->matric_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('application-form.show', $application->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                    Review
                                                </a>
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

                <!-- Inbound Tab Content -->
                <div id="inbound" class="tab-content hidden">
                    <p class="text-center p-4">Inbound applications will be listed here.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        ul li .active {
            background-color: #dedfe1;
            /* Light gray background */
            color: blue;
            /* Dark text color for readability */
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.dashboard-tab');
            const contents = document.querySelectorAll('.tab-content');

            // Function to activate a tab
            function activateTab(tab) {
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => {
                    c.classList.add('hidden');
                    c.classList.remove('active');
                });

                tab.classList.add('active');
                const targetContent = document.querySelector(tab.getAttribute('href'));
                targetContent.classList.remove('hidden');
                targetContent.classList.add('active');
            }

            // Add click event to all tabs
            tabs.forEach(tab => {
                tab.addEventListener('click', function(event) {
                    event.preventDefault();
                    activateTab(this);
                });
            });

            // Activate the 'Outbound' tab on initial load
            const initialTab = document.querySelector('.dashboard-tab[href="#outbound"]');
            if (initialTab) {
                activateTab(initialTab);
            }
        });
    </script>
</x-app-layout>
