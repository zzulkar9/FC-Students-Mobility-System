<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- User Type Selection -->
        <div class="mt-4">
            <x-input-label for="user_type" :value="__('User Type')" />
        
            <select name="user_type" id="user_type" class="block mt-1 w-full" required>
                <option value="">Please select a user type</option>
                <option value="utm_student">UTM Student</option>
                <option value="other_uni_student">Other University Student</option>
            </select>
        </div>

        <!-- Matric Number (conditionally displayed) -->
        <div id="matricNumberField" style="display: none;" class="mt-4">
            <x-input-label for="matric_number" :value="__('Matric Number')" />
            <x-text-input id="matric_number" class="block mt-1 w-full" type="text" name="matric_number" :value="old('matric_number')" />
        </div>

        <!-- Intake Period (conditionally displayed) -->
        <div id="intakePeriodField" style="display: none;" class="mt-4">
            <x-input-label for="intake_period" :value="__('Intake Period')" /> <!-- Corrected to x-input-label -->
            <select name="intake_period" id="intake_period" class="block mt-1 w-full">
                <option value="">Please select an intake period</option>
                <option value="March/April">March/April</option>
                <option value="September">September</option>
            </select>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.getElementById('user_type').addEventListener('change', function() {
            let userType = this.value;
            let matricNumberField = document.getElementById('matricNumberField');
            let intakePeriodField = document.getElementById('intakePeriodField');

            if (userType === 'utm_student') {
                matricNumberField.style.display = 'block';
                intakePeriodField.style.display = 'block';
            } else {
                matricNumberField.style.display = 'none';
                intakePeriodField.style.display = 'none';
            }
        });
    </script>
</x-guest-layout>
