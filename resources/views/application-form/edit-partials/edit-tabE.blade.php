<!-- Content for Tab E -->
<div>
    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Academic Advisor/Supervisor</h3>
    <div>
        <div class="mb-4">
            <label for="advisor_name" class="block text-sm font-medium text-gray-700">Name of Academic Advisor/ Supervisor:</label>
            <input type="text" id="advisor_name" name="advisor_name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter name" value="{{ $approval->advisor_name ?? 'N/A' }}">
        </div>
        <div class="mb-4">
            <label for="advisor_email" class="block text-sm font-medium text-gray-700">Email:</label>
            <input type="email" id="advisor_email" name="advisor_email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter email" value="{{ $approval->advisor_email ?? 'N/A' }}">
        </div>
        <div class="mb-4">
            <label for="advisor_phone" class="block text-sm font-medium text-gray-700">Phone Number:</label>
            <input type="tel" id="advisor_phone" name="advisor_phone" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter phone number" value="{{ $approval->advisor_phone ?? 'N/A' }}">
        </div>
        <div class="mb-4">
            <label for="advisor_remarks" class="block text-sm font-medium text-gray-700">Recommendation/Notes/Remarks:</label>
            <textarea id="advisor_remarks" name="advisor_remarks" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter details here">{{ $approval->advisor_remarks ?? 'N/A' }}</textarea>
        </div>
    </div>

    <hr class="my-6 border-gray-300"> <!-- Visual separator for clarity -->

    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Home Faculty Approval (Dean/Deputy Dean/Deputy Registrar)</h3>
    <div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Approval:</label>
            <div class="mt-2 flex items-center">
                <label class="inline-flex items-center mr-6">
                    <input type="radio" name="approval" value="approved" class="form-radio" {{ $approval->approval == 'approved' ? 'checked' : '' }}>
                    <span class="ml-2">Approved</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="approval" value="disapproved" class="form-radio" {{ $approval->approval == 'disapproved' ? 'checked' : '' }}>
                    <span class="ml-2">Disapproved</span>
                </label>
            </div>
        </div>
        <div class="mb-4">
            <label for="faculty_remarks" class="block text-sm font-medium text-gray-700">Recommendation/Notes/Remarks:</label>
            <textarea id="faculty_remarks" name="faculty_remarks" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter details here">{{ $approval->faculty_remarks ?? 'N/A' }}</textarea>
        </div>
    </div>
</div>
