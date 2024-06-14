<!-- resources/views/timetables/show.blade.php -->

<div class="py-12">
    <div class="mx-auto sm:px-6 lg:px-8">
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

                <div class="mb-4">
                    <label for="search" class="block text-sm font-medium text-gray-700">Search Subjects</label>
                    <input type="text" id="search" name="search" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Search by course code or name">
                </div>

                @csrf
                <div class="overflow-auto h-64">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2">Course Code</th>
                                <th class="py-2">Course Name</th>
                                <th class="py-2">Program Type</th>
                                <th class="py-2">Year/Semester</th>
                                <th class="py-2">Section</th>
                                <th class="py-2">Timeslot</th>
                                <th class="py-2">Select</th>
                            </tr>
                        </thead>
                        <tbody id="subject-list">
                            @foreach ($allTimetables as $timetable)
                                <tr>
                                    <td class="border px-4 py-2">{{ $timetable->course_code }}</td>
                                    <td class="border px-4 py-2">{{ $timetable->course_name }}</td>
                                    <td class="border px-4 py-2">{{ $timetable->program_type }}</td>
                                    <td class="border px-4 py-2">{{ $timetable->year }} - {{ $timetable->semester }}</td>
                                    <td class="border px-4 py-2">{{ $timetable->section }}</td>
                                    <td class="border px-4 py-2">{{ $timetable->time_slot }}</td>
                                    <td class="border px-4 py-2">
                                        <input type="checkbox" name="selected_timetables[]" value="{{ json_encode($timetable) }}" class="timeslot-checkbox"
                                        @if($selectedTimetables->contains('timetables_course_id', $timetable->id))
                                            checked
                                        @endif
                                        >
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Timetable</h3>
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sunday</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monday</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tuesday</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wednesday</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thursday</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Friday</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saturday</th>
                    </tr>
                </thead>
                <tbody id="timetable-body" class="bg-white divide-y divide-gray-200">
                    <!-- Timetable slots will be generated here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for adding subjects to timetable -->
<div id="subjectModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>

        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div>
                <div class="mt-3 text-center sm:mt-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Add Subject to Timeslot</h3>
                    <div class="mt-2">
                        <label for="modal-course-code" class="block text-sm font-medium text-gray-700">Course Code</label>
                        <input type="text" id="modal-course-code" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., SECJ1013">

                        <label for="modal-course-name" class="block text-sm font-medium text-gray-700 mt-4">Course Name</label>
                        <input type="text" id="modal-course-name" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., Programming Technique">

                        <label for="modal-section" class="block text-sm font-medium text-gray-700 mt-4">Section</label>
                        <input type="text" id="modal-section" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., 01">
                        
                        <input type="hidden" id="modal-timeslot" name="modal-timeslot">
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="save-to-timetable" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Add</button>
                <button type="button" id="close-modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    const times = ['08:00-08:50', '09:00-09:50', '10:00-10:50', '11:00-11:50', '12:00-12:50', '13:00-13:50', '14:00-14:50', '15:00-15:50', '16:00-16:50'];
    const days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
    const timetableBody = document.getElementById('timetable-body');
    const colors = ['#ff9999', '#99ff99', '#9999ff', '#ffcc99', '#99ccff', '#ff99cc', '#ccff99'];
    let colorIndex = 0;

    // Generate timetable slots
    times.forEach(time => {
        const row = document.createElement('tr');
        row.innerHTML = `<td class="border px-4 py-2">${time}</td>` + days.map(day => `<td class="border px-4 py-2" data-time="${time}" data-day="${day}"></td>`).join('');
        timetableBody.appendChild(row);
    });

    const selectedTimeslots = new Set();

    // Handle checkbox ticking for live updates
    const checkboxes = document.querySelectorAll('.timeslot-checkbox');
    checkboxes.forEach(checkbox => {
        const timetable = JSON.parse(checkbox.value);
        const timeslots = timetable.time_slot.split(',').map(ts => ts.trim());
        const color = colors[colorIndex++ % colors.length];
        
        if (checkbox.checked) {
            timeslots.forEach(ts => {
                if (ts) {
                    const [day, slot] = ts.split(' ');
                    const time = getTimeFromSlot(slot);
                    const slotCell = document.querySelector(`td[data-day="${day}"][data-time="${time}"]`);
                    slotCell.innerHTML = `<span class="block p-2 rounded" style="background-color: ${color}">${timetable.course_code} - ${timetable.course_name}<br>Section ${timetable.section}</span>`;
                    selectedTimeslots.add(ts);
                }
            });
        }

        checkbox.addEventListener('change', function () {
            let hasClash = false;

            timeslots.forEach(ts => {
                if (ts) {
                    const [day, slot] = ts.split(' ');
                    const time = getTimeFromSlot(slot);
                    const slotCell = document.querySelector(`td[data-day="${day}"][data-time="${time}"]`);

                    if (this.checked) {
                        if (selectedTimeslots.has(ts)) {
                            hasClash = true;
                        } else {
                            selectedTimeslots.add(ts);
                            slotCell.innerHTML = `<span class="block p-2 rounded" style="background-color: ${color}">${timetable.course_code} - ${timetable.course_name}<br>Section ${timetable.section}</span>`;
                        }
                    } else {
                        selectedTimeslots.delete(ts);
                        slotCell.innerHTML = '';
                    }
                }
            });

            if (hasClash) {
                alert('Timeslot clash detected!');
                this.checked = false;
            }
        });
    });

    // Handle clicking on timetable slots
    document.querySelectorAll('#timetable-body td[data-day]').forEach(cell => {
        cell.addEventListener('click', function () {
            document.getElementById('modal-timeslot').value = `${this.dataset.day} ${getSlotFromTime(this.dataset.time)}`;
            document.getElementById('modal-course-code').value = '';
            document.getElementById('modal-course-name').value = '';
            document.getElementById('modal-section').value = '';
            document.getElementById('subjectModal').classList.remove('hidden');
        });
    });

    // Handle adding subject to timetable from modal
    document.getElementById('save-to-timetable').addEventListener('click', function() {
        const courseCode = document.getElementById('modal-course-code').value.trim();
        const courseName = document.getElementById('modal-course-name').value.trim();
        const section = document.getElementById('modal-section').value.trim();
        const modalTimeslot = document.getElementById('modal-timeslot').value.trim();
        const [day, slot] = modalTimeslot.split(' ');
        const time = getTimeFromSlot(slot);
        const slotCell = document.querySelector(`td[data-day="${day}"][data-time="${time}"]`);
        const color = colors[colorIndex++ % colors.length];

        if (selectedTimeslots.has(modalTimeslot)) {
            alert('Timeslot clash detected!');
        } else {
            selectedTimeslots.add(modalTimeslot);
            slotCell.innerHTML = `<span class="block p-2 rounded" style="background-color: ${color}">${courseCode} - ${courseName}<br>Section ${section}</span>`;
            document.getElementById('subjectModal').classList.add('hidden');
        }
    });

    document.getElementById('close-modal').addEventListener('click', function() {
        document.getElementById('subjectModal').classList.add('hidden');
    });

    function getTimeFromSlot(slot) {
        const slotMap = {
            '01': '08:00-08:50',
            '02': '09:00-09:50',
            '03': '10:00-10:50',
            '04': '11:00-11:50',
            '05': '12:00-12:50',
            '06': '13:00-13:50',
            '07': '14:00-14:50',
            '08': '15:00-15:50',
            '09': '16:00-16:50'
        };
        return slotMap[slot];
    }

    function getSlotFromTime(time) {
        const timeMap = {
            '08:00-08:50': '01',
            '09:00-09:50': '02',
            '10:00-10:50': '03',
            '11:00-11:50': '04',
            '12:00-12:50': '05',
            '13:00-13:50': '06',
            '14:00-14:50': '07',
            '15:00-15:50': '08',
            '16:00-16:50': '09'
        };
        return timeMap[time];
    }

    // Implement search functionality
    document.getElementById('search').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#subject-list tr');

        rows.forEach(row => {
            const courseCode = row.children[0].textContent.toLowerCase();
            const courseName = row.children[1].textContent.toLowerCase();

            if (courseCode.includes(searchTerm) || courseName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>