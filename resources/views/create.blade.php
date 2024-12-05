<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @else
            <div class="bg-red-500 text-white p-4 rounded-md mb-4">
                {{ __('unsuccessful.') }}
            </div>
        @endif
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- Image Input -->
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-bold mb-2">
                    {{ __('Upload Image') }}
                </label>
                <input type="file" name="image" id="image" class="border-gray-300 focus:ring focus:ring-indigo-200 rounded-md shadow-sm w-full">
            </div>
        
            <!-- Description Input -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">
                    {{ __('Description') }}
                </label>
                <textarea name="description" id="description" rows="4" class="border-gray-300 focus:ring focus:ring-indigo-200 rounded-md shadow-sm w-full"></textarea>
            </div>
        
            <!-- Submit Button -->
            <div>
                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Submit') }}
                </button>
            </div>
        </form>
        
        
    </div>
</x-app-layout>
