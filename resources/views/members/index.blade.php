<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Members') }}
        </h2>
    </x-slot>
    <!-- show top members -->
    <div class="max-w-6xl mx-auto mt-6 grid grid-cols-2 gap-6">

    {{-- Members List --}}
    <div class="bg-white shadow-md rounded-lg p-4">
        <h2 class="text-xl font-bold mb-2">All Members</h2>
        <div class="h-64 overflow-y-auto space-y-3 border-t pt-2">
            @foreach ($members as $member)
                <div class="flex items-center space-x-3 p-2 bg-gray-100 rounded">
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                        <span class="text-lg font-semibold text-gray-600">
                            {{ strtoupper(substr($member->username, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="font-bold text-md"><a href="{{ route('profile.show', $member->id) }}" class="text-blue-500 hover:underline">{{ $member->username }}</a></h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Admins & Moderators List --}}
    <div class="bg-white shadow-md rounded-lg p-4">
        <h2 class="text-xl font-bold mb-2">Admins & Moderators</h2>
        <div class="h-64 overflow-y-auto space-y-3 border-t pt-2">
            @foreach ($admins as $admin)
                <div class="flex items-center space-x-3 p-2 bg-gray-100 rounded">
                    <div class="w-10 h-10 bg-blue-300 rounded-full flex items-center justify-center">
                        <span class="text-lg font-semibold text-white">
                            {{ strtoupper(substr($admin->username, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="font-bold text-md"><a href="{{ route('profile.show', $admin->id) }}" class="text-blue-500 hover:underline">{{ $admin->username }}</a></h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
</x-app-layout>
