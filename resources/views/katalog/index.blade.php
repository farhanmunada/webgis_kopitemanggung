<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kopi Temanggung - Landing</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#faf9f8] font-sans antialiased text-gray-800">
    
    <!-- Alert Notifications -->
    @if(session('success') || session('message'))
    <div class="fixed top-20 left-1/2 -translate-x-1/2 z-[60] w-full max-w-lg px-4 animate-bounce-short">
        <div class="bg-white border-l-4 {{ session('success') ? 'border-green-500' : 'border-orange-500' }} shadow-2xl rounded-xl p-4 flex items-center space-x-4">
            <div class="{{ session('success') ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }} p-2 rounded-full">
                <i class="fas {{ session('success') ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-gray-900">{{ session('success') ?? session('message') }}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif
    <!-- Navbar -->
    <x-frontend-navbar activePage="katalog" />

    <!-- Premium Hero Section -->
    <section class="relative bg-gray-900 min-h-[500px] flex items-center overflow-hidden">
        <!-- Background Image with Parallax-like effect -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=2670&auto=format&fit=crop" class="w-full h-full object-cover opacity-60 scale-105 hover:scale-100 transition duration-[10s]">
            <div class="absolute inset-0 bg-gradient-to-tr from-black via-black/40 to-transparent"></div>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-amber-900/10 to-transparent pointer-events-none"></div>
        
        <div class="max-w-[1200px] mx-auto px-6 relative z-10 w-full py-20">
            <div class="max-w-3xl">
                <!-- Badge -->
                <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 rounded-full mb-8 animate-fade-in-down">
                    <span class="flex h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span class="text-white text-[10px] font-black uppercase tracking-[0.2em]">Explore Origin Temanggung</span>
                </div>

                <!-- Main Title -->
                <h1 class="text-5xl md:text-7xl font-black text-white leading-[1.1] tracking-tight mb-8">
                    Discover The <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-200 to-amber-500">Soul Of Coffee</span> In Every Bean.
                </h1>

                <!-- Description -->
                <p class="text-gray-300 text-lg md:text-xl leading-relaxed mb-10 max-w-2xl font-light">
                    Menghubungkan Anda langsung dengan petani kopi terbaik di lereng Sumbing, Sindoro, dan Prau. Nikmati kualitas autentik melalui teknologi WebGIS.
                </p>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="#katalog" class="group flex items-center justify-center px-8 py-4 bg-amber-600 hover:bg-amber-500 text-white rounded-2xl font-black text-sm transition-all duration-300 shadow-xl shadow-amber-900/20 active:scale-95 w-full sm:w-auto">
                        Jelajahi Katalog <i class="fas fa-arrow-down ml-3 group-hover:translate-y-1 transition-transform"></i>
                    </a>
                    <a href="/map" class="group flex items-center justify-center px-8 py-4 bg-white/5 backdrop-blur-xl border border-white/10 hover:bg-white/10 text-white rounded-2xl font-black text-sm transition-all duration-300 w-full sm:w-auto">
                        <i class="fas fa-map-marked-alt mr-3 group-hover:scale-110 transition-transform"></i> Buka Peta Interaktif
                    </a>
                </div>
            </div>
        </div>

        <!-- Decorative Floating Label at bottom -->
        <div class="absolute bottom-8 right-8 hidden lg:flex items-center space-x-4 animate-fade-in">
            <div class="text-right">
                <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest">Sindoro Altitude</p>
                <p class="text-sm font-bold text-white leading-none">1,400+ MDPL</p>
            </div>
            <div class="w-12 h-1 bg-amber-500 rounded-full"></div>
        </div>
    </section>

    <!-- Main Content wrapper update -->
    <main class="max-w-[1200px] mx-auto px-6 py-16">

        <!-- Seller CTA Banner -->
        <div class="bg-gradient-to-r from-coffee-900 to-coffee-800 rounded-3xl p-8 md:p-12 mb-12 flex flex-col md:flex-row items-center justify-between shadow-2xl shadow-coffee-200/50 border border-coffee-700/50 gap-10">
            <div class="text-center md:text-left flex-1 max-w-2xl">
                <h3 class="text-3xl md:text-4xl font-black text-white mb-3 italic tracking-tight leading-tight">Punya Produk Kopi Unggulan?</h3>
                <p class="text-coffee-200 font-medium text-lg md:text-xl opacity-90 leading-relaxed">Tampilkan produk kopi terbaik Anda di katalog kami dan hubungkan usaha Anda dengan ribuan peminat kopi Temanggung.</p>
            </div>
            @php
                $targetRoute = route('register');
                $ctaText = 'Post Produk';
                $isPending = false;
                
                if(auth()->check()) {
                    $user = auth()->user();
                    $umkm = $user->umkms()->first();
                    
                    if ($umkm && $umkm->status === 'pending') {
                        $isPending = true;
                        $ctaText = 'Menunggu Validasi';
                        $targetRoute = 'javascript:void(0)';
                    } else {
                        if($user->role == 'public') {
                            $targetRoute = route('umkm.register');
                        } else {
                            $targetRoute = $user->role == 'admin' ? route('admin.dashboard') : route('entrepreneur.dashboard');
                        }
                    }
                }
            @endphp
            <div class="flex-shrink-0">
                <a href="{{ $targetRoute }}" class="{{ $isPending ? 'bg-coffee-400 cursor-default shadow-none' : 'bg-white hover:bg-coffee-50 active:scale-95' }} text-coffee-900 font-black px-10 py-5 rounded-2xl transition transform {{ $isPending ? '' : 'hover:scale-105' }} shadow-2xl text-xl flex items-center group whitespace-nowrap">
                    {{ $ctaText }} <i class="fas {{ $isPending ? 'fa-clock' : 'fa-plus-circle' }} ml-3 text-2xl {{ $isPending ? '' : 'group-hover:rotate-90' }} transition duration-300"></i>
                </a>
            </div>
        </div>

        <!-- Featured Products -->
        <div id="katalog" class="mb-16">
            <div class="flex justify-between items-baseline mb-6">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i> Recommended Products
                </h2>
                <a href="#" class="text-sm font-semibold text-primary hover:underline">Lihat Semua</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                <!-- Premium Card -->
                <div class="bg-white rounded-[32px] overflow-hidden shadow-sm border border-gray-100 hover:shadow-2xl hover:border-amber-100 transition duration-500 group">
                    <a href="{{ route('product.show', ['type' => $product->type, 'slug' => $product->slug]) }}" class="block">
                        <div class="relative h-60 bg-gray-100 overflow-hidden">
                            <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 text-[10px] font-black rounded-xl uppercase tracking-widest shadow-sm z-10 text-amber-700 border border-amber-100">{{ $product->type }}</span>
                            <img src="{{ $product->photo ? asset('storage/'.$product->photo) : 'https://placehold.co/400x300?text=Kopi' }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            <div class="absolute inset-x-0 bottom-0 p-6 bg-gradient-to-t from-black/60 to-transparent translate-y-full group-hover:translate-y-0 transition duration-500">
                                <span class="text-white text-[10px] font-black uppercase tracking-widest">Detail Produk <i class="fas fa-arrow-right ml-2"></i></span>
                            </div>
                        </div>
                    </a>
                    <div class="p-7">
                        <div class="mb-4">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ $product->umkm->business_name }}</p>
                            <a href="{{ route('product.show', ['type' => $product->type, 'slug' => $product->slug]) }}" class="block">
                                <h3 class="font-black text-gray-900 text-lg leading-tight hover:text-amber-600 transition h-12 line-clamp-2">{{ $product->name }}</h3>
                            </a>
                        </div>
                        <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-50">
                            <span class="text-xl font-black text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $product->umkm->latitude }},{{ $product->umkm->longitude }}" target="_blank" class="w-11 h-11 bg-gray-900 text-white rounded-2xl flex items-center justify-center hover:bg-amber-600 transition shadow-lg shadow-gray-200" title="Buka Rute di Google Maps">
                                <i class="fas fa-map-marker-alt text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-4 py-20 bg-white rounded-[40px] border border-dashed border-gray-200 text-center flex flex-col items-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-4">
                        <i class="fas fa-box-open text-3xl"></i>
                    </div>
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Belum ada produk disetujui.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- WebGIS Banner -->
        <div class="bg-[#5c392b] rounded-2xl overflow-hidden flex flex-col md:flex-row shadow-xl">
            <div class="p-12 md:w-1/2 flex flex-col justify-center">
                <h2 class="text-3xl font-extrabold text-white mb-4">Eksplorasi via WebGIS</h2>
                <p class="text-[#e6ded9] mb-8 leading-relaxed max-w-sm">Lacak asal-usul kopi Anda secara visual. Temukan lokasi perkebunan, profil petani, dan data elevasi dari setiap produk yang kami tawarkan.</p>
                <div class="flex space-x-4">
                    <a href="/map" class="bg-[#32671e] text-white font-bold px-6 py-3 rounded hover:bg-[#254d16] transition flex items-center"><i class="fas fa-map mr-2"></i> Buka Peta Interaktif</a>
                    <a href="#" class="border border-[#b29380] text-[#e6ded9] font-bold px-6 py-3 rounded hover:bg-[#4d3227] transition">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="md:w-1/2 bg-[#d7ccc8] relative min-h-[300px] flex items-center justify-center p-8">
                <!-- Temanggung map shape abstract illustration -->
                <div class="w-64 h-80 bg-[#a48e80] rounded shadow-[0_20px_50px_rgba(0,0,0,0.3)] border-8 border-white flex justify-center items-center overflow-hidden">
                    <div class="w-48 h-64 bg-[#6e5346] opacity-30 transform rotate-12" style="clip-path: polygon(50% 0%, 100% 38%, 82% 100%, 18% 100%, 0% 38%);"></div>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    @include('components.footer')
</body>
</html>
