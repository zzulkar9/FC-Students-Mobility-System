<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('EDIT Timetables Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('inbound-students.update', $student->id)}}">
                        @csrf
                        @if(isset($student))
                            @method('PUT')
                        @endif

                        <!-- Tab Navigation -->
                        <nav class="border-b border-gray-200 mb-6">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                                <li class="mr-2" role="presentation">
                                    <button
                                        class="inline-block p-4 rounded-t-lg border-b-2 transition duration-300 ease-in-out active-tab bg-blue-500 text-white"
                                        data-tabs-target="#inbound-info" type="button" role="tab">
                                        Inbound Student Info
                                    </button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button
                                        class="inline-block p-4 rounded-t-lg border-b-2 transition duration-300 ease-in-out hover:bg-blue-100"
                                        data-tabs-target="#timetable" type="button" role="tab">
                                        Timetable
                                    </button>
                                </li>
                            </ul>
                        </nav>

                        <!-- Tab Content -->
                        <div id="myTabContent">
                            <div class="block rounded-lg" id="inbound-info" role="tabpanel">
                                @include('timetables.edit-partials.edit-info', ['student' => $student ?? null])
                            </div>
                            <div class="hidden rounded-lg" id="timetable" role="tabpanel">
                                @include('timetables.edit-partials.edit-course', ['student' => $student ?? null, 'selectedTimetables' => $student->timetables ?? collect()])
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-center mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ isset($student) ? 'Update' : 'Save All' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('[data-tabs-target]');
            const tabContents = document.querySelectorAll('[role="tabpanel"]');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => {
                        t.classList.remove('active-tab', 'bg-blue-500', 'text-white');
                        t.classList.add('hover:bg-blue-100');
                    });
                    tab.classList.add('active-tab', 'bg-blue-500', 'text-white');
                    tab.classList.remove('hover:bg-blue-100');

                    const target = document.querySelector(tab.dataset.tabsTarget);
                    tabContents.forEach(tc => tc.classList.add('hidden'));
                    target.classList.remove('hidden');
                });
            });

            // Set initial active tab
            const initialTab = document.querySelector('[data-tabs-target="#inbound-info"]');
            if (initialTab) {
                initialTab.click();
            }
        });
    </script>
</x-app-layout>
