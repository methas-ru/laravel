<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Diary') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                     {{-- Display Summary Section --}}
                    <div class="py-8">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 text-gray-900 dark:text-gray-100">
                                        <h3 class="text-xl font-bold mb-4">{{ __('Diary Summary by Emotions') }}
                                        </h3>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                                            @php
                                                $emotions = [
                                                    1 => [
                                                        'name' => 'Happy',
                                                        'emoji' => '😊',
                                                        'gradient' => 'from-yellow-400 to-yellow-600',
                                                    ],
                                                    2 => [
                                                        'name' => 'Sad',
                                                        'emoji' => '😢',
                                                        'gradient' => 'from-blue-400 to-blue-600',
                                                    ],
                                                    3 => [
                                                        'name' => 'Angry',
                                                        'emoji' => '😡',
                                                        'gradient' => 'from-red-400 to-red-600',
                                                    ],
                                                    4 => [
                                                        'name' => 'Excited',
                                                        'emoji' => '🤩',
                                                        'gradient' => 'from-green-400 to-green-600',
                                                    ],
                                                    5 => [
                                                        'name' => 'Anxious',
                                                        'emoji' => '😰',
                                                        'gradient' => 'from-purple-400 to-purple-600',
                                                    ],
                                                ];
                                            @endphp

                                            @foreach ($emotions as $emotionId => $emotion)
                                                {{-- Container for the 3D flip effect --}}
                                                <div class="flip-card cursor-pointer">
                                                    {{-- Inner card that does the flipping --}}
                                                    <div
                                                        class="flip-card-inner transition-transform duration-700 ease-in-out">
                                                        {{-- Front of the card --}}
                                                        <div
                                                            class="flip-card-front bg-gradient-to-br {{ $emotion['gradient'] }} shadow-lg rounded-xl p-6 text-center text-white transform transition-all duration-300 hover:scale-105">
                                                            <div class="text-4xl">
                                                                {{ $emotion['emoji'] }}
                                                            </div>
                                                            <div class="text-xl font-bold mt-2">
                                                                {{ $emotion['name'] }}
                                                            </div>
                                                            <div class="text-5xl font-extrabold mt-4">
                                                                {{ $summary[$emotionId] ?? 0 }}
                                                            </div>
                                                            <p class="text-gray-100 mt-2 text-sm">Diaries</p>
                                                        </div>

                                                        {{-- Back of the card --}}
                                                        <div
                                                            class="flip-card-back bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 text-center text-gray-900 dark:text-gray-100">
                                                            <div class="text-3xl mb-2">
                                                                {{ $emotion['emoji'] }}
                                                            </div>
                                                            <div class="text-lg font-bold mb-2">
                                                                {{ $emotion['name'] }} Diaries
                                                            </div>
                                                            <p class="text-sm">
                                                                @if (($summary[$emotionId] ?? 0) > 0)
                                                                    <span class="text-green-600 font-semibold">
                                                                        You have {{ $summary[$emotionId] }}
                                                                        {{ strtolower($emotion['name']) }}
                                                                        entries
                                                                    </span>
                                                                @else
                                                                    <span class="text-gray-500 italic">
                                                                        No {{ strtolower($emotion['name']) }}
                                                                        entries yet.
                                                                    </span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        .flip-card {
                            background-color: transparent;
                            perspective: 1000px;
                            margin: 1rem 0;
                        }

                        .flip-card-inner {
                            position: relative;
                            width: 100%;
                            text-align: center;
                            transition: transform 0.7s;
                            transform-style: preserve-3d;
                            min-height: 200px;
                            /* ensures it’s not too small */
                            padding: 0.5rem;
                            /* spacing inside the card */
                        }


                        .flip-card:hover .flip-card-inner {
                            transform: rotateY(180deg);
                        }

                        .flip-card-front,
                        .flip-card-back {
                            position: absolute;
                            width: 100%;
                            height: 100%;
                            -webkit-backface-visibility: hidden;
                            backface-visibility: hidden;
                            display: flex;
                            flex-direction: column;
                            justify-content: center;
                            align-items: center;
                        }

                        .flip-card-back {
                            transform: rotateY(180deg);
                        }
                    </style>
                    <!-- End of Summary Section -->
                    <div class="mb-4">
                        <a href="{{ route('diary.create') }}">
                            <button type="button"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                                {{ __('Add New Entry') }}
                            </button>
                        </a>
                    </div>
                    @foreach ($diaryEntries as $entry)
                        <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold mb-2">{{ $entry->date->format('F j, Y') }}</h3>
                            <p class="text-gray-800 dark:text-gray-200">{{ $entry->content }}</p>
                            <!-- Display emotions -->
                            @if ($entry->emotions->isNotEmpty())
                                <h4 class="text-lg font-semibold mb-1 mt-2">Emotions</h4>
                                <ul class="list-disc ml-6">
                                    @foreach ($entry->emotions as $emotion)
                                        <li>
                                            {{ $emotion->name }} (Intensity: {{ $emotion->pivot->intensity }})
                                        </li>
                                    @endforeach
                                </ul>
                                <h4 class="text-lg font-semibold mb-1 mt-2">Categories</h4>
                                <ul class="list-disc ml-6">
                                    @foreach($entry->categories as $category)
                                        <li>
                                            {{ $category->name }} 
                                        </li>
                                    @endforeach
                                </ul>

                                <!-- Display tags -->
                                @if ($entry->tags->isNotEmpty())
                                    <div class="mt-5 flex flex-wrap gap-2">
                                        @foreach ($entry->tags as $tag)
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-200 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                #{{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                            
                            <div class="mt-4 flex justify-end">
                                <x-primary-button style="margin-right: 10px;"
                                    onclick="window.location.href='{{ route('diary.edit', $entry) }}'">
                                    {{ __('Edit') }}
                                </x-primary-button>

                                <form method="POST" action="{{ route('diary.destroy', $entry) }}"
                                    id="delete-form-{{ $entry->id }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>
                                        {{ __('Delete') }}
                                    </x-danger-button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('status') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
            @endif
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>