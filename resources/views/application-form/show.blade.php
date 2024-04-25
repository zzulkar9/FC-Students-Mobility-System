<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Application Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Student Information</h3>
                    <p>Name: {{ $applicationForm->user->name }}</p>
                    <p>Matric Number: {{ $applicationForm->user->matric_number }}</p>
                    <p>Upcoming Semester: {{ Auth::user()->getCurrentSemester() }}</p>
                    <p>Intake: {{ Auth::user()->intake_period }}</p>
                    <!-- Display the link if available -->
                    @if($applicationForm->link)
                        <p>Link: <a href="{{ $applicationForm->link }}" target="_blank" class="text-blue-500 hover:text-blue-700">{{ $applicationForm->link }}</a></p>
                    @endif
                    <!-- Edit Button for UTM Students -->
                    @if(auth()->user()->isUtmStudent())
                        <div class="my-4 text-left">
                            <a href="{{ route('application-form.edit', $applicationForm->id) }}"
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Edit My Application
                            </a>
                        </div>
                    @endif
                    <!-- Table for displaying UTM and Target University Courses -->
                    <table class="min-w-full table-auto break-words">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">UTM Course</th>
                                <th class="px-4 py-2 text-left">UTM Description</th>
                                <th class="px-4 py-2 text-left">Target Course</th>
                                <th class="px-4 py-2 text-left">Target Course Description</th>
                                <th class="px-4 py-2 text-left">Notes/Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applicationForm->subjects as $subject)
                                <tr class="hover:bg-gray-100">
                                    <td class="border px-4 py-2" style="width: 15%;">
                                        {{ $subject->utm_course_code }} - {{ $subject->utm_course_name }}
                                    </td>
                                    <td class="border px-4 py-2" style="width: 25%;">{!! nl2br(e($subject->utm_course_description)) !!}</td>
                                    <td class="border px-4 py-2" style="width: 15%;">{{ $subject->target_course }}</td>
                                    <td class="border px-4 py-2" style="width: 25%;">{!! nl2br(e($subject->target_course_description)) !!}</td>
                                    <td class="border px-4 py-2" style="width: 20%;">
                                        @if (auth()->user()->isUtmStudent())
                                            {{ $subject->notes }}
                                        @else
                                            <!-- If this view is for a Program Coordinator, make the notes field editable -->
                                            <form action="{{ route('application-form.update-notes', $subject->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <textarea type="text" name="notes" value="{{ $subject->notes }}"
                                                    class="w-full">{{ $subject->notes }}</textarea>
                                                <button type="submit"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                                    Save
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
