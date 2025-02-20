<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }} <a href="{{ route('profile.show', $user) }}"
                class="text-sm text-gray-600 hover:underline">({{ __('View Profile') }})</a>
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Add enctype for file uploading -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)"
                required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="about" :value="__('About Me')" />
            <x-text-input id="about" name="about_me" type="text" class="mt-1 block w-full" :value="old('about_me', $user->about_me)"
                autofocus autocomplete="about_me" />
            <x-input-error class="mt-2" :messages="$errors->get('about_me')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- New Profile picture Upload Field -->
        <div>
            <x-input-label for="profile_picture" :value="__('Profile picture')" />
            <input id="profile_picture" name="profile_picture" type="file" class="mt-1 block w-full"
                accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
            @if ($user->profile_picture)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->profile_picture) }}"
                        alt="{{ __('Current Profile picture') }}" class="w-20 h-20 rounded-full object-cover">
                </div>
            @endif
        </div>

        <!-- New Cover Picture Upload Field -->
        <div>
            <x-input-label for="cover_picture" :value="__('Cover Picture')" />
            <input id="cover_picture" name="cover_picture" type="file" class="mt-1 block w-full" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('cover_picture')" />
            @if ($user->cover_picture)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->cover_picture) }}" alt="{{ __('Current Cover Picture') }}"
                        class="w-full h-40 object-cover">
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
