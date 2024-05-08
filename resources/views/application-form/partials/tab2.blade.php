<!-- Content for Tab 1 -->
<div>
    <h3 class="text-lg leading-6 font-medium text-gray-900">Applicant Details</h3>
                        <table class="w-full text-sm mt-4">
                            <tbody>
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 font-medium bg-gray-200 w-60">Name:</td>
                                    <td class="px-4 py-2">{{ Auth::user()->name }}</td>
                                </tr>
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 font-medium bg-gray-200">Matric Number:</td>
                                    <td class="px-4 py-2">{{ Auth::user()->matric_number }}</td>
                                </tr>
                                @if (Auth::user()->isUtmStudent())
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Upcoming Semester:</td>
                                        <td class="px-4 py-2">{{ Auth::user()->getCurrentSemester() }}</td>
                                    </tr>
                                @endif
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 font-medium bg-gray-200">Intake:</td>
                                    <td class="px-4 py-2">{{ Auth::user()->intake_period }}</td>
                                </tr>
                                @if (isset($applicationForm) && $applicationForm->link)
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 font-medium bg-gray-200">Link:</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ $applicationForm->link }}" target="_blank" class="text-blue-500 hover:text-blue-700">{{ $applicationForm->link }}</a>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
</div>
