<div>
    @if ($applicationForm->link)
        <div class="mb-4">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 font-medium bg-gray-200">Link:</td>
                    <td class="px-4 py-2">
                        <a href="{{ $applicationForm->link }}" target="_blank"
                            class="text-blue-500 hover:text-blue-700">{{ $applicationForm->link }}</a>
                    </td>
                </tr>
            </table>
        </div>
    @endif

    <form action="{{ route('application-form.update-all-notes', $applicationForm->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200 font-medium text-gray-700">
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
                            <td class="border px-4 py-2">{{ $subject->utm_course_code }} - {{ $subject->utm_course_name }}</td>
                            <td class="border px-4 py-2">{!! nl2br(e($subject->utm_course_description)) !!}</td>
                            <td class="border px-4 py-2">{{ $subject->target_course }}</td>
                            <td class="border px-4 py-2">{!! nl2br(e($subject->target_course_description)) !!}</td>
                            <td class="border px-4 py-2">
                                @if (auth()->user()->isUtmStudent())
                                    {{ $subject->notes }}
                                @else
                                    <textarea name="notes[{{ $subject->id }}]" class="w-full rounded-md border-gray-300 shadow-sm">{{ $subject->notes }}</textarea>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex justify-center">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Save
            </button>
        </div>
    </form>
</div>
