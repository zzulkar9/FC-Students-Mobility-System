<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Application Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Tab Navigation -->
                    <nav class="border-b border-gray-200">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                            data-tabs-toggle="#myTabContent" role="tablist">
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2 active-tab" id="profile-tab"
                                    data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                                    aria-selected="true" style="background-color: #E1F5FE;">Profile</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 rounded-t-lg border-b-2" id="courses-tab"
                                    data-tabs-target="#courses" type="button" role="tab" aria-controls="courses"
                                    aria-selected="false" style="background-color: #E1F5FE;">Courses</button>
                            </li>
                        </ul>
                    </nav>

                    <!-- Tab Content -->
                    <div id="myTabContent">
                        <div class="block p-4 bg-gray-100 rounded-lg bg-white" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Student Information</h3>
                            <table class="w-full text-sm">
                                <tbody>
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200 w-60">Name:</td>
                                        <td class="px-4 py-2">{{ $applicationForm->user->name }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Matric Number:</td>
                                        <td class="px-4 py-2">{{ $applicationForm->user->matric_number }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Upcoming Semester:</td>
                                        <td class="px-4 py-2">{{ Auth::user()->getCurrentSemester() }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Intake:</td>
                                        <td class="px-4 py-2">{{ Auth::user()->intake_period }}</td>
                                    </tr>
                                    @if ($applicationForm->link)
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-4 py-2 font-medium bg-gray-200">Link:</td>
                                            <td class="px-4 py-2"><a href="{{ $applicationForm->link }}" target="_blank" class="text-blue-500 hover:text-blue-700">{{ $applicationForm->link }}</a></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        

                        <div class="hidden p-4 bg-gray-50 rounded-lg" id="courses" role="tabpanel"
                            aria-labelledby="courses-tab">

                            <!-- Edit Button -->
                            @if (auth()->user()->isUtmStudent())
                                <div class="my-4">
                                    <a href="{{ route('application-form.edit', $applicationForm->id) }}"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit
                                        My
                                        Application</a>
                                </div>
                            @endif
                            <form action="{{ route('application-form.update-all-notes', $applicationForm->id) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <table class="min-w-full table-auto break-words text-sm">
                                    <thead class="bg-gray-200 font-medium">
                                        <tr>
                                            <th class="px-4 py-2 text-left" style="width: 10%;">UTM Course</th>
                                            <th class="px-4 py-2 text-left" style="width: 30%;">UTM Description</th>
                                            <th class="px-4 py-2 text-left" style="width: 10%;">Target Course</th>
                                            <th class="px-4 py-2 text-left" style="width: 30%;">Target Course Description</th>
                                            <th class="px-4 py-2 text-left" style="width: 20%;">Notes/Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($applicationForm->subjects as $subject)
                                            <tr class="hover:bg-gray-100">
                                                <td class="border px-4 py-2">{{ $subject->utm_course_code }} -
                                                    {{ $subject->utm_course_name }}</td>
                                                <td class="border px-4 py-2">{!! nl2br(e($subject->utm_course_description)) !!}</td>
                                                <td class="border px-4 py-2">{{ $subject->target_course }}</td>
                                                <td class="border px-4 py-2">{!! nl2br(e($subject->target_course_description)) !!}</td>
                                                <td class="border px-4 py-2">
                                                    @if (auth()->user()->isUtmStudent())
                                                        {{ $subject->notes }}
                                                    @else
                                                        <textarea name="notes[{{ $subject->id }}]" class="w-full">{{ $subject->notes }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-4">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('[data-tabs-target]');
            const tabContents = document.querySelectorAll('[role="tabpanel"]');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => {
                        t.classList.remove('active-tab');
                        t.style.backgroundColor = '#E1F5FE';
                        t.style.color = 'black';
                    });

                    tab.classList.add('active-tab');
                    tab.style.backgroundColor = '#4A90E2';
                    tab.style.color = 'white';

                    const target = document.querySelector(tab.dataset.tabsTarget);
                    tabContents.forEach(tc => {
                        tc.classList.remove('block');
                        tc.classList.add('hidden');
                    });
                    target.classList.remove('hidden');
                    target.classList.add('block');
                });
            });

            // Set initial active tab
            document.querySelector('#profile-tab').click();
        });
    </script>
</x-app-layout>
