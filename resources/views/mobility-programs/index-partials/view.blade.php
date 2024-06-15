<!-- resources/views/programs/view.blade.php -->
<div class="flex justify-between items-center pb-8">
    <h1 class="text-4xl font-bold text-gray-900">Mobility Programs</h1>
</div>
<div class="bg-gray-50 p-6 rounded-lg shadow-lg border border-gray-300">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($programs as $program)
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-200 transform hover:scale-105 cursor-pointer border border-gray-400" onclick="openModal('{{ $program->id }}')">
                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $program->title }}</h3>
                    <p class="text-gray-600">{{ \Carbon\Carbon::parse($program->due_date)->format('F j, Y') }}</p>
                    <p class="text-gray-700 mt-2">{{ Str::limit($program->description, 100) }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <a href="{{ route('mobility-programs.show', $program->id) }}" class="text-blue-500 hover:text-blue-700" onclick="event.stopPropagation();">Full Details &rarr;</a>
                        @if ($program->link)
                            <a href="{{ $program->link }}" target="_blank" class="text-blue-500 hover:text-blue-700" onclick="event.stopPropagation();">
                                Visit Website
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@foreach ($programs as $program)
    <div id="modal-{{ $program->id }}" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50 transition-opacity duration-300">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl max-w-lg w-full transition-transform duration-300 transform scale-95">
            <div class="p-4 flex justify-between items-center border-b border-gray-200">
                <h2 class="text-2xl font-semibold">{{ $program->title }}</h2>
                <span class="cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeModal('{{ $program->id }}')">&times;</span>
            </div>
            <div class="p-4">
                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-48 object-cover rounded-md mb-4">
                <p class="text-gray-700 mb-2">{!! nl2br(e($program->description)) !!}</p>
                <p class="text-gray-700 mb-2"><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($program->due_date)->format('F j, Y') }}</p>
                <p class="text-gray-700">{!! nl2br(e($program->extra_info)) !!}</p>
            </div>
            <div class="p-4 border-t border-gray-200 flex justify-end">
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200" onclick="closeModal('{{ $program->id }}')">Close</button>
            </div>
        </div>
    </div>
@endforeach

<script>
    function openModal(id) {
        const modal = document.getElementById('modal-' + id);
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            modal.querySelector('.transform').classList.remove('scale-95');
            modal.querySelector('.transform').classList.add('scale-100');
        }, 10); // Delay for transition
    }

    function closeModal(id) {
        const modal = document.getElementById('modal-' + id);
        modal.classList.add('opacity-0');
        modal.querySelector('.transform').classList.remove('scale-100');
        modal.querySelector('.transform').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // Duration of the transition
    }
</script>
