<!-- Calculated Credits Tab Content -->
<div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">UTM Course</th>
                <th class="px-4 py-2 text-left">Target Course</th>
                <th class="px-4 py-2 text-left">Target Course Credits (ECTS)</th>
                <th class="px-4 py-2 text-left">Equivalent UTM Credits</th>
                <th class="px-4 py-2 text-left">Details</th>
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
                    <td class="px-4 py-2">{{ $subject->utm_course_code }} - {{ $subject->utm_course_name }} ({{ $utmCredits }} UTM Credits)</td>
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
                </tr>
            @endforeach
        </tbody>
    </table>
</div>