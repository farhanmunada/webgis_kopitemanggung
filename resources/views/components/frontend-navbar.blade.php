@props(['activePage' => 'home'])

<nav class="bg-white/80 backdrop-blur-md border-b sticky top-0 z-50 px-6 py-4 flex justify-between items-center">
    <div class="flex items-center space-x-2">
        <x-application-logo class="w-8 h-8 text-primary" />
        <a href="/" class="font-extrabold text-xl tracking-tight text-gray-900">Kopi Temanggung</a>
    </div>
    <div class="hidden md:flex items-center space-x-8 font-semibold text-gray-600 text-sm">
        <x-nav-link href="/" :active="$activePage === 'map'" class="{{ $activePage === 'map' ? 'text-primary border-b-2 border-primary pb-1' : 'hover:text-primary transition' }}">Beranda Peta</x-nav-link>
        <x-nav-link href="/katalog" :active="$activePage === 'katalog'" class="{{ $activePage === 'katalog' ? 'text-primary border-b-2 border-primary pb-1' : 'hover:text-primary transition' }}">Katalog Produk</x-nav-link>
    </div>
    <div class="flex items-center space-x-6">
        <div class="relative hidden lg:block">
            <form action="{{ route('katalog.index') }}" method="GET">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari varietas, toko, produk..." class="pl-10 pr-4 py-2 border-none bg-gray-100 rounded-full text-sm font-medium w-64 focus:ring-2 focus:ring-primary focus:bg-white transition">
            </form>
        </div>
        
        @if(auth()->check())
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-3 focus:outline-none group">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-gray-900 leading-none group-hover:text-primary transition">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-gray-500 font-medium mt-1 uppercase tracking-tighter">
                        {{ auth()->user()->role == 'umkm' ? 'PENGUSAHA' : (auth()->user()->role == 'admin' ? 'ADMIN' : 'MEMBER') }}
                    </p>
                </div>
                <div class="w-10 h-10 border-2 border-orange-100 bg-orange-50 text-primary rounded-full flex items-center justify-center font-black shadow-sm group-hover:scale-105 transition transform">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-[60]"
                 style="display: none;">
                
                <div class="px-4 py-2 border-b border-gray-50 mb-1">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-tight">Menu Akun</p>
                </div>

                <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : (auth()->user()->role == 'umkm' ? route('entrepreneur.dashboard') : route('dashboard')) }}" class="flex items-center space-x-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-primary transition">
                    <i class="fas fa-th-large text-xs w-4"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-primary transition">
                    <i class="fas fa-user-circle text-xs w-4"></i>
                    <span>Edit Profil</span>
                </a>

                <hr class="my-1 border-gray-50">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 transition text-left">
                        <i class="fas fa-sign-out-alt text-xs w-4"></i>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="flex items-center space-x-4">
            <a href="{{ route('login') }}" class="font-bold text-gray-500 hover:text-primary transition text-sm">Masuk</a>
        </div>
        @endif
    </div>
</nav>
