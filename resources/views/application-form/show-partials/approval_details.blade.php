<!-- Content for Approval Details Tab -->
<h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Approval Details</h3>
<div class="bg-white p-6 rounded-lg shadow-2xl space-y-6">
    <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">Academic Advisor/Supervisor:</label>
        <div class="bg-gray-50 p-2 rounded-md border">{{ $approval->advisor_name ?? 'N/A' }}</div>
        <div class="bg-gray-50 p-2 rounded-md border">{{ $approval->advisor_email ?? 'N/A' }}</div>
        <div class="bg-gray-50 p-2 rounded-md border">{{ $approval->advisor_phone ?? 'N/A' }}</div>
        <textarea class="bg-gray-50 p-2 rounded-md border w-full" rows="3" readonly>{{ $approval->advisor_remarks ?? 'N/A' }}</textarea>
    </div>

    <hr class="my-6"> <!-- Visual separator for clarity -->

    <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">Home Faculty Approval:</label>
        <div class="bg-gray-50 p-2 rounded-md border">{{ $approval->faculty_approval ?? 'Pending' }}</div>
        <textarea class="bg-gray-50 p-2 rounded-md border w-full" rows="3" readonly>{{ $approval->faculty_remarks ?? 'N/A' }}</textarea>
    </div>
</div>
