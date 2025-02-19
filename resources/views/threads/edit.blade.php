<!-- resources/views/threads/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Thread') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-3xl font-bold mb-6">Edit Thread</h1>

                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc list-inside text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('threads.update', $thread) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">
                            Thread Name:
                        </label>
                        <input id="name" name="name" type="text" value="{{ old('name', $thread->name) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required autofocus>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-bold mb-2">
                            Description:
                        </label>
                        <textarea id="description" name="description" rows="4"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $thread->description) }}</textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update Thread
                        </button>
                    </div>
                </form>

                <form method="POST" action="{{ route('threads.destroy', $thread) }}" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        onclick="return confirm('Are you sure you want to delete this thread?');">
                        Delete Thread
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
