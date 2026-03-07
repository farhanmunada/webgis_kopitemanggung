<x-guest-layout>
<div class="flex flex-col md:flex-row min-h-screen bg-white">
    <!-- Left Section: Image & Branding -->
    <div class="hidden md:flex md:w-1/2 lg:w-3/5 relative bg-coffee-950 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=2670&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-gradient-to-t from-coffee-950 via-transparent to-transparent"></div>
        
        <div class="relative z-10 flex flex-col justify-end p-16 text-white h-full">
            <div class="flex items-center space-x-3 mb-8 bg-white/10 backdrop-blur-md p-3 rounded-xl w-max border border-white/20">
                <x-application-logo class="w-8 h-8 text-white fill-current" />
                <span class="font-extrabold text-xl tracking-tight">Kopi Temanggung</span>
            </div>
            
            <h2 class="text-5xl font-extrabold leading-tight mb-6">Mendukung Petani Lokal, Menyapa Dunia.</h2>
            <p class="text-xl text-coffee-100 max-w-lg leading-relaxed">
                Jelajahi katalog produk kopi terbaik dan direktori perkebunan Temanggung dalam satu platform.
            </p>
            
            <div class="mt-12 flex items-center space-x-4 text-sm font-medium text-coffee-200">
                <span class="flex items-center"><i class="fas fa-check-circle mr-2 text-green-400"></i> Terverifikasi</span>
                <span class="flex items-center"><i class="fas fa-check-circle mr-2 text-green-400"></i> Langsung dari Petani</span>
            </div>
        </div>
    </div>

    <!-- Right Section: Login Form -->
    <div class="w-full md:w-1/2 lg:w-2/5 flex flex-col justify-center px-8 sm:px-12 lg:px-20 py-12">
        <div class="md:hidden flex items-center space-x-2 mb-12">
            <x-application-logo class="w-8 h-8 text-coffee-800" />
            <span class="font-extrabold text-xl text-gray-900">Kopi Temanggung</span>
        </div>

        <div class="max-w-md w-full mx-auto">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Masuk ke Akun Anda</h1>
            <p class="text-gray-500 mb-10">Akses direktori & marketplace Kopi Temanggung.</p>

            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-bold mb-1.5" />
                    <div class="relative">
                        <x-text-input id="email" class="block w-full border-gray-200 focus:border-coffee-500 focus:ring-coffee-500 rounded-xl h-12" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <div class="mb-1.5">
                        <x-input-label for="password" :value="__('Kata Sandi')" class="text-gray-700 font-bold" />
                    </div>
                    <x-text-input id="password" class="block w-full border-gray-200 focus:border-coffee-500 focus:ring-coffee-500 rounded-xl h-12"
                                    type="password"
                                    name="password"
                                    required placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between py-2">
                    <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-coffee-600 shadow-sm focus:ring-coffee-500 w-5 h-5 transition" name="remember">
                        <span class="ms-3 text-sm text-gray-500 font-medium group-hover:text-gray-700">Ingat saya untuk 30 hari</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-coffee-800 hover:bg-coffee-950 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-coffee-200 transition-all transform active:scale-[0.98] flex items-center justify-center">
                        Masuk Sekarang <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </button>
                </div>
            </form>

            <div class="mt-8 relative">
                <div class="absolute inset-0 flex items-center"><span class="w-full border-t border-gray-100"></span></div>
                <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-2 text-gray-400 font-bold tracking-widest">Atau masuk dengan</span></div>
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

            <p class="mt-10 text-center text-sm text-gray-500 font-medium">
                Belum punya akun? <a href="{{ route('register') }}" class="text-coffee-700 font-bold hover:underline">Daftar Sekarang</a>
            </p>
            
            <div class="mt-12 flex justify-center space-x-6 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                <a href="#" class="hover:text-gray-600">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-gray-600">Kebijakan Privasi</a>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>
