<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="flex flex-col items-center justify-center mb-8">
            <div class="relative group cursor-pointer">
                @if ($user->avatar_url)
                    <img id="avatarPreviewImg" src="{{ $user->avatar_url }}" alt="Avatar" class="h-28 w-28 shrink-0 rounded-full object-cover border-4 border-white shadow-lg" style="width: 112px; height: 112px; object-fit: cover;">
                @else
                    <div id="avatarPlaceholder" class="h-28 w-28 shrink-0 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center border-4 border-white shadow-lg overflow-hidden" style="width: 112px; height: 112px;">
                        <svg class="h-full w-full" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                    </div>
                    <img id="avatarPreviewImg" src="" alt="Avatar" class="h-28 w-28 shrink-0 rounded-full object-cover border-4 border-white shadow-lg hidden" style="width: 112px; height: 112px; object-fit: cover;">
                @endif
                <div class="absolute inset-0 bg-black bg-opacity-40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <input type="file" id="avatar" name="avatar" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" onchange="previewAvatar(event)">
            </div>
            <p class="mt-2 text-sm text-slate-500 text-center">Click to change profile photo</p>
            <x-input-error class="mt-2 text-center" :messages="$errors->get('avatar')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" :value="old('username', $user->username)" autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>

            <div class="md:col-span-2">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" :value="old('email', $user->email)" required autocomplete="email" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-slate-800">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="underline text-sm text-slate-600 hover:text-slate-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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

            <div>
                <x-input-label for="job_title" :value="__('Job Title')" />
                <x-text-input id="job_title" name="job_title" type="text" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" :value="old('job_title', $user->job_title)" placeholder="e.g. Senior Developer" />
                <x-input-error class="mt-2" :messages="$errors->get('job_title')" />
            </div>

            <div>
                <x-input-label for="phone_number" :value="__('Phone Number')" />
                <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" :value="old('phone_number', $user->phone_number)" />
                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
            </div>

            <div class="md:col-span-2">
                <x-input-label for="location" :value="__('Location')" />
                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors" :value="old('location', $user->location)" placeholder="e.g. Paris, France" />
                <x-input-error class="mt-2" :messages="$errors->get('location')" />
            </div>

            <div class="md:col-span-2">
                <x-input-label for="short_bio" :value="__('Short Bio')" />
                <textarea id="short_bio" name="short_bio" rows="4" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">{{ old('short_bio', $user->short_bio) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('short_bio')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors flex items-center">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-green-600 flex items-center"
                >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('Saved successfully.') }}
                </p>
            @endif
        </div>
    </form>
</section>

<script>
    function previewAvatar(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const previewImg = document.getElementById('avatarPreviewImg');
                const placeholder = document.getElementById('avatarPlaceholder');
                
                if (previewImg) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                }
                
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
