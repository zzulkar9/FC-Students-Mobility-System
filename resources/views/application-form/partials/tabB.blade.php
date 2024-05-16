<!-- Content for Tab B -->
<h3 class="text-2xl font-semibold text-gray-900 mb-4">Education & Co-Curriculum</h3>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Faculty -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Faculty</label>
        <input type="text" name="faculty" value="Faculty of Computing" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300 bg-gray-100 cursor-not-allowed" readonly>
    </div>
    
    <!-- Current Semester -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Current Semester</label>
        <input type="text" name="current_semester" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter your current semester">
    </div>
    
    <!-- Field of Study -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Field of Study</label>
        <input type="text" name="field_of_study" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter your field of study">
    </div>
    
    <!-- Expected Graduation -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Expected Graduation</label>
        <input type="month" name="expected_graduation" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300">
    </div>
    
    <!-- Program -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Program</label>
        <input type="text" name="program" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter your program">
    </div>
    
    <!-- Current Result (CGPA) -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Current Result (CGPA)</label>
        <input type="number" step="0.01" name="cgpa" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter your CGPA">
    </div>
    
    <!-- Co-Curriculum -->
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Co-Curriculum</label>
        <textarea name="co_curriculum" class="mt-2 form-textarea block w-full rounded-md shadow-sm border-gray-300" rows="3" placeholder="Describe your co-curricular activities"></textarea>
    </div>
    
    <!-- Achievements (Academic & Co-curriculum) -->
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Achievements (Academic & Co-curriculum)</label>
        <textarea name="achievements" class="mt-2 form-textarea block w-full rounded-md shadow-sm border-gray-300" rows="3" placeholder="List your achievements"></textarea>
    </div>
    
    <!-- Special Skills / Soft Skills -->
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Special Skills / Soft Skills</label>
        <textarea name="special_skills" class="mt-2 form-textarea block w-full rounded-md shadow-sm border-gray-300" rows="3" placeholder="Describe your special or soft skills"></textarea>
    </div>
</div>
