<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-center">Edit Course</h1>
                <form action="{{ route('courses.update', $course->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Course Code Input -->
                    <div class="mb-4">
                        <label for="course_code" class="block font-medium text-sm text-gray-700">Course Code</label>
                        <input type="text" name="course_code" id="course_code" value="{{ old('course_code', $course->course_code) }}" required class="rounded-md shadow-sm border-gray-300 mt-1 block w-full" />
                        @error('course_code')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Course Name Input -->
                    <div class="mb-4">
                        <label for="course_name" class="block font-medium text-sm text-gray-700">Course Name</label>
                        <input type="text" name="course_name" id="course_name" value="{{ old('course_name', $course->course_name) }}" required class="rounded-md shadow-sm border-gray-300 mt-1 block w-full" />
                        @error('course_name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description Input -->
                    <div class="mt-4">
                        <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="4" class="rounded-md shadow-sm border-gray-300 mt-1 block w-full">{{ old('description', $course->description) }}</textarea>
                        @error('description')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Year and Semester Dropdown -->
                    <div class="mb-4">
                        <label for="year_semester" class="block font-medium text-sm text-gray-700">Year and Semester</label>
                        <select id="year_semester" name="year_semester" required class="rounded-md shadow-sm border-gray-300 mt-1 block w-full">
                            <!-- Dynamically populate or hardcode your options here -->
                            <option value="Year 1: Semester 1" @if($course->year_semester == 'Year 1: Semester 1') selected @endif>Year 1: Semester 1</option>
                            <option value="Year 1: Semester 2" @if($course->year_semester == 'Year 1: Semester 2') selected @endif>Year 1: Semester 2</option>
                            <option value="Year 2: Semester 1" @if($course->year_semester == 'Year 2: Semester 1') selected @endif>Year 2: Semester 1</option>
                            <option value="Year 2: Semester 2" @if($course->year_semester == 'Year 2: Semester 2') selected @endif>Year 2: Semester 2</option>
                            <option value="Year 3: Semester 1" @if($course->year_semester == 'Year 3: Semester 1') selected @endif>Year 3: Semester 1</option>
                            <option value="Year 3: Semester 2" @if($course->year_semester == 'Year 3: Semester 2') selected @endif>Year 3: Semester 2</option>
                            <option value="Year 4: Semester 1" @if($course->year_semester == 'Year 4: Semester 1') selected @endif>Year 4: Semester 1</option>
                            <option value="Year 4: Semester 2" @if($course->year_semester == 'Year 4: Semester 2') selected @endif>Year 4: Semester 2</option>
                            <!-- Add more options as needed -->
                        </select>
                        @error('year_semester')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Course Credit Input -->
                    <div class="mb-4">
                        <label for="course_credit" class="block font-medium text-sm text-gray-700">Course Credit</label>
                        <input type="number" name="course_credit" id="course_credit" value="{{ old('course_credit', $course->course_credit) }}" required class="rounded-md shadow-sm border-gray-300 mt-1 block w-full" />
                        @error('course_credit')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Prerequisites Input -->
                    <div class="mb-4">
                        <label for="prerequisites" class="block font-medium text-sm text-gray-700">Prerequisites</label>
                        <input type="text" name="prerequisites" id="prerequisites" value="{{ old('prerequisites', $course->prerequisites) }}" class="rounded-md shadow-sm border-gray-300 mt-1 block w-full" />
                        @error('prerequisites')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Update Button -->
                    <div class="flex items-center mt-4 justify-center">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
