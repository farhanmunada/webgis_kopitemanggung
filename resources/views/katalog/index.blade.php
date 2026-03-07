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

        <!-- Search Results -->
        @if($search)
        <div id="searchResults" class="mb-16">
            <div class="flex justify-between items-baseline mb-6 border-b border-amber-500/20 pb-4">
                <h2 class="text-3xl font-black flex items-center text-gray-900">
                    <i class="fas fa-search text-amber-600 mr-3"></i> Hasil Pencarian: <span class="ml-2 text-amber-600 italic">"{{ $search }}"</span>
                </h2>
                <span class="text-sm font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">{{ $searchResults->count() }} Produk Ditemukan</span>
            </div>

            @if($searchResults->isEmpty())
                <div class="py-20 bg-white rounded-[40px] border border-dashed border-gray-200 text-center flex flex-col items-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-4">
                        <i class="fas fa-search-minus text-3xl"></i>
                    </div>
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Maaf, kami tidak dapat menemukan apapun untuk "{{ $search }}".</p>
                    <a href="{{ route('katalog.index') }}" class="mt-4 text-amber-600 font-bold hover:underline">Lihat Semua Kopi</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($searchResults as $product)
                        @include('katalog.partials.product_card', ['product' => $product])
                    @endforeach
                </div>
            @endif
        </div>
        @endif

        <!-- Recommended Products -->
        <div id="recommended" class="mb-20">
            <div class="flex justify-between items-baseline mb-8">
                <div>
                    <h2 class="text-3xl font-black flex items-center text-gray-900 mb-2">
                        <span class="w-2 h-8 bg-amber-500 rounded-full mr-4"></span> Recommended Products
                    </h2>
                    <p class="text-gray-500 font-medium ml-8">Paling banyak dilihat dan disukai penikmat kopi.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($recommendedProducts as $product)
                    @include('katalog.partials.product_card', ['product' => $product])
                @endforeach
            </div>
        </div>

        <!-- Section: Coffeeshop (Beverages) -->
        <div id="coffeeshop" class="mb-20">
            <div class="bg-amber-50 rounded-[40px] p-10">
                <div class="flex justify-between items-baseline mb-10">
                    <div>
                        <h2 class="text-3xl font-black flex items-center text-gray-900 mb-2 uppercase tracking-tight">
                            <i class="fas fa-coffee mr-4 text-amber-800"></i> Coffeeshop Beverage
                        </h2>
                        <p class="text-gray-600 font-medium italic">Minuman kopi siap saji dari kedai-kedai terbaik Temanggung.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($coffeeshopProducts->take(8) as $product)
                        @include('katalog.partials.product_card', ['product' => $product])
                    @empty
                        <div class="col-span-4 text-center py-10 text-gray-400 font-bold uppercase tracking-widest text-xs">Belum ada menu coffeeshop.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Section: Roastery -->
        <div id="roastery" class="mb-20">
            <div class="flex justify-between items-baseline mb-8">
                <div>
                    <h2 class="text-3xl font-black flex items-center text-gray-900 mb-2 uppercase tracking-tight">
                        <i class="fas fa-fire mr-4 text-orange-700"></i> Roastery Selections
                    </h2>
                    <p class="text-gray-500 font-medium">Biji kopi sangrai berkualitas tinggi dengan berbagai profil roasting.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($roasteryProducts->take(8) as $product)
                    @include('katalog.partials.product_card', ['product' => $product])
                @empty
                    <div class="col-span-4 text-center py-10 text-gray-400 font-bold uppercase tracking-widest text-xs">Belum ada koleksi roastery.</div>
                @endforelse
            </div>
        </div>

        <!-- Section: Supplier (Beans) -->
        <div id="supplier" class="mb-20">
            <div class="bg-emerald-50 rounded-[40px] p-10">
                <div class="flex justify-between items-baseline mb-10">
                    <div>
                        <h2 class="text-3xl font-black flex items-center text-gray-900 mb-2 uppercase tracking-tight">
                            <i class="fas fa-store mr-4 text-emerald-800"></i> Toko Kopi (Bahan Olahan)
                        </h2>
                        <p class="text-gray-600 font-medium italic">Menyediakan berbagai bahan olahan kopi dan kebutuhan kedai.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($supplierProducts->take(8) as $product)
                        @include('katalog.partials.product_card', ['product' => $product])
                    @empty
                        <div class="col-span-4 text-center py-10 text-gray-400 font-bold uppercase tracking-widest text-xs">Belum ada stok bahan olahan.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Latest Arrival -->
        <div id="latest" class="mb-16">
            <div class="flex justify-between items-baseline mb-8">
                <div>
                    <h2 class="text-3xl font-black flex items-center text-gray-900 mb-2">
                        <i class="fas fa-clock mr-4 text-blue-600"></i> Latest Arrival
                    </h2>
                    <p class="text-gray-500 font-medium">Produk terbaru yang baru saja mendarat di katalog kami.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latestProducts as $product)
                    @include('katalog.partials.product_card', ['product' => $product])
                @endforeach
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
