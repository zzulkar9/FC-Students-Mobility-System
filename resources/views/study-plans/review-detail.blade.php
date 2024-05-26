<!-- resources/views/study-plans/review-detail.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Study Plan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg overflow-hidden">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-semibold text-gray-900 py-2">Study Plan for {{ $student->name }}</h3>
                    <form method="POST" action="{{ route('study-plans.save-remarks', $student->id) }}" class="mt-6">
                        @csrf
                        @foreach ($studyPlans as $yearSemester => $plans)
                            <h4 class="text-xl font-medium text-gray-900 py-4">{{ $yearSemester }}</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm border border-gray-300">
                                    <thead class="bg-cyan-100">
                                        <tr>
                                            <th class="px-4 py-2 border border-gray-300">Course Code</th>
                                            <th class="px-4 py-2 border border-gray-300">Course Name</th>
                                            <th class="px-4 py-2 border border-gray-300">Credits</th>
                                            <th class="px-4 py-2 border border-gray-300">Prerequisites</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($plans as $plan)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 border border-gray-300">{{ $plan->course->course_code }}</td>
                                                <td class="px-4 py-2 border border-gray-300">{{ $plan->course->course_name }}</td>
                                                <td class="px-4 py-2 border border-gray-300">{{ $plan->course->course_credit }}</td>
                                                <td class="px-4 py-2 border border-gray-300">{{ $plan->course->prerequisites ?? 'None' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-6">
                                <label for="remarks[{{ $yearSemester }}]" class="block text-sm font-medium text-gray-700">Remarks for {{ $yearSemester }}</label>
                                <textarea id="remarks[{{ $yearSemester }}]" name="remarks[{{ $yearSemester }}]" rows="3" class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ $plans->first()->remark }}</textarea>
                            </div>
                        @endforeach
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200">
                                Save Remarks
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>