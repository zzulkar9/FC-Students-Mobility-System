<!-- Content for Tab B -->
<h3 class="text-lg leading-6 font-medium text-gray-900">Education & Co-Curriculum</h3>
<div class="grid grid-cols-2 gap-6">
    <div>
        <label class="block font-medium text-gray-700">Faculty:</label>
        <div>{{ $educations->faculty ?? 'N/A' }}</div>
    </div>
    <div>
        <label class="block font-medium text-gray-700">Current Semester:</label>
        <div>{{ $educations->current_semester ?? 'N/A' }}</div>
    </div>
    <div>
        <label class="block font-medium text-gray-700">Field of Study:</label>
        <div>{{ $educations->field_of_study ?? 'N/A' }}</div>
    </div>
    <div>
        <label class="block font-medium text-gray-700">Expected Graduation:</label>
        <div>{{ $educations->expected_graduation ?? 'N/A' }}</div>
    </div>
    <div>
        <label class="block font-medium text-gray-700">Program:</label>
        <div>{{ $educations->program ?? 'N/A' }}</div>
    </div>
    <div>
        <label class="block font-medium text-gray-700">Current Result (CGPA):</label>
        <div>{{ number_format($educations->cgpa, 2) ?? 'N/A' }}</div>
    </div>
    <div class="col-span-2">
        <label class="block font-medium text-gray-700">Co-Curriculum:</label>
        <div>{{ $educations->co_curriculum ?? 'N/A' }}</div>
    </div>
    <div class="col-span-2">
        <label class="block font-medium text-gray-700">Achievements (Academic & Co-curriculum):</label>
        <div>{{ $educations->achievements ?? 'N/A' }}</div>
    </div>
    <div class="col-span-2">
        <label class="block font-medium text-gray-700">Special Skills / Soft Skills:</label>
        <div>{{ $educations->special_skills ?? 'N/A' }}</div>
    </div>
</div>
