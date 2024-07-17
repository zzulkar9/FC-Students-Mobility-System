<div class="text-gray-900 space-y-8">

    <!-- Student Information and Education & Co-Curriculum Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <section class="space-y-4 border border-gray-400 p-4 rounded-lg">
            <h3 class="text-xl font-semibold border-b border-gray-400 pb-2">Student Information</h3>
            <div class="space-y-2 text-sm">
                @include('application-form.show-partials.student_information', [
                    'details' => $applicationForm->applicantDetails,
                ])
            </div>
        </section>

        <section class="space-y-4 border border-gray-400 p-4 rounded-lg">
            <h3 class="text-xl font-semibold border-b border-gray-400 pb-2">Education & Co-Curriculum</h3>
            <div class="space-y-2 text-sm">
                @include('application-form.show-partials.show_curriculum', [
                    'educations' => $applicationForm->educationDetails,
                ])
            </div>
        </section>
    </div>

    <!-- Courses Section -->
    <section class="space-y-4 border border-gray-400 p-4 rounded-lg">
        <h3 class="text-xl font-semibold border-b border-gray-400 pb-2">Courses</h3>
        <div class="space-y-2 text-sm">
            @include('application-form.show-partials.courses_table', [
                'subjects' => $applicationForm->subjects,
            ])
        </div>
    </section>

    <!-- Financial Details and Approval Details Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <section class="space-y-4 border border-gray-400 p-4 rounded-lg">
            <h3 class="text-xl font-semibold border-b border-gray-400 pb-2">Financial Details</h3>
            <div class="space-y-2 text-sm">
                @include('application-form.show-partials.financial_details', [
                    'financial' => $applicationForm->financialDetails,
                ])
            </div>
        </section>

        <section class="space-y-4 border border-gray-400 p-4 rounded-lg">
            <h3 class="text-xl font-semibold border-b border-gray-400 pb-2">Approval Details</h3>
            <div class="space-y-2 text-sm">
                @include('application-form.show-partials.approval_details', [
                    'approval' => $applicationForm->supportApprovalDetails,
                ])
            </div>
        </section>
    </div>

    <!-- Calculated Credits Section -->
    <section class="space-y-4 border border-gray-400 p-4 rounded-lg">
        <h3 class="text-xl font-semibold border-b border-gray-400 pb-2">Calculated Credits</h3>
        <div class="space-y-2 text-sm">
            @include('application-form.show-partials.calculated_credits', [
                'subjects' => $applicationForm->subjects,
            ])
        </div>
    </section>

</div>
