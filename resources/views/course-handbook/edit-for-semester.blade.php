<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Course for {{ $intakeYear }} {{ $intakeSemester }} {{ $yearSemester }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-md bg-green-50 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Icon placeholder -->
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-md bg-red-50 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Icon placeholder -->
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-800">
                                {{ $errors->first() }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-300">
                <div class="p-6 bg-white">
                    <form method="POST" action="{{ route('courses.updateForSemester') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="intake_year" class="block text-sm font-medium text-gray-700">Intake Year:</label>
                            <input type="text" id="intake_year" name="intake_year" value="{{ $intakeYear }}" readonly
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="intake_semester" class="block text-sm font-medium text-gray-700">Intake Semester:</label>
                            <input type="text" id="intake_semester" name="intake_semester" value="{{ $intakeSemester }}" readonly
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="year_semester" class="block text-sm font-medium text-gray-700">Year and Semester:</label>
                            <input type="text" id="year_semester" name="year_semester" value="{{ $yearSemester }}" readonly
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div class="mb-6">
                            <label for="course_data" class="block text-sm font-medium text-gray-700">Paste Course Data:</label>
                            <p class="text-xs text-gray-600 mb-2">Enter each course on a new line in the following format:</p>
                            <pre class="bg-gray-50 p-2 rounded text-xs text-gray-700 mb-2">Course Code  Course Name  Credits  Prerequisites (if any)</pre>
                            <pre class="bg-gray-50 p-2 rounded text-xs text-gray-700 mb-4">Example:
SECR2043  Operating Systems  3
SECJ2154  Object Oriented Programming  4  SECJ1023</pre>
                            <textarea id="course_data" name="course_data" rows="10" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $courseData }}</textarea>
                        </div>

                        <div class="flex items-center justify-center mt-6">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-md">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
