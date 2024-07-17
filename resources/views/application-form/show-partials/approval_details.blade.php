<h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Approval Details</h3>
<form action="{{ route('application-form.ApprovalUpdate', $applicationForm->id) }}" method="POST" class="space-y-6">
    @csrf
    @method('PATCH')
    <div class="bg-white p-6 rounded-lg border border-gray-200 space-y-6">
        <div class="space-y-4">
            <label class="block text-sm font-medium text-gray-700">Academic Advisor/Supervisor:</label>

            @if (auth()->user()->isAA())
                <label for="advisor_name" class="block text-sm font-medium text-gray-700">Name of Academic Advisor/
                    Supervisor:</label>
                <input type="text" name="advisor_name"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ $approval->advisor_name ?? '' }}" required>
                <label for="advisor_email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" name="advisor_email"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ $approval->advisor_email ?? '' }}" required>
                <label for="advisor_phone" class="block text-sm font-medium text-gray-700">Phone Number:</label>
                <input type="text" name="advisor_phone"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ $approval->advisor_phone ?? '' }}" required>
                <label for="advisor_remarks"
                    class="block text-sm font-medium text-gray-700">Recommendation/Notes/Remarks:</label>
                <textarea name="advisor_remarks" rows="3"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter details here" required>{{ $approval->advisor_remarks ?? '' }}</textarea>
            @else
                <label for="advisor_name" class="block text-sm font-medium text-gray-700">Name of Academic Advisor/
                    Supervisor:</label>
                <div class="bg-gray-100 p-2 rounded-md">{{ $approval->advisor_name ?? 'N/A' }}</div>
                <label for="advisor_email" class="block text-sm font-medium text-gray-700">Email:</label>
                <div class="bg-gray-100 p-2 rounded-md">{{ $approval->advisor_email ?? 'N/A' }}</div>
                <label for="advisor_phone" class="block text-sm font-medium text-gray-700">Phone Number:</label>
                <div class="bg-gray-100 p-2 rounded-md">{{ $approval->advisor_phone ?? 'N/A' }}</div>
                <label for="advisor_remarks"
                    class="block text-sm font-medium text-gray-700">Recommendation/Notes/Remarks:</label>
                <textarea class="bg-gray-100 p-2 rounded-md w-full" rows="3" readonly>{{ $approval->advisor_remarks ?? 'N/A' }}</textarea>
            @endif
        </div>

        <hr class="my-6 border-gray-300"> <!-- Visual separator for clarity -->

        <div class="space-y-4">
            <label class="block text-sm font-medium text-gray-700">Home Faculty Approval:</label>
            @if (auth()->user()->isTDA())
                <label class="block text-sm font-medium text-gray-700">Approval:</label>
                <input type="text" name="faculty_approval"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ $approval->faculty_approval ?? 'Pending' }}" required>
                <textarea name="faculty_remarks" rows="3"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter details here" required>{{ $approval->faculty_remarks ?? '' }}</textarea>
            @else
                <label class="block text-sm font-medium text-gray-700">Approval:</label>
                <div class="bg-gray-100 p-2 rounded-md">{{ $approval->faculty_approval ?? 'Pending' }}</div>
                <label for="faculty_remarks"
                    class="block text-sm font-medium text-gray-700">Recommendation/Notes/Remarks:</label>
                <textarea class="bg-gray-100 p-2 rounded-md w-full" rows="3" readonly>{{ $approval->faculty_remarks ?? 'N/A' }}</textarea>
            @endif
        </div>
    </div>

    @if (auth()->user()->isTDA() || auth()->user()->isAA())
        <div class="flex justify-center items-center mt-4">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">Save Remarks</button>
        </div>
    @endif
</form>
