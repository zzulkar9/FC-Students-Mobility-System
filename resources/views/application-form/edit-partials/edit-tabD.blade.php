<div>
    <h3 class="text-lg leading-6 font-medium text-gray-900">Financial Details</h3>
    <div class="mt-2">
        <label class="block text-sm font-medium text-gray-700">How would you intend to finance your program?</label>
        <div class="mt-1">
            <label class="inline-flex items-center mr-6">
                <input type="radio" name="finance_method" value="self_sponsored" class="form-radio" {{ $financial->finance_method == 'self_sponsored' ? 'checked' : '' }}>
                <span class="ml-2">Self-sponsored</span>
            </label>
            <label class="inline-flex items-center mr-6">
                <input type="radio" name="finance_method" value="home_institution" class="form-radio" {{ $financial->finance_method == 'home_institution' ? 'checked' : '' }}>
                <span class="ml-2">Home Institution Sponsor</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="finance_method" value="other_sponsor" class="form-radio" {{ $financial->finance_method == 'other_sponsor' ? 'checked' : '' }}>
                <span class="ml-2">Other Sponsor</span>
            </label>
        </div>
    </div>

    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">If your exchange/internship is under the sponsorship/financial aid of certain bodies, please specify:</label>
        <input type="text" name="sponsorship_details" class="form-input mt-1 block w-full" placeholder="Details of sponsorships" value="{{ $financial->sponsorship_details ?? 'N/A' }}">
    </div>

    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Provide an estimated budget for your study period:</label>
        <textarea name="budget_details" class="form-textarea mt-1 block w-full" rows="4" placeholder="Detail your expected expenses">{{ $financial->budget_details ?? 'N/A' }}</textarea>
    </div>
</div>