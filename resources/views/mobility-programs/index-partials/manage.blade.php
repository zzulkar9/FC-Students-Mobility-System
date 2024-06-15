<!-- resources/views/programs/manage.blade.php -->

<div class="flex justify-between items-center pb-8">
    <h1 class="text-4xl font-bold text-gray-900">Manage Mobility Programs</h1>
</div>

<div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-300">
    <div class="p-6">
        <div class="mb-4">
            <a href="{{ route('mobility-programs.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200 mt-2 inline-block">
                Add New Program
            </a>
        </div>
        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="w-1/3 px-4 py-3 text-left text-sm font-medium border-b border-gray-300">Title</th>
                    <th class="w-1/4 px-4 py-3 text-left text-sm font-medium border-b border-gray-300">Due Date</th>
                    <th class="w-1/4 px-4 py-3 text-left text-sm font-medium border-b border-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($programs as $program)
                    <tr class="border-t border-gray-300">
                        <td class="px-4 py-3 text-sm border-b border-gray-300">{{ $program->title }}</td>
                        <td class="px-4 py-3 text-sm border-b border-gray-300">{{ \Carbon\Carbon::parse($program->due_date)->format('F j, Y') }}</td>
                        <td class="px-4 py-3 text-sm border-b border-gray-300">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('mobility-programs.show', $program->id) }}"
                                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded transition duration-200">View</a>
                                <a href="{{ route('mobility-programs.edit', $program->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded transition duration-200">Edit</a>
                                <form action="{{ route('mobility-programs.destroy', $program->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this program?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded transition duration-200">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Add custom styles to enhance the look and feel of the table and buttons */
    .table-container {
        background: linear-gradient(to bottom, #f8fafc, #fff);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .table th, .table td {
        padding: 12px 15px;
        text-align: left;
    }
    .table th {
        background-color: #e2e8f0;
        color: #2d3748;
        font-weight: bold;
        font-size: 0.875rem;
        text-transform: uppercase;
    }
    .table td {
        border-bottom: 1px solid #e2e8f0;
    }
    .table tr:hover {
        background-color: #f1f5f9;
    }
    .action-button {
        display: inline-block;
        margin-right: 5px;
        padding: 8px 12px;
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 5px;
        text-transform: uppercase;
        text-align: center;
        transition: all 0.2s;
    }
    .action-button.view {
        background-color: #38a169;
        color: white;
    }
    .action-button.edit {
        background-color: #d69e2e;
        color: white;
    }
    .action-button.delete {
        background-color: #e53e3e;
        color: white;
    }
    .action-button:hover {
        opacity: 0.9;
    }
</style>
