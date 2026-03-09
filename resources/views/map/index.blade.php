<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peta Sebaran - Kopi Temanggung</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .filter-btn.opacity-50 {
            filter: grayscale(1);
        }
        /* Custom InfoWindow Styling */
        .gm-style-iw {
            padding: 0 !important;
            border-radius: 25px !important;
            max-width: 280px !important;
        }
        .gm-style-iw-d {
            overflow: hidden !important;
            padding: 0 !important;
            max-height: none !important;
        }
        .gm-style-iw-c {
            padding: 0 !important;
            border-radius: 25px !important;
        }
        .gm-ui-hover-effect {
            top: 10px !important;
            right: 10px !important;
            background: white !important;
            border-radius: 50% !important;
            width: 24px !important;
            height: 24px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
            z-index: 100 !important;
        }
        /* Marker Label Stylings */
        .marker-label {
            color: #000 !important;
            font-family: "Figtree", sans-serif !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff, 0px 2px 4px rgba(0,0,0,0.3) !important;
            background: rgba(255, 255, 255, 0.7) !important;
            padding: 2px 6px !important;
            border-radius: 4px !important;
            border: 1px solid rgba(0,0,0,0.1) !important;
            white-space: nowrap !important;
        }
    </style>
</head>
<body class="bg-[#faf9f8] font-sans antialiased text-gray-800 h-screen flex flex-col overflow-hidden">
    
    <x-frontend-navbar activePage="map" />

    <!-- Alert Notifications -->
    @if(session('success') || session('message') || session('error'))
    <div class="fixed top-20 left-1/2 -translate-x-1/2 z-[60] w-full max-w-lg px-4 animate-bounce-short">
        <div class="bg-white border-l-4 {{ session('success') ? 'border-green-500' : (session('error') ? 'border-red-500' : 'border-orange-500') }} shadow-2xl rounded-xl p-4 flex items-center space-x-4">
            <div class="{{ session('success') ? 'bg-green-100 text-green-600' : (session('error') ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600') }} p-2 rounded-full">
                <i class="fas {{ session('success') ? 'fa-check-circle' : (session('error') ? 'fa-times-circle' : 'fa-exclamation-circle') }}"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-gray-900">{{ session('success') ?? session('message') ?? session('error') }}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <!-- Map Section -->
    <main class="flex-grow relative flex flex-col">
        
        <!-- Floating Info/Search Controls -->
        <div class="absolute top-4 md:top-6 left-0 md:left-6 z-10 w-full md:max-w-sm p-4 md:p-0 pointer-events-none">
            <div class="bg-white/95 backdrop-blur-2xl p-6 rounded-3xl shadow-2xl border border-white/50 pointer-events-auto">
                <div class="flex items-center space-x-4 mb-5">
                    <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                        <i class="fas fa-map-marked-alt text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-black tracking-tight leading-none">WebGIS Explorer</h1>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mt-0.5">Sebaran Produk & UMKM</p>
                    </div>
                </div>

                <div class="relative mb-4 group text-sm">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition"></i>
                    <input id="pac-input" type="text" placeholder="Cari lokasi desa/kecamatan..." class="w-full pl-11 pr-4 py-3.5 border-none bg-gray-100/80 rounded-2xl focus:ring-2 focus:ring-primary focus:bg-white transition shadow-inner font-medium">
                </div>

                <!-- Modern Category Filters -->
                <div class="space-y-2">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Filter Kategori</p>
                    <div id="category-filters" class="flex flex-wrap gap-2">
                        @foreach(\App\Models\Category::all() as $cat)
                            <button class="px-4 py-2.5 rounded-xl font-bold text-white text-[11px] filter-btn whitespace-nowrap transition transform hover:scale-105 active:scale-95 shadow-lg shadow-black/10 flex items-center group" data-category="{{ $cat->id }}" style="background-color: {{ $cat->color }}">
                                <i class="fas fa-circle text-[6px] mr-2 opacity-60"></i>
                                {{ $cat->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @if(!auth()->check() || auth()->user()->role !== 'umkm')
        <!-- Floating CTA Daftar UMKM -->
        <div class="absolute top-4 md:top-6 right-0 md:right-6 z-10 w-full md:max-w-xs p-4 md:p-0 pointer-events-none">
            <div class="bg-white/95 backdrop-blur-2xl p-5 rounded-3xl shadow-2xl border border-white/50 pointer-events-auto">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600">
                            <i class="fas fa-store text-sm"></i>
                        </div>
                        <span class="text-sm font-black tracking-tight">Daftarkan UMKM di Map</span>
                    </div>
                </div>
                
                <p class="text-[11px] text-gray-500 font-medium leading-relaxed mb-4">
                    Belum terdaftar di peta sebaran? Daftarkan usaha kopi Anda sekarang untuk menjangkau lebih banyak pelanggan.
                </p>

                @php
                    $ctaRoute = route('register');
                    $ctaText = 'Daftar Sekarang';
                    $isPending = false;
                    
                    if(auth()->check()) {
                        $user = auth()->user();
                        $role = $user->role;
                        $umkm = $user->umkms()->first();
                        
                        if ($umkm && $umkm->status === 'pending') {
                            $isPending = true;
                            $ctaText = 'Menunggu Validasi';
                            $ctaRoute = 'javascript:void(0)';
                        } else {
                            $ctaRoute = $role == 'admin' ? route('admin.dashboard') : ($role == 'umkm' ? route('entrepreneur.dashboard') : route('umkm.register'));
                        }
                    }
                @endphp

                <a href="{{ $ctaRoute }}" class="group w-full {{ $isPending ? 'bg-gray-400 cursor-default' : 'bg-orange-600 hover:bg-orange-700 shadow-orange-200' }} text-white font-bold py-3 px-4 rounded-2xl transition-all transform {{ $isPending ? '' : 'active:scale-[0.98]' }} flex items-center justify-center shadow-lg">
                    <span>{{ $ctaText }}</span>
                    <i class="fas {{ $isPending ? 'fa-clock' : 'fa-plus-circle' }} ml-2 text-xs {{ $isPending ? '' : 'group-hover:rotate-90' }} transition duration-300"></i>
                </a>
            </div>
        </div>
        @endif

        <!-- Dynamic Map Container -->
        <div id="map" class="w-full h-full relative z-0">
            <div class="flex items-center justify-center h-full bg-gray-100">
                <div class="text-center">
                    <svg class="animate-spin h-10 w-10 text-primary mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-gray-500 font-extrabold text-sm tracking-widest uppercase mb-1 block">Sistem Spasial Memuat...</span>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
    <!-- Pass variables to JS -->
    <script>
        window.APP_URL = '{{ env('APP_URL') }}';
    </script>
    <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
    <script src="{{ asset('js/maps.js') }}" defer></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&libraries=places&callback=initMap" defer></script>
    @endpush

    @stack('scripts')
</body>
</html>
