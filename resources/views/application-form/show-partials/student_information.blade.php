<div>
    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Student Information</h3>
    <table class="w-full text-sm">
        <tbody>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-100 border-b w-60">Name:</td>
                <td class="px-4 py-2 bg-white border-b">{{ $applicationForm->user->name ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-100 border-b">Matric Number:</td>
                <td class="px-4 py-2 bg-white border-b">{{ $applicationForm->user->matric_number ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-100 border-b">Upcoming Semester:</td>
                <td class="px-4 py-2 bg-white border-b">{{ Auth::user()->getCurrentSemester() }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-100 border-b">Program Type:</td>
                <td class="px-4 py-2 bg-white border-b">{{ $details->program_type ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-100 border-b">Religion:</td>
                <td class="px-4 py-2 bg-white border-b">{{ $details->religion ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-100 border-b">Citizenship:</td>
                <td class="px-4 py-2 bg-white border-b">{{ $details->citizenship ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-100 border-b">IC/Passport Number:</td>
                <td class="px-4 py-2 bg-white border-b">{{ $details->ic_passport_number ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-100 border-b">Contact Number:</td>
                <td class="px-4 py-2 bg-white border-b">{{ $details->contact_number ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-100 border-b">Race:</td>
                <td class="px-4 py-2 bg-white border-b">{{ $details->race ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-100 border-b">Home Address:</td>
                <td class="px-4 py-2 bg-white border-b">{{ $details->home_address ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-100 border-b">Next of Kin:</td>
                <td class="px-4 py-2 bg-white border-b">{{ $details->next_of_kin ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-100 border-b">Emergency Contact:</td>
                <td class="px-4 py-2 bg-white border-b">{{ $details->emergency_contact ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-100 border-b">Parents Occupation:</td>
                <td class="px-4 py-2 bg-white border-b">{{ $details->parents_occupation ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-100">Parents Monthly Income:</td>
                <td class="px-4 py-2 bg-white">{{ $details->parents_monthly_income ?? 'N/A' }}</td>
            </tr>
        </tbody>
    </table>
</div>
