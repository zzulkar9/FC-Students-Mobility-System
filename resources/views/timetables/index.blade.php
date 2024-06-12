<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Timetables Management') }}
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

                    <form method="POST" action="{{ isset($student) ? route('inbound-students.update', $student->id) : route('timetables.saveAll') }}">
                        @csrf
                        @if(isset($student))
                            @method('PUT')
                        @endif
                        <div class="tabs">
                            <button type="button" onclick="showTab('inbound-info')">Inbound Student Info</button>
                            <button type="button" onclick="showTab('timetable')">Timetable</button>
                        </div>
                        
                        <div id="inbound-info" class="tab-content">
                            @include('timetables.inbound-info', ['student' => $student ?? null])
                        </div>
                        
                        <div id="timetable" class="tab-content" style="display: none;">
                            @include('timetables.show', ['student' => $student ?? null, 'selectedTimetables' => $student->timetables ?? collect()])
                        </div>

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
        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.style.display = 'none';
            });
            document.getElementById(tabName).style.display = 'block';
        }
    </script>
</x-app-layout>
