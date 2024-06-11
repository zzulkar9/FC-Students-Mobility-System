
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- <form method="POST" action="{{ route('inbound-students.store') }}"> --}}
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Student Name</label>
                            <input type="text" name="name" id="name" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                            <input type="text" name="country" id="country" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                            <select name="semester" id="semester" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="March/April">March/April</option>
                                <option value="September">September</option>
                            </select>
                        </div>
                        {{-- <div class="flex items-center justify-center mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save Student Info
                            </button>
                        </div> --}}
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>

