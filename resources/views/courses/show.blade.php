<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-center mb-10">Course Information</h1>
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 bg-blue-50">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Course Overview</h3>
                        </div>
                        <div class="border-t border-gray-200">
                            <div class="px-4 py-5 sm:px-6">
                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-8">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Course Code</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $course->course_code }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Course Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $course->course_name }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Year and Semester</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $course->year_semester }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Course Credit</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $course->course_credit }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Prerequisites</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $course->prerequisites ?? 'None' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="px-4 py-5 sm:px-6 bg-blue-50 mt-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Course Description</h3>
                        </div>
                        <div class="border-t border-gray-200">
                            <div class="px-4 py-5 sm:px-6">
                                <p class="text-sm text-gray-900">{{ $course->description ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex justify-between mt-10">
                        <a href="javascript:history.back()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Go Back</a>
                        @if (!auth()->user()->isUtmStudent())
                            <a href="{{ route('courses.edit', $course->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
