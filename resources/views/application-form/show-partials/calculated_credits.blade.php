<form action="{{ route('credits.update', $applicationForm->id) }}" method="POST" class="space-y-6">
    @csrf
    @method('PATCH')
    {{-- <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4"> --}}
        <!-- Additional Information Section -->
        {{-- <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 flex flex-col">
            <p><strong>Useful website to convert into ECTS credits if necessary:</strong></p>
            <a href="https://www.germangradecalculator.com/ects-calculator/" class="text-blue-500 underline"
                target="_blank">ECTS Calculator</a>
            <a href="https://www.uts.edu.au/study/international/study-abroad-and-exchange-uts/subjects-and-academic-information"
                class="text-blue-500 underline" target="_blank">UTS International Subjects and Academic Information</a>
        </div> --}}
        <table class="min-w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium" style="width:20%">UTM Course</th>
                    <th class="px-4 py-3 text-left text-sm font-medium" style="width:15%">Target Course</th>
                    <th class="px-4 py-3 text-left text-sm font-medium" style="width:10%">Target Course Credits (ECTS)</th>
                    <th class="px-4 py-3 text-left text-sm font-medium" style="width:10%">Equivalent UTM Credits</th>
                    <th class="px-4 py-3 text-left text-sm font-medium" style="width:30%">Details</th>
                    <th class="px-4 py-3 text-left text-sm font-medium"style="width:15%">Remarks</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($applicationForm->subjects as $subject)
                    @php
                        $targetCredits = $subject->target_course_credit;
                        $creditCalculation = $subject->creditCalculations;
                        $equivalentCredits = $creditCalculation
                            ? number_format($creditCalculation->equivalent_utm_credits, 3)
                            : 'N/A';
                        $coefficient = 60 / 32.75; // 60 credits per year in Europe / 32.75 credits per year in Malaysia
                        $utmCredits = $subject->utm_course_credit; // Assuming you have this field in your data
                        $ectsEquivalent = number_format($utmCredits * $coefficient, 3);
                        $hoursUTM = $utmCredits * 40; // Assuming 40 hours per credit
                        $hoursTarget = ($targetCredits / $coefficient) * 40;
                    @endphp
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 text-sm text-gray-600">{{ $subject->utm_course_code }} -
                            {{ $subject->utm_course_name }} - <b>({{ $utmCredits }} UTM Credits)</b></td>
                        <td class="px-4 py-2 text-sm text-gray-600">{{ $subject->target_course }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600">{{ $targetCredits }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600">{{ $equivalentCredits }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600">
                            <details>
                                <summary class="cursor-pointer text-blue-500 hover:underline">Show Details</summary>
                                <div class="mt-2 text-gray-700">
                                    <p><strong>Conversion Coefficient:</strong> {{ number_format($coefficient, 3) }}</p>
                                    <p><strong>UTM Credits to ECTS:</strong> {{ $utmCredits }} x
                                        {{ number_format($coefficient, 3) }} = {{ $ectsEquivalent }} ECTS</p>
                                    <p><strong>Hours for UTM Credits:</strong> {{ $utmCredits }} x 40 =
                                        {{ $hoursUTM }} hours</p>
                                    <p><strong>Equivalent UTM Credits:</strong> {{ $targetCredits }} /
                                        {{ number_format($coefficient, 3) }} = {{ $equivalentCredits }}</p>
                                    <p><strong>Hours for Target Credits:</strong> {{ $targetCredits }} /
                                        {{ number_format($coefficient, 3) }} x 40 =
                                        {{ number_format($hoursTarget, 2) }} hours</p>
                                </div>
                            </details>
                        </td>
                        <td class="px-4 py-2 text-sm">
                            @if (auth()->user()->isProgramCoordinator() ||  auth()->user()->isTDA())
                                <textarea name="credit_calculations[{{ $creditCalculation->id }}][remarks]"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">{{ $creditCalculation->remarks ?? '' }}</textarea>
                            @else
                                {{ $creditCalculation->remarks ?? '' }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    {{-- </div> --}}

    @if (auth()->user()->isTDA())
        <div class="flex justify-center items-center mt-4">
            <label class="mr-4 text-sm font-medium">Approval Status:</label>
            <div class="mr-4 flex items-center">
                <input type="radio" id="approved" name="approval_status" value="approved"
                    {{ $applicationForm->approval_status ? 'checked' : '' }} class="form-radio text-blue-600">
                <label for="approved" class="ml-2 text-sm font-medium text-gray-700">Approved</label>
            </div>
            <div class="mr-4 flex items-center">
                <input type="radio" id="disapproved" name="approval_status" value="disapproved"
                    {{ !$applicationForm->approval_status ? 'checked' : '' }} class="form-radio text-red-600">
                <label for="disapproved" class="ml-2 text-sm font-medium text-gray-700">Pending</label>
            </div>
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">Save Remarks</button>
        </div>
    @endif
</form>

{{-- @if (auth()->user()->isUtmStudent() || auth()->user()->isProgramCoordinator() || auth()->user()->isAA())
    <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-lg">
        <h3 class="text-2xl font-semibold mb-4">Approval Status</h3>
        <p class="text-lg font-semibold" style="color: {{ $applicationForm->approval_status ? 'green' : 'orange' }}">
            {{ $applicationForm->approval_status ? 'Approved by TDA' : 'Pending from TDA' }}
        </p>
    </div>
@endif --}}
