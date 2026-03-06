<x-app-layout>
    @include('components.frontend-navbar', ['activePage' => 'katalog'])

    <div class="bg-gray-50 min-h-screen pt-8 pb-20">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8 text-sm font-medium text-gray-400 uppercase tracking-widest">
                <a href="/katalog" class="hover:text-primary transition">Katalog</a>
                <span class="mx-3 opacity-30">/</span>
                <span class="text-gray-900">{{ $product->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-20">
                <!-- Product Image -->
                <div class="relative group">
                    <div class="aspect-square rounded-3xl shadow-2xl overflow-hidden border-8 border-white bg-white">
                        <img src="{{ $product->photo ? asset('storage/'.$product->photo) : 'https://placehold.co/800x800?text=Kopi+Temanggung' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="{{ $product->name }}">
                    </div>
                    @if($product->views > 0)
                    <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-xl flex items-center space-x-2 border border-white">
                        <i class="fas fa-eye text-primary text-xs"></i>
                        <span class="text-xs font-black text-gray-900 uppercase tracking-tighter">{{ number_format($product->views, 0, ',', '.') }} Dilihat</span>
                    </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="flex flex-col justify-center">
                    <div class="mb-6">
                        <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-[10px] font-black uppercase tracking-widest">{{ $type }}</span>
                        <h1 class="text-5xl font-black text-gray-900 mt-4 leading-tight">{{ $product->name }}</h1>
                        <div class="flex items-center mt-4 space-x-4">
                            <div class="flex items-center text-amber-500">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= floor($product->umkm->avg_rating) ? '' : 'opacity-20' }}"></i>
                                @endfor
                                <span class="ml-2 text-gray-900 font-black text-sm">{{ $product->umkm->avg_rating }}</span>
                            </div>
                            <span class="text-gray-300">|</span>
                            <span class="text-sm font-bold text-gray-500 uppercase tracking-widest">{{ count($reviews) }} Ulasan</span>
                        </div>
                    </div>

                    <p class="text-3xl font-black text-primary mb-8 leading-none">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                        @if($type == 'roastery' && $product->min_order_kg)
                            <span class="text-sm font-bold text-gray-400">/ Kg</span>
                        @endif
                    </p>

                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8">
                        <h3 class="font-black text-gray-900 uppercase tracking-widest text-xs mb-4">Deskripsi Produk</h3>
                        <p class="text-gray-600 leading-relaxed text-sm whitespace-pre-line">{{ $product->description }}</p>
                    </div>

                    <!-- Shop Info & Action -->
                    <div class="bg-white rounded-3xl p-8 shadow-xl shadow-gray-100 border border-gray-100 mb-8">
                        <div class="flex items-center justify-between mb-8 pb-8 border-b border-gray-50">
                            <div class="flex items-center space-x-4">
                                <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 font-black border border-amber-100 text-xl uppercase shadow-inner">
                                    {{ substr($product->umkm->business_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5 leading-none">Informasi Pemilik Toko</p>
                                    <h4 class="text-lg font-black text-gray-900 leading-tight">{{ $product->umkm->business_name }}</h4>
                                    <p class="text-[10px] font-bold text-gray-500 mt-1 uppercase tracking-tight flex items-center">
                                        <i class="fas fa-map-marker-alt text-amber-500 mr-1.5"></i> {{ Str::limit($product->umkm->address, 40) }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('katalog.umkm', $product->umkm->slug) }}" class="text-xs font-black text-amber-600 hover:text-amber-700 uppercase tracking-widest border-b-2 border-amber-100 hover:border-amber-400 transition pb-0.5">Lihat Toko</a>
                        </div>

                        <div class="flex space-x-4">
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $product->umkm->latitude }},{{ $product->umkm->longitude }}" target="_blank" class="flex-1 bg-gray-900 text-white font-black py-5 rounded-2xl shadow-2xl hover:bg-black transition transform active:scale-95 flex items-center justify-center gap-3">
                                <i class="fas fa-directions text-lg opacity-80"></i>
                                <div class="text-left leading-none">
                                    <span class="block text-[10px] uppercase tracking-widest opacity-50 font-bold">Ambil Rute ke Toko</span>
                                    <span class="text-base uppercase tracking-tight">Pesan di Lokasi</span>
                                </div>
                            </a>
                            <button class="w-16 h-16 bg-gray-50 text-gray-400 rounded-2xl hover:text-red-500 hover:bg-red-50 transition flex items-center justify-center transform active:scale-95 border border-transparent hover:border-red-100">
                                <i class="far fa-heart text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-gray-100 mb-20">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16 mb-20">
                <!-- Reviews Section -->
                <div class="lg:col-span-2 space-y-10">
                    <div>
                        <h2 class="text-3xl font-black text-gray-900 mb-2">Suara Pelanggan</h2>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Apa kata mereka tentang {{ $product->umkm->business_name }}</p>
                    </div>

                    <!-- Review Form -->
                    @auth
                    @if(auth()->user()->role == 'public')
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 overflow-hidden relative group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 blur-3xl"></div>
                        <h3 class="font-black text-gray-900 mb-6 flex items-center relative z-10">
                            <i class="fas fa-edit text-primary mr-3 text-sm"></i> Berikan Ulasan
                        </h3>
                        <form action="{{ route('product.review.store', ['type' => $type, 'id' => $product->id]) }}" method="POST">
                            @csrf
                            <div class="mb-6 relative z-10">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block">Rating Bintang</label>
                                <div class="flex space-x-2" x-data="{ rating: 0, hover: 0 }">
                                    <template x-for="i in 5">
                                        <button type="button" @click="rating = i" @mouseenter="hover = i" @mouseleave="hover = 0" class="text-2xl transition transform hover:scale-125 focus:outline-none">
                                            <i class="fas fa-star" :class="(hover || rating) >= i ? 'text-amber-500' : 'text-gray-100'"></i>
                                        </button>
                                    </template>
                                    <input type="hidden" name="rating" :value="rating" required>
                                </div>
                            </div>
                            <div class="mb-8 relative z-10">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block font-bold">Komentar Anda</label>
                                <textarea name="comment" rows="4" class="w-full border-gray-100 bg-gray-50 rounded-2xl focus:ring-2 focus:ring-primary focus:bg-white focus:border-transparent transition" placeholder="Bagikan pengalaman Anda menggunakan produk ini..." required></textarea>
                            </div>
                            <button type="submit" class="bg-primary text-white font-black px-8 py-4 rounded-xl shadow-xl shadow-primary/20 hover:bg-orange-600 transition flex items-center relative z-10 transform active:scale-95">
                                Kirim Ulasan <i class="fas fa-paper-plane ml-3 text-xs opacity-70"></i>
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 text-center italic text-gray-400 text-sm">
                        Fitur ulasan hanya tersedia untuk akun Pengguna Publik.
                    </div>
                    @endif
                    @else
                    <div class="bg-orange-50 rounded-3xl p-10 border border-orange-100 text-center">
                        <i class="fas fa-lock text-orange-200 text-3xl mb-4 block"></i>
                        <p class="font-bold text-orange-900 mb-4">Ingin memberikan ulasan?</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-orange-600 text-white font-black rounded-xl shadow-lg hover:bg-orange-700 transition">
                            Login Member Sekarang <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                    @endauth

                    <!-- Review List -->
                    <div class="space-y-6">
                        @forelse($reviews as $review)
                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-start space-x-6">
                            <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center font-black text-gray-400 uppercase border border-white">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-center mb-2">
                                    <p class="font-black text-gray-900">{{ $review->user->name }}</p>
                                    <div class="text-amber-500 text-xs">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-gray-100' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">{{ $review->created_at->diffForHumans() }}</p>
                                <p class="text-gray-600 text-sm leading-relaxed">{{ $review->comment }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-20 opacity-20 flex flex-col items-center">
                            <i class="fas fa-comments text-6xl mb-4"></i>
                            <p class="font-bold uppercase tracking-widest text-sm">Belum ada ulasan untuk UMKM ini</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Related Products Section -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-xl font-black text-gray-900 mb-1">Produk Terkait</h2>
                        <div class="w-12 h-1 bg-primary rounded-full mb-8"></div>
                    </div>

                    <div class="flex flex-col space-y-6">
                        @forelse($relatedProducts as $related)
                        <a href="{{ route('product.show', ['type' => $type, 'slug' => $related->slug]) }}" class="group bg-white p-4 rounded-3xl shadow-sm border border-gray-50 flex items-center space-x-4 hover:shadow-xl hover:border-primary/20 transition duration-500">
                            <img src="{{ $related->photo ? asset('storage/'.$related->photo) : 'https://placehold.co/100x100?text=Kopi' }}" class="w-20 h-20 rounded-2xl object-cover border group-hover:scale-105 transition duration-500" alt="{{ $related->name }}">
                            <div class="flex-1">
                                <h4 class="font-black text-gray-900 text-sm group-hover:text-primary transition line-clamp-1">{{ $related->name }}</h4>
                                <p class="text-xs font-black text-primary mt-1">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                <div class="flex items-center mt-2 space-x-3">
                                    <span class="text-[8px] font-bold text-gray-400 flex items-center uppercase tracking-widest">
                                        <i class="fas fa-eye mr-1 opacity-50"></i> {{ $related->views }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        @empty
                        <p class="text-xs italic text-gray-400">Tidak ada produk terkait.</p>
                        @endforelse
                    </div>

                    <!-- Sidebar Banner -->
                    <div class="bg-gray-900 p-8 rounded-[40px] text-white overflow-hidden relative group">
                        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-primary/20 rounded-full blur-3xl group-hover:scale-150 transition duration-1000"></div>
                        <h3 class="text-2xl font-black mb-4 relative z-10 leading-tight">Penasaran dengan Kebun Kopinya?</h3>
                        <p class="text-sm text-gray-400 mb-8 relative z-10 leading-relaxed font-medium">Buka Peta Komunitas Kopi Temanggung untuk melihat lokasi farm & pengolahan produk ini secara langsung.</p>
                        <a href="/map" class="inline-flex items-center font-black text-primary text-xs uppercase tracking-widest hover:text-white transition relative z-10">
                            Eksplorasi Sekarang <i class="fas fa-arrow-right ml-3 text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')

    <!-- Custom Meta Tags or Scripts if needed -->
</x-app-layout>
