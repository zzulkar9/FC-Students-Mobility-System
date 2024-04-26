<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-5">
                <h1 class="text-2xl font-semibold mb-6 text-center">User Registration Form</h1>
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <!-- Grid Layout for form inputs -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                            <input id="name" type="text" name="name" required class="rounded-md shadow-sm border-gray-300 mt-1 block w-full" />
                            @error('name')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                            <input id="email" type="email" name="email" required class="rounded-md shadow-sm border-gray-300 mt-1 block w-full" />
                            @error('email')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                            <input id="password" type="password" name="password" required class="rounded-md shadow-sm border-gray-300 mt-1 block w-full" />
                            @error('password')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required class="rounded-md shadow-sm border-gray-300 mt-1 block w-full" />
                            @error('password_confirmation')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- User Type Selection -->
                        <div>
                            <label for="user_type" class="block font-medium text-sm text-gray-700">User Type</label>
                            <select id="user_type" name="user_type" class="rounded-md shadow-sm border-gray-300 mt-1 block w-full">
                                <option value="">Please select a user type</option>
                                <option value="utm_student">UTM Student</option>
                                <option value="other_uni_student">Other University Student</option>
                                <option value="Admin">Admin</option>
                                <option value="TDA">TDA</option>
                                <option value="program_coordinator">Program Coordinator</option>
                                <option value="UTM Staff">UTM Staff</option>
                            </select>
                        </div>

                        <!-- Matric Number -->
                        <div id="matricNumberField" style="display: none;">
                            <label for="matric_number" class="block font-medium text-sm text-gray-700">Matric Number</label>
                            <input id="matric_number" type="text" name="matric_number" class="rounded-md shadow-sm border-gray-300 mt-1 block w-full" />
                        </div>

                        <!-- Intake Period -->
                        <div id="intakePeriodField" style="display: none;">
                            <label for="intake_period" class="block font-medium text-sm text-gray-700">Intake Period</label>
                            <select id="intake_period" name="intake_period" class="rounded-md shadow-sm border-gray-300 mt-1 block w-full">
                                <option value="">Please select an intake period</option>
                                <option value="March/April">March/April</option>
                                <option value="September">September</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 space-x-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add User
                        </button>
                        <a href="{{ url()->previous() }}" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Go Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
</x-app-layout>
