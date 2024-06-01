<form action="{{ route('credits.update', $applicationForm->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">UTM Course</th>
                    <th class="px-4 py-2 text-left">Target Course</th>
                    <th class="px-4 py-2 text-left">Target Course Credits (ECTS)</th>
                    <th class="px-4 py-2 text-left">Equivalent UTM Credits</th>
                    <th class="px-4 py-2 text-left">Details</th>
                    <th class="px-4 py-2 text-left">Remarks</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($applicationForm->subjects as $subject)
                    @php
                        $targetCredits = $subject->target_course_credit;
                        $creditCalculation = $subject->creditCalculations;
                        $equivalentCredits = $creditCalculation ? number_format($creditCalculation->equivalent_utm_credits, 3) : 'N/A';
                        $coefficient = 60 / 32.75; // 60 credits per year in Europe / 32.75 credits per year in Malaysia
                        $utmCredits = $subject->utm_course_credit; // Assuming you have this field in your data
                        $ectsEquivalent = number_format($utmCredits * $coefficient, 3);
                        $hoursUTM = $utmCredits * 40; // Assuming 40 hours per credit
                        $hoursTarget = $targetCredits / $coefficient * 40;
                    @endphp
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2">{{ $subject->utm_course_code }} - {{ $subject->utm_course_name }}</td>
                        <td class="px-4 py-2">{{ $subject->target_course }}</td>
                        <td class="px-4 py-2">{{ $targetCredits }}</td>
                        <td class="px-4 py-2">{{ $equivalentCredits }}</td>
                        <td class="px-4 py-2">
                            <details>
                                <summary>Show Details</summary>
                                <div class="mt-2 text-gray-700 text-sm">
                                    <p><strong>Conversion Coefficient:</strong> {{ number_format($coefficient, 3) }}</p>
                                    <p><strong>UTM Credits to ECTS:</strong> {{ $utmCredits }} x {{ number_format($coefficient, 3) }} = {{ $ectsEquivalent }} ECTS</p>
                                    <p><strong>Hours for UTM Credits:</strong> {{ $utmCredits }} x 40 = {{ $hoursUTM }} hours</p>
                                    <p><strong>Equivalent UTM Credits:</strong> {{ $targetCredits }} / {{ number_format($coefficient, 3) }} = {{ $equivalentCredits }}</p>
                                    <p><strong>Hours for Target Credits:</strong> {{ $targetCredits }} / {{ number_format($coefficient, 3) }} x 40 = {{ number_format($hoursTarget, 2) }} hours</p>
                                </div>
                            </details>
                        </td>
                        <td class="px-4 py-2">
                            @if (auth()->user()->isProgramCoordinator())
                                <textarea name="credit_calculations[{{ $creditCalculation->id }}][remarks]" class="w-full rounded-md border-gray-300 shadow-sm">{{ $creditCalculation->remarks ?? '' }}</textarea>
                            @else
                                {{ $creditCalculation->remarks ?? '' }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if (auth()->user()->isProgramCoordinator())
        <div class="mt-4 flex justify-center">
            <label class="mr-4">Approval Status:</label>
            <div class="mr-4">
                <input type="radio" id="approved" name="approval_status" value="approved" {{ $applicationForm->approval_status ? 'checked' : '' }}>
                <label for="approved">Approved</label>
            </div>
            <div class="mr-4">
                <input type="radio" id="disapproved" name="approval_status" value="disapproved" {{ !$applicationForm->approval_status ? 'checked' : '' }}>
                <label for="disapproved">Disapproved</label>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Save Remarks
            </button>
        </div>
    @endif
</form>


@if (auth()->user()->isUtmStudent())
    <div class="mt-6">
        <h3 class="text-2xl font-semibold text-gray-900 mb-4">Approval Status</h3>
        <p class="text-lg font-semibold" style="color: {{ $applicationForm->approval_status ? 'green' : 'red' }}">
            {{ $applicationForm->approval_status ? 'Approved' : 'Disapproved' }}
        </p>
    </div>
@endif

