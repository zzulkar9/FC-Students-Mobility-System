<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Unauthorized Access') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <div class="flex justify-center mb-6">
                        <img src="https://via.placeholder.com/400x300.png?text=Unauthorized+Access" alt="Unauthorized Access Graphic" class="w-1/2 h-auto rounded-md shadow-lg">
                    </div>
                    <h1 class="text-2xl font-bold mb-4">Oops! Unauthorized Access</h1>
                    <p class="text-lg mb-4">It seems like you don't have the necessary permissions to access this page.</p>
                    <p class="text-md mb-6">This page is currently under construction or you might not have the required privileges to view its content.</p>
                    <a href="{{ url()->previous() }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Go Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
