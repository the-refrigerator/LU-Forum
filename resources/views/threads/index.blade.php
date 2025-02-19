<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Threads') }}
        </h2>
    </x-slot>


<div class="container mx-auto py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <h1 class="text-3xl font-bold mb-6">Threads</h1>

    @if(session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    @if($threads->count())
        <div class="space-y-4">
            @foreach($threads as $thread)
                <div class="p-4 bg-white shadow rounded-lg">
                    <h2 class="text-2xl font-semibold">
                        <a href="{{ route('threads.show', $thread) }}" class="text-blue-500 hover:underline">
                            {{ $thread->name }}
                        </a>
                    </h2>
                    <p class="mt-2 text-gray-600">{{ $thread->description }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p>No threads found.</p>
    @endif
            </div>
        </div>
</div>
</x-app-layout>
