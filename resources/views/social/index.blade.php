<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Social Media Links') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <!-- Add New Link Button with Gradient -->
                <div class="flex justify-center mb-8">
                    <a href="{{ route('social.create') }}" 
                       class="px-8 py-3 bg-gradient-to-r from-sky-400 to-yellow-300 hover:from-sky-500 hover:to-yellow-400 text-gray-900 font-bold rounded-lg shadow-md transition-all duration-200">
                        {{ __('Add New Link') }}
                    </a>
                </div>

                <!-- Social Media Links Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gradient-to-r from-sky-100 to-lime-50 dark:from-sky-900 dark:to-lime-900 border-b border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-4 text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('Platform') }}</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('URL') }}</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider text-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($socialMedia as $link)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                <td class="px-6 py-5 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $link->platform }}
                                </td>
                                <td class="px-6 py-5 text-sm text-blue-600 dark:text-blue-400 italic">
                                    <a href="{{ $link->url }}" target="_blank" class="hover:underline">
                                        {{ $link->url }}
                                    </a>
                                </td>
                                <td class="px-6 py-5 text-right space-x-2">
                                    <!-- Edit Button (Yellow) -->
                                    <a href="{{ route('social.edit', $link) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('Edit') }}
                                    </a>

                                    <!-- Delete Button (Red) -->
                                    <form method="POST" action="{{ route('social.destroy', $link) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete this link?')"
                                                class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                            @if($socialMedia->isEmpty())
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                    {{ __('No social media links found.') }}
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>