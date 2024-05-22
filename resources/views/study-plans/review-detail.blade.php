<!-- resources/views/study-plans/review-detail.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Study Plan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 py-2">Study Plan for {{ $student->name }}</h3>
                    <form method="POST" action="{{ route('study-plans.save-remarks', $student->id) }}">
                        @csrf
                        @foreach ($studyPlans as $yearSemester => $plans)
                            <h4 class="text-lg leading-6 font-medium text-gray-900 py-2">{{ $yearSemester }}</h4>
                            <table class="min-w-full mt-2 text-sm">
                                <thead class="bg-cyan-100">
                                    <tr>
                                        <th class="border px-4 py-2">Course Code</th>
                                        <th class="border px-4 py-2">Course Name</th>
                                        <th class="border px-4 py-2">Credits</th>
                                        <th class="border px-4 py-2">Prerequisites</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($plans as $plan)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border px-4 py-2">{{ $plan->course->course_code }}</td>
                                            <td class="border px-4 py-2">{{ $plan->course->course_name }}</td>
                                            <td class="border px-4 py-2">{{ $plan->course->course_credit }}</td>
                                            <td class="border px-4 py-2">{{ $plan->course->prerequisites ?? 'None' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <label for="remarks[{{ $yearSemester }}]" class="block text-sm font-medium text-gray-700">Remarks for {{ $yearSemester }}</label>
                                <textarea id="remarks[{{ $yearSemester }}]" name="remarks[{{ $yearSemester }}]" rows="3" class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $plans->first()->remark }}</textarea>
                            </div>
                        @endforeach
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save Remarks
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
