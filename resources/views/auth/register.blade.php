<x-guest-layout>
<div class="flex flex-col md:flex-row min-h-screen bg-[#fafafa]">
    <!-- Left Section: Registration Form -->
    <div class="w-full md:w-1/2 lg:w-2/5 flex flex-col justify-center px-8 sm:px-12 lg:px-20 py-12 order-2 md:order-1 bg-white">
        <div class="md:hidden flex items-center space-x-2 mb-12">
            <x-application-logo class="w-8 h-8 text-coffee-800" />
            <span class="font-bold text-xl text-gray-900">Kopi Temanggung</span>
        </div>

        <div class="max-w-md w-full mx-auto">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Buat Akun Baru</h1>
            <p class="text-gray-500 mb-10 text-sm">Bergabung dengan ekosistem kopi terbaik di Temanggung.</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 font-bold mb-1.5 text-xs" />
                    <x-text-input id="name" class="block w-full border-gray-200 focus:border-coffee-500 focus:ring-coffee-500 rounded-xl h-12 text-sm" type="text" name="name" :value="old('name')" required autofocus placeholder="Masukkan nama lengkap Anda" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Alamat Email')" class="text-gray-700 font-bold mb-1.5 text-xs" />
                    <x-text-input id="email" class="block w-full border-gray-200 focus:border-coffee-500 focus:ring-coffee-500 rounded-xl h-12 text-sm" type="email" name="email" :value="old('email')" required placeholder="nama@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Kata Sandi')" class="text-gray-700 font-bold mb-1.5 text-xs" />
                        <x-text-input id="password" class="block w-full border-gray-200 focus:border-coffee-500 focus:ring-coffee-500 rounded-xl h-12 text-sm"
                                        type="password"
                                        name="password"
                                        required placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Sandi')" class="text-gray-700 font-bold mb-1.5 text-xs" />
                        <x-text-input id="password_confirmation" class="block w-full border-gray-200 focus:border-coffee-500 focus:ring-coffee-500 rounded-xl h-12 text-sm"
                                        type="password"
                                        name="password_confirmation" required placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>
                </div>

                <div class="flex items-start space-x-3 py-2">
                    <input id="terms" type="checkbox" required class="mt-1 rounded border-gray-300 text-coffee-600 shadow-sm focus:ring-coffee-500 w-4 h-4 transition">
                    <label for="terms" class="text-xs text-gray-500 leading-relaxed font-medium">
                        Saya menyetujui <a href="#" class="text-gray-900 font-bold hover:underline">Syarat dan Ketentuan</a> serta <a href="#" class="text-gray-900 font-bold hover:underline">Kebijakan Privasi</a> Kopi Temanggung.
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#32450c] hover:bg-[#253309] text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-100 transition-all transform active:scale-[0.98] flex items-center justify-center">
                        Daftar Sekarang <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </button>
                </div>
            </form>

            <p class="mt-8 text-center text-sm text-gray-500 font-medium">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-gray-900 font-bold hover:underline">Masuk di sini</a>
            </p>

            <div class="mt-8 relative">
                <div class="absolute inset-0 flex items-center"><span class="w-full border-t border-gray-100"></span></div>
                <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-2 text-gray-400 font-bold tracking-widest">Atau daftar dengan</span></div>
            </div>

            <div class="mt-6">
                <button type="button" onclick="window.location.href='{{ route('auth.google') }}'" class="w-full border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-bold py-3 px-4 rounded-xl transition flex items-center justify-center space-x-3 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition duration-300" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.1c-.22-.66-.35-1.36-.35-2.1s.13-1.44.35-2.1V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l3.66-2.84z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span>Google</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Right Section: Branding & Stats -->
    <div class="hidden md:flex md:w-1/2 lg:w-3/5 relative bg-[#32450c] overflow-hidden order-1 md:order-2">
        <img src="https://images.unsplash.com/photo-1559056199-641a0ac8b55e?q=80&w=2670&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-50">
        <div class="absolute inset-0 bg-gradient-to-t from-[#1b2506] via-transparent to-transparent"></div>
        
        <div class="relative z-10 flex flex-col justify-end p-16 text-white h-full">
            <h2 class="text-5xl font-extrabold leading-tight mb-6">Mendukung Petani Kopi Temanggung</h2>
            <p class="text-xl text-green-50 max-w-lg leading-relaxed opacity-90">
                Akses platform marketplace dan visualisasi spasial kebun kopi terbaik dalam satu genggaman.
            </p>
            
            <div class="mt-12 flex items-center space-x-12">
                <div>
                   <span class="block text-3xl font-black text-white">500+</span>
                   <span class="text-xs font-bold text-green-200 uppercase tracking-widest">Petani</span>
                </div>
                <div class="h-10 w-px bg-white/20"></div>
                <div>
                   <span class="block text-3xl font-black text-white">120+</span>
                   <span class="text-xs font-bold text-green-200 uppercase tracking-widest">Varian Kopi</span>
                </div>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>
