<!-- Content for Approval Details Tab -->
<h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Approval Details</h3>
<div class="bg-white p-6 rounded-lg border border-gray-200 space-y-6">
    <div class="space-y-4">
        <label class="block text-sm font-medium text-gray-700">Academic Advisor/Supervisor:</label>
        <div class="bg-gray-100 p-2 rounded-md">{{ $approval->advisor_name ?? 'N/A' }}</div>
        <div class="bg-gray-100 p-2 rounded-md">{{ $approval->advisor_email ?? 'N/A' }}</div>
        <div class="bg-gray-100 p-2 rounded-md">{{ $approval->advisor_phone ?? 'N/A' }}</div>
        <textarea class="bg-gray-100 p-2 rounded-md w-full" rows="3" readonly>{{ $approval->advisor_remarks ?? 'N/A' }}</textarea>
    </div>

    <hr class="my-6 border-gray-300"> <!-- Visual separator for clarity -->

    <div class="space-y-4">
        <label class="block text-sm font-medium text-gray-700">Home Faculty Approval:</label>
        <div class="bg-gray-100 p-2 rounded-md">{{ $approval->faculty_approval ?? 'Pending' }}</div>
        <textarea class="bg-gray-100 p-2 rounded-md w-full" rows="3" readonly>{{ $approval->faculty_remarks ?? 'N/A' }}</textarea>
    </div>
</div>
