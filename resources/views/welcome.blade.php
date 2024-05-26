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
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .grid-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .grid-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
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
            background-color: rgba(0, 0, 0, 0.6);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 700px;
            border-radius: 0.75rem;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
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
            background-color: #f1f6fd;
        }

        .box-shadow {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .four-box-section img {
            object-fit: contain;
        }
    </style>
</head>

<body class="font-sans antialiased background">
    <div class="relative flex flex-col items-center min-h-screen sm:pt-0">
        <div class="w-full bg-white shadow-md fixed top-0 left-0 right-0 z-50">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="text-xl font-semibold text-gray-900">FC Mobility Student System</div>
                @if (Route::has('login'))
                    <div class="flex space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-900 hover:text-gray-700">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-900 hover:text-gray-700">Log in</a>
                            <a> | </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm font-semibold text-gray-900 hover:text-gray-700">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>

        <div class="w-full bg-white shadow-lg">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-24">
                <!-- Full Width Banner -->
                <div class="w-full mb-8">
                    <img src="{{ asset('images/test2.gif') }}" alt="Banner"
                        class="w-full h-96 object-cover rounded-lg shadow-lg">
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-20 flex-1">
            <!-- Section under the banner -->
            <div class="flex flex-wrap items-start">
                <!-- Left Text -->
                <div class="w-full md:w-1/4 mb-6 md:mb-0">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Mobility System</h2>
                    <p class="text-gray-700">Manage and explore mobility programs seamlessly. Our system provides a
                        comprehensive platform for students and staff.</p>
                </div>
                <!-- Right Boxes -->
                <div class="w-full md:w-3/4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 four-box-section">
                    <!-- Box 1 -->
                    <div class="flex items-center bg-white rounded-lg shadow-md p-6">
                        <img src="{{ asset('images/box-1.jpg') }}" alt="Placeholder Image 1"
                            class="w-16 h-16 object-cover rounded-full mr-6">
                        <div class="flex flex-col">
                            <h3 class="text-xl font-semibold text-gray-900">Website</h3>
                            <p class="text-gray-700">international.utm.my</p>
                        </div>
                    </div>
                    <!-- Box 2 -->
                    <div class="flex items-center bg-white rounded-lg shadow-md p-6">
                        <img src="{{ asset('images/box-2.png') }}" alt="Placeholder Image 2"
                            class="w-16 h-16 object-cover rounded-full mr-6">
                        <div class="flex flex-col">
                            <h3 class="text-xl font-semibold text-gray-900">Student Helpdesk</h3>
                            <p class="text-gray-700">#</p>
                        </div>
                    </div>
                    <!-- Box 3 -->
                    <div class="flex items-center bg-white rounded-lg shadow-md p-6">
                        <img src="{{ asset('images/box-3.png') }}" alt="Placeholder Image 3"
                            class="w-16 h-16 object-cover rounded-full mr-6">
                        <div class="flex flex-col">
                            <h3 class="text-xl font-semibold text-gray-900">Lecturer Helpdesk</h3>
                            <p class="text-gray-700">#</p>
                        </div>
                    </div>
                    <!-- Box 4 -->
                    <div class="flex items-center bg-white rounded-lg shadow-md p-6">
                        <img src="{{ asset('images/box-4.png') }}" alt="Placeholder Image 4"
                            class="w-16 h-16 object-cover rounded-full mr-6">
                        <div class="flex flex-col">
                            <h3 class="text-xl font-semibold text-gray-900">Email</h3>
                            <p class="text-gray-700">#</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-20">
                <h1 class="text-4xl font-bold text-gray-900 px-4 py-2 rounded">Mobility Programs</h1>
                <!-- Add More Button -->
                @if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isProgramCoordinator()))
                    <a href="{{ route('mobility-programs.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg transition duration-200">Add
                        More</a>
                @endif
            </div>

            <div class="mt-8 bg-white bg-opacity-50 overflow-hidden shadow sm:rounded-lg shadow-md">
                <div class="grid-container p-6 bg-white shadow-md">
                    @foreach ($programs as $program)
                        <div class="grid-item shadow-lg">
                            <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}">
                            <div class="details p-4 text-center">
                                <h3 class="title">{{ $program->title }}</h3>
                                <p class="date">{{ \Carbon\Carbon::parse($program->due_date)->format('F j, Y') }}</p>
                                <div class="links">
                                    <a href="javascript:void(0);" onclick="openModal('{{ $program->id }}')"
                                        class="text-blue-500 hover:text-blue-700">Quick View</a>
                                    <a href="{{ route('mobility-programs.show', $program->id) }}"
                                        class="text-blue-500 hover:text-blue-700">Full Details &rarr;</a>
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
                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}"
                    class="w-full rounded-md mb-4">
                <h2 class="text-2xl font-semibold mb-2">{{ $program->title }}</h2>
                <p class="text-gray-700 mb-2">{{ $program->description }}</p>
                <p class="text-gray-700 mb-2"><strong>Due Date:</strong>
                    {{ \Carbon\Carbon::parse($program->due_date)->format('F j, Y') }}</p>
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
