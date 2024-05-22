<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mobility Program Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .background {
            background: linear-gradient(135deg, #1e1e1e, #3c3c3c, #ff0000);
            background-position: center;
            animation: animate 10s ease-in-out infinite;
            background-size: 400% 400%;
        }

        @keyframes animate {
            0% {
                background-position: 0 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0 50%;
            }
        }
    </style>
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="background relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-white hover:text-gray-300">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-white hover:text-gray-300">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm font-semibold text-white hover:text-gray-300">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-20">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('welcome') }}" class="text-blue-500 hover:text-blue-700">&larr; Go Back</a>
                        @if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isProgramCoordinator()))
                            <a href="{{ route('mobility-programs.edit', $program->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                        @endif
                    </div>
                    <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full rounded-md mb-4 mt-4">
                    <h2 class="text-3xl font-semibold mb-2">{{ $program->title }}</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $program->description }}</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($program->due_date)->format('F j, Y') }}</p>
                    <p class="text-gray-700 dark:text-gray-300">{{ $program->extra_info }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
