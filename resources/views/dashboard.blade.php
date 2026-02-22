<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 ">
                    <h3 class="text-2xl font-bold mb-4 flex justify-center">
                        Hello, {{ Auth::user()->name }}!
                    </h3>
                    
                    @if(Auth::user()->birthdate)
                        <p class="text-blue-500 text-xl mb-4 flex justify-center">
                            Birthdate is {{ Auth::user()->birthdate }}!
                        </p>
                    @endif

                    <div class="flex justify-center mb-4">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ route('user.photo', ['filename' => Auth::user()->profile_photo]) }}" 
                                 alt="Profile Photo" 
                                 class="rounded-full w-48 h-48 object-cover border-4 border-blue-300">
                        @endif
                    </div>

                    <p class="italic text-gray-600 mb-4 flex justify-center">
                        PIIHYARA PIIHYARA PAPPAPARAPA
                    </p>

                    <p class="text-sm text-gray-500 flex justify-center">
                        {{ __("You're logged in!") }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
