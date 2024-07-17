<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Programs') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-12">
        @if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isProgramCoordinator() || auth()->user()->isStaff()))
            <!-- Tabs for Admin and Program Coordinator -->
            <div class="tabs mb-8 flex justify-center border-b-2 border-gray-200">
                <button class="tab-button active" onclick="showTab('view', this)">View</button>
                <button class="tab-button" onclick="showTab('manage', this)">Manage</button>
            </div>
            <div id="view-tab" class="tab-content">
                @include('mobility-programs.index-partials.view')
            </div>
            <div id="manage-tab" class="tab-content hidden">
                @include('mobility-programs.index-partials.manage')
            </div>
        @else
            <!-- Normal user view -->
            @include('mobility-programs.index-partials.view')
        @endif
    </div>

    <script>
        function showTab(tab, element) {
            document.getElementById('view-tab').classList.add('hidden');
            document.getElementById('manage-tab').classList.add('hidden');
            document.getElementById(tab + '-tab').classList.remove('hidden');

            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(button => button.classList.remove('active'));
            element.classList.add('active');
        }
    </script>

    <style>
        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #e5e7eb; /* Tailwind gray-200 */
        }
        .tab-button {
            background-color: transparent;
            color: #4b5563; /* Tailwind gray-700 */
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-bottom: 2px solid transparent;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }
        .tab-button:hover {
            color: #2563eb; /* Tailwind indigo-600 */
            border-bottom: 2px solid #2563eb; /* Tailwind indigo-600 */
        }
        .tab-button.active {
            color: #2563eb; /* Tailwind indigo-600 */
            border-bottom: 2px solid #2563eb; /* Tailwind indigo-600 */
        }
        .tab-content.hidden {
            display: none;
        }
    </style>
</x-app-layout>
