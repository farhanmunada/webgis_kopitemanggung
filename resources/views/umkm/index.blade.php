<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil UMKM - Kopi Temanggung</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#faf9f8] font-sans antialiased text-gray-800">
    
    <x-frontend-navbar activePage="umkm" />

    <!-- Hero Section -->
    <section class="relative bg-coffee-950 py-24 overflow-hidden">
        <div class="absolute inset-0 opacity-40">
            <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=2670&auto=format&fit=crop" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-coffee-950/90"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-black text-white mb-6 tracking-tight">Profil UMKM <span class="text-amber-500">Kopi Temanggung</span></h1>
            <p class="text-coffee-100 text-xl max-w-2xl mx-auto inline-block border-t border-white/20 pt-6">
                Mengenal lebih dekat para penggerak industri kopi di lereng Sumbing, Sindoro, dan Prau.
            </p>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-6 py-20">
        
        <!-- Best UMKM Section -->
        <div class="mb-24">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="text-amber-600 font-black text-xs uppercase tracking-[0.3em] mb-3 block">Top Choice</span>
                    <h2 class="text-4xl font-black text-gray-900 leading-tight">Best Rated UMKM</h2>
                </div>
                <div class="h-1 flex-1 bg-gray-100 mb-2 hidden md:block mx-8 rounded-full"></div>
                <p class="text-gray-500 font-medium max-w-xs text-right hidden lg:block">Mitra dengan pelayanan dan kualitas produk terbaik pilihan pelanggan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($bestUmkms as $umkm)
                    @include('umkm.partials.umkm_card', ['umkm' => $umkm])
                @endforeach
            </div>
        </div>

        <!-- Section: Coffeeshop -->
        <div class="mb-24 bg-white rounded-[60px] p-12 shadow-sm border border-gray-50">
            <div class="flex items-center space-x-6 mb-12">
                <div class="w-16 h-16 bg-amber-100 rounded-3xl flex items-center justify-center text-amber-700 text-2xl shadow-inner">
                    <i class="fas fa-coffee"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-gray-900 uppercase">Kedai Kopi</h2>
                    <p class="text-gray-500 font-medium italic">Tempat terbaik untuk menikmati seduhan kopi autentik.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($coffeeshopUmkms as $umkm)
                    @include('umkm.partials.umkm_card', ['umkm' => $umkm])
                @empty
                    <div class="col-span-3 text-center py-12 text-gray-400 font-bold uppercase tracking-widest text-xs italic">Belum ada profil kedai kopi.</div>
                @endforelse
            </div>
        </div>

        <!-- Section: Roastery -->
        <div class="mb-24">
            <div class="flex items-center space-x-6 mb-12">
                <div class="w-16 h-16 bg-orange-100 rounded-3xl flex items-center justify-center text-orange-700 text-2xl shadow-inner">
                    <i class="fas fa-fire"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-gray-900 uppercase">Roastery</h2>
                    <p class="text-gray-500 font-medium italic">Unit pengolahan sangrai kopi dengan standar profesional.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($roasteryUmkms as $umkm)
                    @include('umkm.partials.umkm_card', ['umkm' => $umkm])
                @empty
                    <div class="col-span-3 text-center py-12 text-gray-400 font-bold uppercase tracking-widest text-xs italic">Belum ada profil roastery.</div>
                @endforelse
            </div>
        </div>

        <!-- Section: Toko Kopi -->
        <div class="mb-16 bg-emerald-900 rounded-[60px] p-12 shadow-2xl text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
            
            <div class="flex items-center space-x-6 mb-12 relative z-10">
                <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-3xl flex items-center justify-center text-emerald-300 text-2xl border border-white/10">
                    <i class="fas fa-store"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-black uppercase text-white">Toko Kopi</h2>
                    <p class="text-emerald-200 font-medium italic opacity-80">Menyediakan berbagai bahan olahan kopi berkualitas.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative z-10">
                @forelse($supplierUmkms as $umkm)
                    @include('umkm.partials.umkm_card', ['umkm' => $umkm, 'dark' => true])
                @empty
                    <div class="col-span-3 text-center py-12 text-emerald-400/50 font-bold uppercase tracking-widest text-xs italic">Belum ada profil toko kopi.</div>
                @endforelse
            </div>
        </div>

    </main>

    <x-footer />
</body>
</html>
