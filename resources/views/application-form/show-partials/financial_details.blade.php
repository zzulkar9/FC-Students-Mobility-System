<!-- Content for Financial Details Tab -->
<h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Financial Details</h3>
<div class="bg-white p-6 rounded-lg border border-gray-200 space-y-6">
    <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">Financing Method:</label>
        <div class="bg-gray-100 p-2 rounded-md">{{ $financial->finance_method ?? 'N/A' }}</div>
    </div>

    <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">Details of Sponsorship/Financial Aid:</label>
        <div class="bg-gray-100 p-2 rounded-md">{{ $financial->sponsorship_details ?? 'N/A' }}</div>
    </div>

    <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">Cost Item Details:</label>
        {{-- <textarea class="bg-gray-100 p-2 rounded-md w-full" rows="4" readonly>{{ $financial->budget_details ?? 'N/A' }}</textarea> --}}
        <textarea class="bg-gray-100 p-2 rounded-md w-full" rows="4" readonly>{!! nl2br(e($financial->budget_details ?? 'N/A'))!!}</textarea>
        {!! nl2br(e($financial->budget_details ?? 'N/A'))!!}
    </div>
</div>
