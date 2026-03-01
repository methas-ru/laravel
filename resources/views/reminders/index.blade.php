<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Reminders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="mb-4">
                        <a href="{{ route('reminders.create') }}">
                            <button type="button"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition">
                                {{ __('Add New Reminder') }}
                            </button>
                        </a>
                    </div>

                    @foreach ($reminders as $reminder)
                        <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold mb-2">
                                {{ $reminder->title }}
                            </h3>

                            <p class="text-gray-800 dark:text-gray-200">
                                Due: {{ \Carbon\Carbon::parse($reminder->due_date)->format('F j, Y') }}
                            </p>

                            <p class="mt-2">
                                Status:
                                <span class="px-2 py-1 rounded text-white
                                    @if($reminder->status=='pending') bg-yellow-500
                                    @elseif($reminder->status=='in_progress') bg-purple-500
                                    @else bg-green-500
                                    @endif">
                                    {{ ucfirst(str_replace('_',' ', $reminder->status)) }}
                                </span>
                            </p>

                            {{-- TAGS --}}
                            @if ($reminder->tags->isNotEmpty())
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach ($reminder->tags as $tag)
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-200 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            #{{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            {{-- ACTIONS --}}
                            <div class="mt-4 flex justify-end">
                                <x-primary-button style="margin-right: 10px;"
                                    onclick="window.location.href='{{ route('reminders.edit', $reminder) }}'">
                                    {{ __('Edit') }}
                                </x-primary-button>

                                <form method="POST" action="{{ route('reminders.destroy', $reminder) }}"
                                    id="delete-form-{{ $reminder->id }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button onclick="confirmDelete({{ $reminder->id }})">
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

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This reminder will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>
