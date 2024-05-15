<!-- Content for Approval Details Tab -->
<h3 class="text-lg leading-6 font-medium text-gray-900">Approval Details</h3>
<div>
    <label class="block text-sm font-medium text-gray-700">Academic Advisor/Supervisor:</label>
    <div>{{ $approval->advisor_name ?? 'N/A' }}</div>
    <div>{{ $approval->advisor_email ?? 'N/A' }}</div>
    <div>{{ $approval->advisor_phone ?? 'N/A' }}</div>
    <div>{{ $approval->advisor_remarks ?? 'N/A' }}</div>
</div>

<hr class="my-6"> <!-- Visual separator for clarity -->

<div>
    <label class="block text-sm font-medium text-gray-700">Home Faculty Approval:</label>
    <div>{{ $approval->faculty_approval ?? 'Pending' }}</div>
    <div>{{ $approval->faculty_remarks ?? 'N/A' }}</div>
</div>
