<!-- resources/views/threads/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Thread Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-3xl font-bold mb-6">{{ $thread->name }}</h1>

                <p class="text-gray-700 mb-4">{{ $thread->description }}</p>

                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('threads.edit', $thread) }}"
                       class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mb-4">
                        Edit Thread
                    </a>
                @endif

                <a href="{{ route('threads.index') }}"
                   class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Back to Threads
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
