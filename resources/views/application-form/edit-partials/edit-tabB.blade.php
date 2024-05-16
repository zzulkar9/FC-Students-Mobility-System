<!-- Content for Tab B -->
<div>
    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Education & Co-Curriculum</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Faculty -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Faculty</label>
            <input type="text" name="faculty" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter your faculty" value="{{ $educations->faculty ?? '' }}">
        </div>

        <!-- Current Semester -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Current Semester</label>
            <input type="text" name="current_semester" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter your current semester" value="{{ $educations->current_semester ?? '' }}">
        </div>

        <!-- Field of Study -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Field of Study</label>
            <input type="text" name="field_of_study" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter your field of study" value="{{ $educations->field_of_study ?? '' }}">
        </div>

        <!-- Expected Graduation -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Expected Graduation</label>
            <input type="month" name="expected_graduation" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" value="{{ $educations->expected_graduation ?? '' }}">
        </div>

        <!-- Program -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Program</label>
            <input type="text" name="program" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter your program" value="{{ $educations->program ?? '' }}">
        </div>

        <!-- Current Result (CGPA) -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Current Result (CGPA)</label>
            <input type="number" step="0.01" name="cgpa" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter your CGPA" value="{{ number_format($educations->cgpa, 2) ?? '' }}">
        </div>

        <!-- Co-Curriculum -->
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700">Co-Curriculum</label>
            <textarea name="co_curriculum" rows="3" class="mt-2 form-textarea block w-full rounded-md shadow-sm border-gray-300" placeholder="Describe your co-curricular activities">{{ $educations->co_curriculum ?? '' }}</textarea>
        </div>

        <!-- Achievements (Academic & Co-curriculum) -->
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700">Achievements (Academic & Co-curriculum)</label>
            <textarea name="achievements" rows="3" class="mt-2 form-textarea block w-full rounded-md shadow-sm border-gray-300" placeholder="List your achievements">{{ $educations->achievements ?? '' }}</textarea>
        </div>

        <!-- Special Skills / Soft Skills -->
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700">Special Skills / Soft Skills</label>
            <textarea name="special_skills" rows="3" class="mt-2 form-textarea block w-full rounded-md shadow-sm border-gray-300" placeholder="Describe your special or soft skills">{{ $educations->special_skills ?? '' }}</textarea>
        </div>
    </div>
</div>
