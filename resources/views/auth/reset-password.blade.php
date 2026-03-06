<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#fafafa]">
        <div class="w-full sm:max-w-md px-8 py-10 bg-white shadow-xl shadow-gray-200/50 rounded-2xl border border-gray-100">
            <div class="mb-8 items-center flex space-x-2">
                <x-application-logo class="w-6 h-6 text-coffee-800" />
                <span class="font-bold text-gray-800">Atur Ulang Kata Sandi</span>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="font-bold text-gray-700 mb-1" />
                    <x-text-input id="email" class="block mt-1 w-full border-gray-200 focus:border-coffee-500 focus:ring-coffee-500 rounded-xl" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="font-bold text-gray-700 mb-1" />
                    <x-text-input id="password" class="block mt-1 w-full border-gray-200 focus:border-coffee-500 focus:ring-coffee-500 rounded-xl" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="font-bold text-gray-700 mb-1" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-200 focus:border-coffee-500 focus:ring-coffee-500 rounded-xl"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-8">
                    <button type="submit" class="w-full bg-coffee-800 text-white font-bold py-3 rounded-xl hover:bg-coffee-900 transition">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
