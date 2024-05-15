<!-- Content for Financial Details Tab -->
<h3 class="text-lg leading-6 font-medium text-gray-900">Financial Details</h3>
<div>
    <label class="block text-sm font-medium text-gray-700">Financing Method:</label>
    <div>{{ $financial->finance_method ?? 'N/A' }}</div>
</div>

<div class="mt-4">
    <label class="block text-sm font-medium text-gray-700">Details of Sponsorship/Financial Aid:</label>
    <div>{{ $financial->sponsorship_details ?? 'N/A' }}</div>
</div>

<div class="mt-4">
    <label class="block text-sm font-medium text-gray-700">Cost Item Details:</label>
    <div>{{ $financial->budget_details ?? 'N/A' }}</div>
</div>
