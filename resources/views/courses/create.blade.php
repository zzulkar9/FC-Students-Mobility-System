<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        @if (session('success'))
            <div class="rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Optional: Include an icon here -->
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{ route('courses.store') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="course_data" class="block text-sm font-medium text-gray-700">Paste Course
                            Data:</label>
                        <textarea id="course_data" name="course_data" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            rows="10"
                            placeholder="Enter each course on a new line, e.g.,\nSECR2043 Operating Systems 3 SECR1033\nSECJ2154 Object Oriented Programming 4 SECJ1023"
                            required></textarea>
                    </div>

                    <div>
                        <label for="year_semester" class="block text-sm font-medium text-gray-700">Year and
                            Semester:</label>
                        <select id="year_semester" name="year_semester" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="Year 1: Semester 1">Year 1: Semester 1</option>
                            <option value="Year 1: Semester 2">Year 1: Semester 2</option>
                            <option value="Year 2: Semester 1">Year 2: Semester 1</option>
                            <option value="Year 2: Semester 2">Year 2: Semester 2</option>
                            <option value="Year 3: Semester 1">Year 3: Semester 1</option>
                            <option value="Year 3: Semester 2">Year 3: Semester 2</option>
                            <option value="Year 4: Semester 1">Year 4: Semester 1</option>
                            <option value="Year 4: Semester 2">Year 4: Semester 2</option>
                        </select>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description
                            (Optional):</label>
                        <textarea id="description" name="description" rows="2"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    </div>

                    <div>
                        <label for="day_and_timeslot" class="block text-sm font-medium text-gray-700">Day and Timeslot
                            (comma-separated for multiple):</label>
                        <input type="text" id="day_and_timeslot" name="day_and_timeslot"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="flex items-center mt-4 justify-center">
                        <button type="submit" class="items-center">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
