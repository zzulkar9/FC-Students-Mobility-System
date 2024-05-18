<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .grid-item {
            overflow: hidden;
            cursor: pointer;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: transform 0.3s ease;
        }

        .grid-item:hover {
            transform: scale(1.05);
        }

        .grid-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .grid-item .details {
            padding: 1rem;
        }

        .grid-item .title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
        }

        .grid-item .date {
            font-size: 0.875rem;
            color: #666;
            margin-top: 0.5rem;
        }

        .grid-item .links {
            margin-top: 1rem;
        }

        .grid-item .links a {
            margin-right: 0.5rem;
            transition: color 0.3s ease;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 700px;
            border-radius: 0.5rem;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

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
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <h1 class="text-4xl font-bold text-white px-4 py-2 rounded">Mobility Programs</h1>
            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 bg-opacity-50 overflow-hidden shadow sm:rounded-lg">
                <div class="grid-container p-6">
                    @foreach ($programs as $program)
                        <div class="grid-item">
                            <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}">
                            <div class="details p-4 text-center">
                                <h3 class="title">{{ $program->title }}</h3>
                                <p class="date">{{ \Carbon\Carbon::parse($program->due_date)->format('F j, Y') }}</p>
                                <div class="links">
                                    <a href="javascript:void(0);" onclick="openModal('{{ $program->id }}')" class="text-blue-500 hover:text-blue-700">Quick View</a>
                                    <a href="{{ route('mobility-programs.show', $program->id) }}" class="text-blue-500 hover:text-blue-700">Full Details &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @foreach ($programs as $program)
        <div id="modal-{{ $program->id }}" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('{{ $program->id }}')">&times;</span>
                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full rounded-md mb-4">
                <h2 class="text-2xl font-semibold mb-2">{{ $program->title }}</h2>
                <p class="text-gray-700 mb-2">{{ $program->description }}</p>
                <p class="text-gray-700 mb-2"><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($program->due_date)->format('F j, Y') }}</p>
                <p class="text-gray-700">{{ $program->extra_info }}</p>
            </div>
        </div>
    @endforeach

    <script>
        function openModal(id) {
            document.getElementById('modal-' + id).style.display = 'block';
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).style.display = 'none';
        }
    </script>
</body>

</html>
