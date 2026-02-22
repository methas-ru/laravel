<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Social Media Link') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <!-- Form to add/edit social media link -->
                    <form method="POST" action="{{ route('social.store') }}">
                        @csrf
                        
                        <!-- Platform Name Field -->
                        <div class="mb-6">
                            <label for="platform" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Platform Name') }}
                            </label>
                            <input type="text" 
                                   id="platform" 
                                   name="platform" 
                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600" 
                                   value="{{ old('platform') }}" 
                                   placeholder="e.g. Facebook, Instagram, Twitter"
                                   required>
                            @error('platform')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- URL Field -->
                        <div class="mb-6">
                            <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('URL') }}
                            </label>
                            <input type="text" 
                                   id="url" 
                                   name="url" 
                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600" 
                                   value="{{ old('url') }}" 
                                   placeholder="https://..."
                                   required>
                            @error('url')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Save Link Button -->
                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-emerald-500 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-emerald-600 active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Save Link') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>