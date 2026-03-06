<x-app-layout>
    @include('components.frontend-navbar', ['activePage' => 'katalog'])

    <div class="bg-[#faf9f8] min-h-screen">
        <!-- Shop Header / Hero Section -->
        <div class="relative h-[300px] md:h-[400px] overflow-hidden">
            <img src="{{ $umkm->photo ? asset('storage/'.$umkm->photo) : 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=2670&auto=format&fit=crop' }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            
            <div class="absolute bottom-0 left-0 w-full p-8 md:p-12">
                <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="flex items-center space-x-6">
                        <div class="w-24 h-24 md:w-32 md:h-32 bg-white rounded-3xl p-1 shadow-2xl overflow-hidden border-4 border-white/20 backdrop-blur-md">
                            <div class="w-full h-full bg-amber-50 rounded-[20px] flex items-center justify-center text-amber-600 font-black text-4xl uppercase">
                                {{ substr($umkm->business_name, 0, 1) }}
                            </div>
                        </div>
                        <div class="text-white">
                            <div class="flex items-center space-x-3 mb-2">
                                <span class="px-3 py-1 bg-amber-500 text-white rounded-full text-[10px] font-black uppercase tracking-widest">{{ $umkm->category->name }}</span>
                                @if($umkm->geo_verified_at)
                                <span class="px-3 py-1 bg-blue-500 text-white rounded-full text-[10px] font-black uppercase tracking-widest flex items-center">
                                    <i class="fas fa-check-circle mr-1.5 shadow-sm"></i> Terverifikasi
                                </span>
                                @endif
                            </div>
                            <h1 class="text-4xl md:text-5xl font-black leading-tight drop-shadow-md">{{ $umkm->business_name }}</h1>
                            <div class="flex items-center mt-3 text-amber-400 space-x-2">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= floor($umkm->avg_rating) ? '' : 'opacity-30' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-white font-bold text-sm">{{ $umkm->avg_rating }} ({{ count($umkm->reviews) }} Ulasan)</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $umkm->latitude }},{{ $umkm->longitude }}" target="_blank" class="bg-white text-gray-900 font-black px-8 py-4 rounded-2xl shadow-xl hover:bg-amber-50 transition transform active:scale-95 flex items-center">
                            <i class="fas fa-directions mr-3 text-amber-600"></i> Petunjuk Arah
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shop Detail Content -->
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
                <!-- Sidebar Info -->
                <div class="space-y-10">
                    <section class="bg-white p-8 rounded-[40px] shadow-sm border border-gray-100">
                        <h3 class="font-black text-gray-900 uppercase tracking-widest text-xs mb-6 flex items-center">
                            <i class="fas fa-info-circle text-amber-500 mr-2 text-lg"></i> Tentang Toko
                        </h3>
                        <p class="text-gray-600 leading-relaxed text-sm italic">"{{ $umkm->description }}"</p>
                        
                        <div class="mt-8 space-y-6 pt-8 border-t border-gray-50">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-amber-600 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Lokasi</p>
                                    <p class="text-sm font-bold text-gray-800 leading-relaxed">{{ $umkm->address }}</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-amber-600 flex-shrink-0">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Kontak</p>
                                    <p class="text-sm font-bold text-gray-800">{{ $umkm->phone }}</p>
                                </div>
                            </div>

                            @if($umkm->operating_hours)
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-amber-600 flex-shrink-0">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Jam Operasional</p>
                                    <p class="text-sm font-bold text-gray-800">{{ $umkm->operating_hours }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </section>

                    <!-- WebGIS Banner -->
                    <div class="bg-gray-900 p-8 rounded-[40px] text-white overflow-hidden relative group shadow-2xl">
                        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-amber-500/20 rounded-full blur-3xl group-hover:scale-150 transition duration-1000"></div>
                        <h3 class="text-2xl font-black mb-4 relative z-10 leading-tight">Lihat di Peta</h3>
                        <p class="text-sm text-gray-400 mb-8 relative z-10 leading-relaxed font-medium">Buka peta interaktif untuk melihat sebaran kebun kopi dan mitra kami lainnya di seluruh Temanggung.</p>
                        <a href="/map?q={{ $umkm->business_name }}" class="inline-flex items-center font-black text-amber-500 text-xs uppercase tracking-widest hover:text-white transition relative z-10">
                            Buka Map WebGIS <i class="fas fa-arrow-right ml-3 text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="lg:col-span-2 space-y-12">
                    <div class="flex justify-between items-baseline">
                        <h2 class="text-3xl font-black text-gray-900">Katalog Produk</h2>
                        <span class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ count($products) }} Koleksi</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @forelse($products as $product)
                        <div class="bg-white rounded-[32px] overflow-hidden shadow-sm border border-gray-100 hover:shadow-2xl hover:border-amber-100 transition duration-500 group">
                            <a href="{{ route('product.show', ['type' => $product->type, 'slug' => $product->slug]) }}" class="block">
                                <div class="relative h-60 bg-gray-100 overflow-hidden">
                                    <img src="{{ $product->photo ? asset('storage/'.$product->photo) : 'https://placehold.co/400x300?text=Kopi' }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                    <div class="absolute inset-x-0 bottom-0 p-6 bg-gradient-to-t from-black/60 to-transparent translate-y-full group-hover:translate-y-0 transition duration-500">
                                        <span class="text-white text-xs font-black uppercase tracking-widest">Detail Produk <i class="fas fa-arrow-right ml-2 text-[10px]"></i></span>
                                    </div>
                                </div>
                            </a>
                            <div class="p-8">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-1">{{ $product->type }}</p>
                                        <a href="{{ route('product.show', ['type' => $product->type, 'slug' => $product->slug]) }}" class="block">
                                            <h3 class="font-black text-gray-900 text-xl leading-tight hover:text-amber-600 transition">{{ $product->name }}</h3>
                                        </a>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-50">
                                    <span class="text-2xl font-black text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $umkm->latitude }},{{ $umkm->longitude }}" target="_blank" class="w-12 h-12 bg-gray-900 text-white rounded-2xl flex items-center justify-center hover:bg-amber-600 transition shadow-lg shadow-gray-200" title="Buka Rute di Google Maps">
                                        <i class="fas fa-map-marker-alt text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-2 py-20 bg-white rounded-[40px] border border-dashed border-gray-200 text-center flex flex-col items-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-4">
                                <i class="fas fa-box-open text-3xl"></i>
                            </div>
                            <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Belum ada produk aktif di toko ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')
</x-app-layout>
