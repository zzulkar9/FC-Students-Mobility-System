<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-300">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-center mb-6">Edit Course</h1>
                    <form action="{{ route('courses.update', $course->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Course Code Input -->
                            <div class="mb-4">
                                <label for="course_code" class="block font-medium text-sm text-gray-700">Course Code</label>
                                <input type="text" name="course_code" id="course_code"
                                    value="{{ old('course_code', $course->course_code) }}" required
                                    class="rounded-md shadow-sm border-gray-300 mt-1 block w-full focus:ring-indigo-500 focus:border-indigo-500" />
                                @error('course_code')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Course Name Input -->
                            <div class="mb-4">
                                <label for="course_name" class="block font-medium text-sm text-gray-700">Course Name</label>
                                <input type="text" name="course_name" id="course_name"
                                    value="{{ old('course_name', $course->course_name) }}" required
                                    class="rounded-md shadow-sm border-gray-300 mt-1 block w-full focus:ring-indigo-500 focus:border-indigo-500" />
                                @error('course_name')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Year and Semester Dropdown -->
                            <div class="mb-4">
                                <label for="year_semester" class="block font-medium text-sm text-gray-700">Year and Semester</label>
                                <select id="year_semester" name="year_semester" required
                                    class="rounded-md shadow-sm border-gray-300 mt-1 block w-full focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="Year 1: Semester 1"
                                        @if ($course->year_semester == 'Year 1: Semester 1') selected @endif>Year 1: Semester 1</option>
                                    <option value="Year 1: Semester 2"
                                        @if ($course->year_semester == 'Year 1: Semester 2') selected @endif>Year 1: Semester 2</option>
                                    <option value="Year 2: Semester 1"
                                        @if ($course->year_semester == 'Year 2: Semester 1') selected @endif>Year 2: Semester 1</option>
                                    <option value="Year 2: Semester 2"
                                        @if ($course->year_semester == 'Year 2: Semester 2') selected @endif>Year 2: Semester 2</option>
                                    <option value="Year 3: Semester 1"
                                        @if ($course->year_semester == 'Year 3: Semester 1') selected @endif>Year 3: Semester 1</option>
                                    <option value="Year 3: Semester 2"
                                        @if ($course->year_semester == 'Year 3: Semester 2') selected @endif>Year 3: Semester 2</option>
                                    <option value="Year 4: Semester 1"
                                        @if ($course->year_semester == 'Year 4: Semester 1') selected @endif>Year 4: Semester 1</option>
                                    <option value="Year 4: Semester 2"
                                        @if ($course->year_semester == 'Year 4: Semester 2') selected @endif>Year 4: Semester 2</option>
                                </select>
                                @error('year_semester')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Course Credit Input -->
                            <div class="mb-4">
                                <label for="course_credit" class="block font-medium text-sm text-gray-700">Course Credit</label>
                                <input type="number" name="course_credit" id="course_credit"
                                    value="{{ old('course_credit', $course->course_credit) }}" required
                                    class="rounded-md shadow-sm border-gray-300 mt-1 block w-full focus:ring-indigo-500 focus:border-indigo-500" />
                                @error('course_credit')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Prerequisites Input -->
                            <div class="mb-4 md:col-span-2">
                                <label for="prerequisites" class="block font-medium text-sm text-gray-700">Prerequisites</label>
                                <input type="text" id="prerequisites" name="prerequisites"
                                    value="{{ old('prerequisites', $course->prerequisites) }}"
                                    class="rounded-md shadow-sm border-gray-300 mt-1 block w-full focus:ring-indigo-500 focus:border-indigo-500" />
                                @error('prerequisites')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Description Input -->
                        <div class="mb-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="rounded-md shadow-sm border-gray-300 mt-1 block w-full focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Update Button -->
                        <div class="flex items-center mt-4 justify-center space-x-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                            <button onclick="window.history.back();" type="button"
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Go Back</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
