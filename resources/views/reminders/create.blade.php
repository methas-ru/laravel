<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Reminder') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('reminders.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium">Title</label>
                        <input type="text" name="title"
                            class="w-full border rounded p-2 text-black">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Due Date</label>
                        <input type="date" name="due_date"
                            class="w-full border rounded p-2 text-black">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Status</label>
                        <select name="status"
                            class="w-full border rounded p-2 text-black">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Tags</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($tags as $tag)
                                <label>
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                                    {{ $tag->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <x-primary-button>
                        {{ __('Save') }}
                    </x-primary-button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
