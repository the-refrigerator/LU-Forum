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

                @if (Auth::check() && Auth::user()->role === 'admin')
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

            <!-- Display Posts -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                <h2 class="text-2xl font-bold mb-4">Posts</h2>

                @if ($thread->posts->count() != 0)
                    @foreach ($thread->posts as $post)
                        <div class="p-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
                            <p class="text-gray-600 text-sm">Posted on {{ $post->created_at->format('M d, Y') }} by

                                <a href="{{ route('profile.show', $post->author) }}"
                                    class="text-blue-500 hover:underline">
                                    {{ $post->author->username }}
                                </a>
                            </p>

                            <div class="mt-2">
                                <a href="{{ route('posts.show', $post) }}"
                                    class="text-blue-500 hover:underline">View</a>
                                @if (auth()->check() && auth()->id() === $post->author_id)
                                    | <a href="{{ route('posts.edit', $post) }}"
                                        class="text-yellow-500 hover:underline">Edit</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                        class="inline-block ml-2" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p> No posts found for this thread. </p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
