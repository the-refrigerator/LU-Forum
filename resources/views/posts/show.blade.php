<!-- resources/views/posts/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center mb-6">
                    <img src="{{ $post->author->profile_picture ? asset('storage/' . $post->author->profile_picture) : 'https://www.pngarts.com/files/10/Default-Profile-Picture-PNG-Download-Image.png' }}"
                        alt="{{ $post->author->name }}'s profile picture" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h3 class="text-lg font-semibold">
                            <a href="{{ route('profile.show', $post->author) }}" class="hover:underline">
                                {{ $post->author->username }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm">Posted on {{ $post->created_at->format('M d, Y') }}
                            on
                            <a href="{{ route('threads.show', $post->thread) }}" class="text-blue-500 hover:underline">
                                {{ $post->thread->name }}
                            </a>
                        </p>
                    </div>
                </div>

                <h1 class="text-3xl font-bold mb-6">{{ $post->title }}</h1>

                <div class="prose lg:prose-xl">{!! \Illuminate\Support\Str::markdown($post->content) !!}</div>

                <div class="mt-6">
                    <a href="{{ route('posts.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Back to Posts
                    </a>
                    @if (auth()->check() && auth()->id() === $post->author_id)
                        <a href="{{ route('posts.edit', $post) }}"
                            class="ml-2 bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Edit Post
                        </a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block ml-2"
                            onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Delete Post
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Replies Section -->
                <div class="mt-12">
                    <h3 class="text-2xl font-semibold mb-4">Replies</h3>

                    @if ($post->replies->isEmpty())
                        <p class="text-gray-600">No replies yet. Be the first to reply!</p>
                    @else
                        @foreach ($post->replies as $reply)
                            <div class="mb-6 p-4 bg-gray-50 rounded-lg shadow-md">
                                <div class="flex items-center mb-4">
                                    <img src="{{ $reply->author->profile_picture ? asset('storage/' . $reply->author->profile_picture) : 'https://www.pngarts.com/files/10/Default-Profile-Picture-PNG-Download-Image.png' }}"
                                        alt="{{ $reply->author->name }}'s profile picture"
                                        class="w-10 h-10 rounded-full mr-4">
                                    <div>
                                        <h4 class="text-lg font-semibold">
                                            <a href="{{ route('profile.show', $reply->author) }}"
                                                class="hover:underline">
                                                {{ $reply->author->username }}
                                            </a>
                                        </h4>
                                        <p class="text-gray-600 text-sm">Replied on
                                            {{ $reply->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>

                                <div class="prose lg:prose-xl">{!! \Illuminate\Support\Str::markdown($reply->content) !!}</div>

                                <!-- Delete Button for the Reply -->
                                @if (auth()->check() && auth()->id() === $reply->author_id)
                                    <form action="{{ route('posts.deleteReply', $reply) }}" method="POST"
                                        class="mt-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                            Delete Reply
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    @endif


                    <!-- Reply Section -->
                    <div class="mt-8">
                        <h3 class="text-2xl font-semibold mb-4">Leave a Reply</h3>

                        @auth
                            <form method="POST" action="{{ route('posts.reply', $post) }}">
                                @csrf

                                <div class="mb-4">
                                    <textarea name="content" rows="4"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        placeholder="Write your reply..." required></textarea>
                                </div>

                                <div class="flex items-center justify-between">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Post Reply
                                    </button>
                                </div>
                            </form>
                        @else
                            <p class="text-gray-600">Please <a href="{{ route('login') }}"
                                    class="text-blue-500 hover:underline">log in</a> to reply.</p>
                        @endauth
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
