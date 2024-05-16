<!-- Content for Tab A -->
<div>
    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Applicant Details</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Program Type -->
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700">Program Type</label>
            <div class="mt-2 flex items-center space-x-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="program_type" value="study_abroad" class="form-radio text-indigo-600">
                    <span class="ml-2">Study Abroad/Student Exchange</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="program_type" value="internship" class="form-radio text-indigo-600">
                    <span class="ml-2">Internship / Research Attachment / Scientific Visit</span>
                </label>
            </div>
        </div>
        
        <!-- Name -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <div class="mt-2 p-2 border rounded-md bg-gray-100">{{ Auth::user()->name }}</div>
        </div>
        
        <!-- Matric Number -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Matric Number</label>
            <div class="mt-2 p-2 border rounded-md bg-gray-100">{{ Auth::user()->matric_number }}</div>
        </div>
        
        <!-- Upcoming Semester -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Upcoming Semester</label>
            <div class="mt-2 p-2 border rounded-md bg-gray-100">{{ Auth::user()->getCurrentSemester() }}</div>
        </div>
        
        <!-- Religion -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Religion</label>
            <input type="text" name="religion" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter religion">
        </div>
        
        <!-- Citizenship -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Citizenship</label>
            <input type="text" name="citizenship" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter citizenship">
        </div>
        
        <!-- IC/Passport Number -->
        <div>
            <label class="block text-sm font-medium text-gray-700">IC/Passport Number</label>
            <input type="text" name="ic_passport_number" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter IC/Passport number">
        </div>
        
        <!-- Contact Number -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
            <input type="tel" name="contact_number" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter contact number">
        </div>
        
        <!-- Race -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Race</label>
            <input type="text" name="race" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter race">
        </div>
        
        <!-- Home Address -->
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700">Home Address</label>
            <textarea name="home_address" class="mt-2 form-textarea block w-full rounded-md shadow-sm border-gray-300" rows="3" placeholder="Enter home address"></textarea>
        </div>
        
        <!-- Next of Kin -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Next of Kin</label>
            <input type="text" name="next_of_kin" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter next of kin name">
        </div>
        
        <!-- Emergency Contact -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Emergency Contact</label>
            <input type="tel" name="emergency_contact" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter emergency contact number">
        </div>
        
        <!-- Parents Occupation -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Parents Occupation</label>
            <input type="text" name="parents_occupation" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter parents occupation">
        </div>
        
        <!-- Parents Monthly Income -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Parents Monthly Income</label>
            <input type="text" name="parents_monthly_income" class="mt-2 form-input block w-full rounded-md shadow-sm border-gray-300" placeholder="Enter parents monthly income">
        </div>
    </div>
</div>
