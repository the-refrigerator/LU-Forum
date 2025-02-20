<!-- resources/views/profile/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Profile') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Cover Picture -->
                <div class="relative">
                    <img src="{{ $user->cover_picture ? asset('storage/' . $user->cover_picture) : 'https://wallpaperaccess.com/full/1536061.jpg' }}"
                        alt="Cover Picture" class="w-full h-60 object-cover rounded-t-lg">
                </div>

                <!-- Profile Picture and User Info -->
                <div class="flex items-center p-6">
                    @if ($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture"
                            class="w-24 h-24 rounded-full object-cover mr-4">
                    @else
                        <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center mr-4">
                            <span class="text-4xl font-semibold text-gray-600">
                                {{ strtoupper(substr($user->username, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                    <div>
                        <h3 class="text-2xl font-bold">{{ $user->username }}</h3>
                        <p class="text-gray-500">Role: {{ $user->role }}</p>
                    </div>
                </div>

                <!-- Additional User Details (Optional) -->
                <div class="p-6">
                    <!-- Add other details here if necessary -->
                    <div class="mt-6">
                        <h4 class="text-xl font-semibold mb-4">About Me</h4>
                        <p class="text-gray-700">{{ $user->about_me }}</p>
                    </div>
                </div>

                <!-- User's Posts -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                    <h2 class="text-2xl font-bold mb-4">Posts ({{ $user->posts->count() }})</h2>

                    @if ($user->posts->count() != 0)
                        @foreach ($user->posts as $post)
                            <div class="p-4 border-b border-gray-200">
                                <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
                                <p class="text-gray-600 text-sm">Posted on {{ $post->created_at->format('M d, Y') }} on
                                    <a href="{{ route('threads.show', $post->thread) }}"
                                        class="text-blue-500 hover:underline">
                                        {{ $post->thread->name }}
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
                        <p> No posts found for this user. </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
