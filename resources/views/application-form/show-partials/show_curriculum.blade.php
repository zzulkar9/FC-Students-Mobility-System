<!-- Content for Tab B -->
<h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Education & Co-Curriculum</h3>
<div class="bg-white p-6 rounded-lg border border-gray-200">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block font-medium text-gray-700">Faculty:</label>
            <div class="bg-gray-100 p-2 rounded-md">{{ $educations->faculty ?? 'N/A' }}</div>
        </div>
        <div class="space-y-2">
            <label class="block font-medium text-gray-700">Current Semester:</label>
            <div class="bg-gray-100 p-2 rounded-md">{{ $educations->current_semester ?? 'N/A' }}</div>
        </div>
        <div class="space-y-2">
            <label class="block font-medium text-gray-700">Field of Study:</label>
            <div class="bg-gray-100 p-2 rounded-md">{{ $educations->field_of_study ?? 'N/A' }}</div>
        </div>
        <div class="space-y-2">
            <label class="block font-medium text-gray-700">Expected Graduation:</label>
            <div class="bg-gray-100 p-2 rounded-md">{{ $educations->expected_graduation ?? 'N/A' }}</div>
        </div>
        <div class="space-y-2">
            <label class="block font-medium text-gray-700">Program:</label>
            <div class="bg-gray-100 p-2 rounded-md">{{ $educations->program ?? 'N/A' }}</div>
        </div>
        <div class="space-y-2">
            <label class="block font-medium text-gray-700">Current Result (CGPA):</label>
            <div class="bg-gray-100 p-2 rounded-md">{{ number_format($educations->cgpa, 2) ?? 'N/A' }}</div>
        </div>
    </div>
    <div class="space-y-4 mt-6">
        <div class="space-y-2">
            <label class="block font-medium text-gray-700">Co-Curriculum:</label>
            <textarea class="bg-gray-100 p-2 rounded-md w-full" rows="3" readonly>{{ $educations->co_curriculum ?? 'N/A' }}</textarea>
        </div>
        <div class="space-y-2">
            <label class="block font-medium text-gray-700">Achievements (Academic & Co-curriculum):</label>
            <textarea class="bg-gray-100 p-2 rounded-md w-full" rows="3" readonly>{{ $educations->achievements ?? 'N/A' }}</textarea>
        </div>
        <div class="space-y-2">
            <label class="block font-medium text-gray-700">Special Skills / Soft Skills:</label>
            <textarea class="bg-gray-100 p-2 rounded-md w-full" rows="3" readonly>{{ $educations->special_skills ?? 'N/A' }}</textarea>
        </div>
    </div>
</div>
