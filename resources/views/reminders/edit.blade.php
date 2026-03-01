<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Reminder') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('reminders.update', $reminder) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium">Title</label>
                        <input type="text" name="title"
                            value="{{ $reminder->title }}"
                            class="w-full border rounded p-2 text-black">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Due Date</label>
                        <input type="date" name="due_date"
                            value="{{ $reminder->due_date }}"
                            class="w-full border rounded p-2 text-black">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Status</label>
                        <select name="status" class="w-full border rounded p-2 text-black">
                            <option value="pending" @selected($reminder->status=='pending')>Pending</option>
                            <option value="in_progress" @selected($reminder->status=='in_progress')>In Progress</option>
                            <option value="done" @selected($reminder->status=='done')>Done</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Tags</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($tags as $tag)
                                <label>
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                        @checked($reminder->tags->contains($tag->id))>
                                    {{ $tag->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <x-primary-button>
                        {{ __('Update') }}
                    </x-primary-button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
