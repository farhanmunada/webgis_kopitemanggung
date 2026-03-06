<aside class="w-64 bg-white border-r h-screen shadow-sm fixed flex flex-col justify-between hidden md:block">
    <div>
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b">
            <x-application-logo class="block h-9 w-auto fill-current text-coffee-800" />
            <div class="ml-3">
                <span class="font-bold text-gray-800 leading-none block">Kopi Temanggung</span>
                <span class="text-xs text-gray-500">{{ auth()->user()->role == 'admin' ? 'Admin Portal' : 'Entrepreneur Dashboard' }}</span>
            </div>
        </div>

        <!-- Links -->
        <div class="px-4 py-6 space-y-2">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-orange-100 text-primary' : 'text-gray-600 hover:bg-gray-50' }} font-medium rounded-lg">
                    <i class="fas fa-chart-line w-5 h-5 mr-3"></i>
                    Main Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.products.index') ? 'bg-orange-100 text-primary' : 'text-gray-600 hover:bg-gray-50' }} font-medium rounded-lg">
                    <i class="fas fa-check-circle w-5 h-5 mr-3"></i>
                    Product Approval
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.users.index') ? 'bg-orange-100 text-primary' : 'text-gray-600 hover:bg-gray-50' }} font-medium rounded-lg">
                    <i class="fas fa-users-cog w-5 h-5 mr-3"></i>
                    User Management
                </a>
            @else
                <a href="{{ route('entrepreneur.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('entrepreneur.dashboard') ? 'bg-orange-100 text-primary' : 'text-gray-600 hover:bg-gray-50' }} font-medium rounded-lg transition">
                    <i class="fas fa-chart-line w-5 h-5 mr-3"></i>
                    Dashboard Statistik
                </a>
                <a href="{{ route('entrepreneur.product.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('entrepreneur.product.*') ? 'bg-orange-100 text-primary' : 'text-gray-600 hover:bg-gray-50' }} font-medium rounded-lg transition">
                    <i class="fas fa-box w-5 h-5 mr-3"></i>
                    Kelola Produk
                </a>
            @endif
        </div>
    </div>

    <!-- Bottom Profile Dropdown -->
    <div class="px-4 py-4 border-t relative" x-data="{ open: false }">
        <!-- Floating Menu -->
        <div x-show="open" 
             @click.away="open = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="absolute bottom-full left-4 bg-white border border-gray-100 shadow-2xl rounded-2xl w-56 mb-2 overflow-hidden z-50">
            <div class="p-4 border-b bg-gray-50">
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Akun Saya</p>
                <p class="text-sm font-bold text-gray-900 truncate mt-1">{{ Auth::user()->name }}</p>
            </div>
            <div class="py-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-primary transition">
                    <i class="fas fa-user-circle w-4 h-4 mr-3 opacity-70"></i> Profil Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                        <i class="fas fa-sign-out-alt w-4 h-4 mr-3 opacity-70"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- Trigger Button -->
        <button @click="open = !open" 
                class="flex items-center w-full p-3 rounded-xl hover:bg-gray-50 transition group {{ request()->routeIs('profile.edit') ? 'bg-gray-50 border border-gray-100' : '' }}">
            <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center text-white font-black shadow-lg shadow-orange-100 group-hover:scale-110 transition">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="ml-3 text-left flex-1 min-w-0">
                <p class="text-sm font-black text-gray-900 truncate leading-none">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight mt-1 truncate">{{ Auth::user()->role == 'admin' ? 'Administrator' : 'Entrepreneur' }}</p>
            </div>
            <i class="fas fa-ellipsis-v text-gray-300 text-xs ml-2 group-hover:text-gray-500 transition"></i>
        </button>
    </div>
</aside>

<!-- Spacer for fixed sidebar -->
<div class="w-64 hidden md:block flex-shrink-0"></div>
