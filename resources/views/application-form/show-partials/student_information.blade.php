<div>
    <h3 class="text-lg leading-6 font-medium text-gray-900">Student Information</h3>
    <table class="w-full text-sm">
        <tbody>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-200 w-60">Name:</td>
                <td class="px-4 py-2">{{ $applicationForm->user->name ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-200">Matric Number:</td>
                <td class="px-4 py-2">{{ $applicationForm->user->matric_number ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-200">Upcoming Semester:</td>
                <td class="px-4 py-2">{{ Auth::user()->getCurrentSemester() }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-200">Program Type:</td>
                <td class="px-4 py-2">{{ $details->program_type ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-200">Religion:</td>
                <td class="px-4 py-2">{{ $details->religion ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-200">Citizenship:</td>
                <td class="px-4 py-2">{{ $details->citizenship ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-200">IC/Passport Number:</td>
                <td class="px-4 py-2">{{ $details->ic_passport_number ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-200">Contact Number:</td>
                <td class="px-4 py-2">{{ $details->contact_number ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-200">Race:</td>
                <td class="px-4 py-2">{{ $details->race ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-200">Home Address:</td>
                <td class="px-4 py-2">{{ $details->home_address ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-200">Next of Kin:</td>
                <td class="px-4 py-2">{{ $details->next_of_kin ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-200">Emergency Contact:</td>
                <td class="px-4 py-2">{{ $details->emergency_contact ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-200">Parents Occupation:</td>
                <td class="px-4 py-2">{{ $details->parents_occupation ?? 'N/A' }}</td>
            </tr>
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 font-medium bg-gray-200">Parents Monthly Income:</td>
                <td class="px-4 py-2">{{ $details->parents_monthly_income ?? 'N/A' }}</td>
            </tr>
        </tbody>
    </table>
</div>
