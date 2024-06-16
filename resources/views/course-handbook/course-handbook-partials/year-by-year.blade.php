<!-- resources/views/course-handbook/course-handbook-partials/year-by-year.blade.php -->
<div x-data="{ 
    activeYear: '{{ $years->isNotEmpty() ? $years->first()->intake_year : '' }}', 
    showDuplicateModal: false, 
    duplicateYear: '', 
    duplicateIntake: '', 
    sourceYear: '', 
    sourceIntake: '',
    targetCreditsBySemester: {{ json_encode($targetCreditsBySemester) }},
    getTotalCredits(year, intake, semester) {
        return this.targetCreditsBySemester[year][intake][semester] ?? 0;
    },
    duplicateCourses() {
        console.log('Duplicate Data:', {
            sourceYear: this.sourceYear,
            sourceIntake: this.sourceIntake,
            targetYear: this.duplicateYear,
            targetIntake: this.duplicateIntake
        });

        if (!this.duplicateIntake) {
            alert('Please select a target intake');
            return;
        }

        let data = {
            sourceYear: this.sourceYear,
            sourceIntake: this.sourceIntake,
            targetYear: this.duplicateYear,
            targetIntake: this.duplicateIntake
        };

        axios.post('{{ route("courses.duplicate") }}', data)
            .then(response => {
                alert('Courses duplicated successfully');
                this.showDuplicateModal = false;
            })
            .catch(error => {
                console.error('Error data:', error.response.data); // Log error response data
                alert('An error occurred');
            });
    }
}">
    <div class="flex flex-col mb-4">
        <div class="flex space-x-1 mb-2">
            @foreach ($years as $year)
                <button class="text-sm py-2 px-4 rounded-lg" 
                        :class="{ 'bg-blue-500 text-white': activeYear === '{{ $year->intake_year }}', 'bg-gray-200 text-gray-800': activeYear !== '{{ $year->intake_year }}' }" 
                        @click="activeYear = '{{ $year->intake_year }}'">
                    {{ $year->intake_year }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
        @foreach ($years as $year)
            <div x-show="activeYear === '{{ $year->intake_year }}'" x-cloak>
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intake</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (['March/April', 'September'] as $intake)
                            <tr>
                                <td class="border px-6 py-4">{{ $intake }}</td>
                                <td class="border px-6 py-4">
                                    <form method="POST" action="{{ route('notes.store') }}">
                                        @csrf
                                        <input type="hidden" name="intake_year" value="{{ $year->intake_year }}">
                                        <input type="hidden" name="intake_semester" value="{{ $intake }}">
                                        <textarea name="note" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter note for {{ $intake }} here...">{{ isset($notes["{$year->intake_year}-$intake"]) && $notes["{$year->intake_year}-$intake"]->firstWhere('year_semester', null) ? $notes["{$year->intake_year}-$intake"]->firstWhere('year_semester', null)->note : '' }}</textarea>
                                        <button type="submit" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">Save Note</button>
                                    </form>
                                </td>
                                <td class="border px-6 py-4">
                                    <button @click="sourceYear = '{{ $year->intake_year }}'; sourceIntake = '{{ $intake }}'; showDuplicateModal = true;" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-4 rounded">Duplicate</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>

    <!-- Duplicate Modal -->
    <div x-show="showDuplicateModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showDuplicateModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Duplicate Courses</h3>
                            <div class="mt-2">
                                <label for="duplicateYear" class="block text-sm font-medium text-gray-700">Year</label>
                                <input type="text" id="duplicateYear" x-model="duplicateYear" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter year">
                                <label for="duplicateIntake" class="block text-sm font-medium text-gray-700 mt-4">Intake</label>
                                <select id="duplicateIntake" x-model="duplicateIntake" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option>Select Intake</option>
                                    <option value="March/April">March/April</option>
                                    <option value="September">September</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="duplicateCourses" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-500 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Duplicate
                    </button>
                    <button @click="showDuplicateModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
