<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-center">Add New User</h1>
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required
                            autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required
                            autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- User Type Selection -->
                    <div class="mt-4">
                        <x-input-label for="user_type" :value="__('User Type')" />
                        <select name="user_type" id="user_type" class="block mt-1 w-full">
                            <option value="">Please select a user type</option>
                            <option value="utm_student">UTM Student</option>
                            <option value="other_uni_student">Other University Student</option>
                            <option value="Admin">Admin</option>
                            <option value="TDA">TDA</option>
                            <option value="program_coordinator">Program Coordinator</option>
                            <option value="UTM Staff">UTM Staff</option>
                        </select>
                    </div>

                    <!-- Additional fields like Matric Number and Intake Period here -->

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Add User') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    document.getElementById('user_type').addEventListener('change', function() {
        let userType = this.value;
        let matricNumberField = document.getElementById('matric_number').parentNode;
        let intakePeriodField = document.getElementById('intake_period').parentNode;

        if (userType === 'utm_student') {
            matricNumberField.style.display = 'block';
            intakePeriodField.style.display = 'block';
        } else {
            matricNumberField.style.display = 'none';
            intakePeriodField.style.display = 'none';
        }
    });
</script>
