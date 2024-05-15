<!-- Content for Tab B -->
<h3 class="text-lg leading-6 font-medium text-gray-900">Education & Co-Curriculum</h3>
<div class="grid grid-cols-2 gap-6">
    <div>
        <label class="block font-medium text-gray-700">Faculty:</label>
        <input type="text" name="faculty" class="mt-1 block w-full form-input" placeholder="Enter your faculty" value="{{ $educations->faculty ?? 'N/A' }}">
    </div>
    <div>
        <label class="block font-medium text-gray-700">Current Semester:</label>
        <input type="text" name="current_semester" class="mt-1 block w-full form-input" placeholder="Enter your current semester" value="{{ $educations->current_semester ?? 'N/A' }}">
    </div>
    <div>
        <label class="block font-medium text-gray-700">Field of Study:</label>
        <input type="text" name="field_of_study" class="mt-1 block w-full form-input" placeholder="Enter your field of study" value="{{ $educations->field_of_study ?? 'N/A' }}">
    </div>
    <div>
        <label class="block font-medium text-gray-700">Expected Graduation:</label>
        <input type="month" name="expected_graduation" class="mt-1 block w-full form-input" value="{{ $educations->expected_graduation ?? 'N/A' }}">
    </div>
    <div>
        <label class="block font-medium text-gray-700">Program:</label>
        <input type="text" name="program" class="mt-1 block w-full form-input" placeholder="Enter your program" value="{{ $educations->program ?? 'N/A' }}">
    </div>
    <div>
        <label class="block font-medium text-gray-700">Current Result (CGPA):</label>
        <input type="number" step="0.01" name="cgpa" class="mt-1 block w-full form-input" placeholder="Enter your CGPA" value="{{ number_format($educations->cgpa, 2) ?? 'N/A' }}">
    </div>
    <div class="col-span-2">
        <label class="block font-medium text-gray-700">Co-Curriculum:</label>
        <textarea name="co_curriculum" rows="3" class="form-textarea mt-1 block w-full" placeholder="Describe your co-curricular activities">{{ $educations->co_curriculum ?? 'N/A' }}</textarea>
    </div>
    <div class="col-span-2">
        <label class="block font-medium text-gray-700">Achievements (Academic & Co-curriculum):</label>
        <textarea name="achievements" rows="3" class="form-textarea mt-1 block w-full" placeholder="List your achievements">{{ $educations->achievements ?? 'N/A' }}</textarea>
    </div>
    <div class="col-span-2">
        <label class="block font-medium text-gray-700">Special Skills / Soft Skills:</label>
        <textarea name="special_skills" rows="3" class="form-textarea mt-1 block w-full" placeholder="Describe your special or soft skills">{{ $educations->special_skills ?? 'N/A' }}</textarea>
    </div>
</div>
