<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Advertise New Mobility Program') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-300">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('mobility-programs.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" id="title" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Image Poster</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md file-upload">
                                <div class="space-y-1 text-center file-upload-label">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M48 32v14H0V0h32v8h16v24z" fill="#D8D8D8" />
                                        <path d="M48 32l-6.933 6.933L32 32M4 36v4h40v-4M32 8v24" stroke="#979797" stroke-width="2" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="image" name="image" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>
                            <div id="file-info" class="mt-2 text-sm text-gray-600"></div>
                            <button id="remove-file" type="button" class="hidden mt-2 bg-red-500 text-white py-1 px-2 rounded">Remove File</button>
                            @error('image')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                            <input type="date" id="due_date" name="due_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('due_date') }}">
                            @error('due_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="extra_info" class="block text-sm font-medium text-gray-700">Extra Information</label>
                            <textarea id="extra_info" name="extra_info" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('extra_info') }}</textarea>
                            @error('extra_info')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="link" class="block text-sm font-medium text-gray-700">Link</label>
                            <input type="url" id="link" name="link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('link') }}">
                            @error('link')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center justify-center mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Advertisement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .file-upload {
            position: relative;
            width: 100%;
            height: 200px;
            border: 2px dashed #d2d6dc;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.3s;
        }

        .file-upload:hover {
            border-color: #9fa6b2;
        }

        .file-upload input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-label {
            text-align: center;
            color: #6b7280;
            font-size: 1rem;
        }

        .file-upload-label svg {
            width: 3rem;
            height: 3rem;
            margin-bottom: 0.5rem;
            color: #9fa6b2;
        }

        .file-upload-label p {
            margin: 0;
        }

        .file-upload-label span {
            color: #4a5568;
            font-weight: 600;
        }

        .file-upload input[type="file"]:focus + .file-upload-label {
            outline: 2px solid #3b82f6;
            outline-offset: -4px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropArea = document.querySelector('.file-upload');
            const fileInput = document.getElementById('image');
            const fileInfo = document.getElementById('file-info');
            const removeFileButton = document.getElementById('remove-file');

            dropArea.addEventListener('click', () => {
                fileInput.click();
            });

            fileInput.addEventListener('change', () => {
                if (fileInput.files.length > 0) {
                    fileInfo.textContent = `Selected file: ${fileInput.files[0].name}`;
                    removeFileButton.classList.remove('hidden');
                } else {
                    fileInfo.textContent = '';
                    removeFileButton.classList.add('hidden');
                }
            });

            dropArea.addEventListener('dragover', (event) => {
                event.preventDefault();
                dropArea.classList.add('bg-gray-200');
            });

            dropArea.addEventListener('dragleave', () => {
                dropArea.classList.remove('bg-gray-200');
            });

            dropArea.addEventListener('drop', (event) => {
                event.preventDefault();
                const files = event.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    fileInfo.textContent = `Selected file: ${files[0].name}`;
                    removeFileButton.classList.remove('hidden');
                }
                dropArea.classList.remove('bg-gray-200');
            });

            removeFileButton.addEventListener('click', () => {
                fileInput.value = '';
                fileInfo.textContent = '';
                removeFileButton.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>
