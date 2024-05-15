<!-- Content for Tab A -->
<h3 class="text-lg leading-6 font-medium text-gray-900">Applicant Details</h3>
<table class="w-full text-sm mt-4">
    <tbody>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 font-medium bg-gray-200">Program Type:</td>
            <td class="px-4 py-2">
                <div class="flex items-center">
                    <label class="inline-flex items-center mr-6">
                        <input type="radio" name="program_type" value="study_abroad" class="form-radio">
                        <span class="ml-2">Study Abroad/Student Exchange</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="program_type" value="internship" class="form-radio">
                        <span class="ml-2">Internship / Research Attachment / Scientific Visit</span>
                    </label>
                </div>
            </td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 font-medium bg-gray-200 w-60">Name:</td>
            <td class="px-4 py-2">{{ Auth::user()->name }}</td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 font-medium bg-gray-200">Matric Number:</td>
            <td class="px-4 py-2">{{ Auth::user()->matric_number }}</td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 font-medium bg-gray-200">Upcoming Semester:</td>
            <td class="px-4 py-2">{{ Auth::user()->getCurrentSemester() }}</td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 font-medium bg-gray-200">Religion:</td>
            <td class="px-4 py-2">
                <input type="text" name="religion" class="form-input mt-1 block w-full" placeholder="Enter religion">
            </td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 font-medium bg-gray-200">Citizenship:</td>
            <td class="px-4 py-2">
                <input type="text" name="citizenship" class="form-input mt-1 block w-full" placeholder="Enter citizenship">
            </td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 font-medium bg-gray-200">IC/Passport Number:</td>
            <td class="px-4 py-2">
                <input type="text" name="ic_passport_number" class="form-input mt-1 block w-full" placeholder="Enter IC/Passport number">
            </td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 font-medium bg-gray-200">Contact Number:</td>
            <td class="px-4 py-2">
                <input type="tel" name="contact_number" class="form-input mt-1 block w-full" placeholder="Enter contact number">
            </td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 font-medium bg-gray-200">Race:</td>
            <td class="px-4 py-2">
                <input type="text" name="race" class="form-input mt-1 block w-full" placeholder="Enter race">
            </td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 font-medium bg-gray-200">Home Address:</td>
            <td class="px-4 py-2">
                <textarea name="home_address" class="form-textarea mt-1 block w-full" rows="3" placeholder="Enter home address"></textarea>
            </td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 font-medium bg-gray-200">Next of Kin:</td>
            <td class="px-4 py-2">
                <input type="text" name="next_of_kin" class="form-input mt-1 block w-full" placeholder="Enter next of kin name">
            </td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 font-medium bg-gray-200">Emergency Contact:</td>
            <td class="px-4 py-2">
                <input type="tel" name="emergency_contact" class="form-input mt-1 block w-full" placeholder="Enter emergency contact number">
            </td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 font-medium bg-gray-200">Parents Occupation:</td>
            <td class="px-4 py-2">
                <input type="text" name="parents_occupation" class="form-input mt-1 block w-full" placeholder="Enter parents occupation">
            </td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 font-medium bg-gray-200">Parents Monthly Income:</td>
            <td class="px-4 py-2">
                <input type="text" name="parents_monthly_income" class="form-input mt-1 block w-full" placeholder="Enter parents monthly income">
            </td>
        </tr>
    </tbody>
</table>
