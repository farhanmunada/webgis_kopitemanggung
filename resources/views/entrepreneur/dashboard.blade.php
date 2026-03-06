<x-app-layout>
    <div class="flex h-screen bg-gray-50 overflow-hidden">
        @include('layouts.sidebar')
        
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8 max-w-7xl mx-auto space-y-8">
            <!-- Header section -->
            <header class="flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Dashboard Statistik</h1>
                    <p class="text-gray-500 mt-2">Analisis performa bisnis dan interaksi pelanggan Anda.</p>
                </div>
                <div class="flex items-center space-x-3 bg-white p-2 rounded-xl border shadow-sm">
                    <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-store"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kategori Usaha</p>
                        <p class="text-sm font-black text-gray-900 leading-none">{{ $umkm->category->name }}</p>
                    </div>
                </div>
            </header>

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat Card 1: Total Products -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg">Real-time</span>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['total_products'] }}</p>
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mt-1">Total Produk</p>
                    <div class="mt-4 pt-4 border-t flex items-center text-xs text-gray-500">
                        <i class="fas fa-clock mr-1"></i> {{ $stats['pending_approval'] }} menunggu persetujuan
                    </div>
                </div>

                <!-- Stat Card 2: Total Views -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xl">
                            <i class="fas fa-eye"></i>
                        </div>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">Analitik</span>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ number_format($stats['total_views'], 0, ',', '.') }}</p>
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mt-1">Total Kunjungan</p>
                    <div class="mt-4 pt-4 border-t flex items-center text-xs text-gray-500">
                        <i class="fas fa-chart-line mr-1 text-green-500"></i> Performa meningkat
                    </div>
                </div>

                <!-- Stat Card 3: Avg Rating -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center text-xl">
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-900 bg-yellow-100 px-2 py-1 rounded-lg">{{ $stats['avg_rating'] }}/5.0</span>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['avg_rating'] }}</p>
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mt-1">Rating Rata-rata</p>
                    <div class="mt-4 pt-4 border-t flex items-center text-xs text-gray-500">
                        <i class="fas fa-smile mr-1 text-yellow-500"></i> Kepuasan Pelanggan
                    </div>
                </div>

                <!-- Stat Card 4: Total Reviews -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center text-xl">
                            <i class="fas fa-comment-alt"></i>
                        </div>
                        <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-lg">Interaksi</span>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['total_reviews'] }}</p>
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mt-1">Ulasan Masuk</p>
                    <div class="mt-4 pt-4 border-t flex items-center text-xs text-gray-500">
                        <i class="fas fa-paper-plane mr-1"></i> Respon ulasan Anda
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Popular Products -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b bg-gray-50/30 flex justify-between items-center">
                            <h2 class="font-bold text-gray-800 flex items-center">
                                <i class="fas fa-fire text-orange-500 mr-2"></i> Produk Paling Populer
                            </h2>
                            <a href="{{ route('entrepreneur.product.index') }}" class="text-xs font-bold text-primary hover:underline">Lihat Semua</a>
                        </div>
                        <div class="divide-y divide-gray-50">
                            @forelse($popularProducts as $product)
                            <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $product->photo ? asset('storage/'.$product->photo) : 'https://placehold.co/40x40?text=Kopi' }}" class="w-12 h-12 rounded-xl object-cover shadow-sm border" />
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $product->name }}</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $product->type }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black text-gray-900">{{ number_format($product->views, 0, ',', '.') }} views</p>
                                    <p class="text-[10px] text-green-600 font-bold uppercase">Trending</p>
                                </div>
                            </div>
                            @empty
                            <div class="p-8 text-center text-gray-400 italic text-sm">Belum ada data analitik.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Latest Reviews -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b bg-gray-50/30 flex justify-between items-center">
                            <h2 class="font-bold text-gray-800 flex items-center">
                                <i class="fas fa-comments text-blue-500 mr-2"></i> Ulasan Pelanggan Terbaru
                            </h2>
                            <span class="text-[10px] font-black text-orange-600 bg-orange-50 px-2 py-1 rounded-lg uppercase tracking-widest">Feedback</span>
                        </div>
                        <div class="divide-y divide-gray-50">
                            @forelse($latestReviews as $review)
                            <div class="px-6 py-6 hover:bg-gray-50 transition">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 bg-gray-100 rounded-full flex items-center justify-center font-black text-gray-400 text-xs uppercase border border-white">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $review->user->name }}</p>
                                            <p class="text-[10px] text-gray-400 font-medium">{{ $review->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center text-amber-500 text-[10px]">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-gray-100' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 leading-relaxed italic border-l-4 border-gray-100 pl-4">"{{ $review->comment }}"</p>
                            </div>
                            @empty
                            <div class="py-12 text-center">
                                <i class="fas fa-comments text-4xl text-gray-100 mb-4 block"></i>
                                <p class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">Belum ada ulasan masuk.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Quick Actions / Info -->
                <div class="space-y-6">
                    <div class="bg-gray-900 p-6 rounded-2xl shadow-xl text-white relative overflow-hidden group">
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition duration-500"></div>
                        <h3 class="text-lg font-bold mb-2 relative z-10">Tingkatkan Jangkauan!</h3>
                        <p class="text-xs text-gray-400 leading-relaxed mb-6 relative z-10">Gunakan fitur WebGIS untuk memverifikasi lokasi kebun Anda. Produk dengan lokasi terverifikasi mendapatkan 2x lebih banyak kunjungan.</p>
                        <a href="/map" class="inline-flex items-center justify-center px-4 py-2.5 bg-white text-gray-900 rounded-xl font-bold text-xs shadow-lg hover:bg-gray-100 transition relative z-10">
                            Buka Map WebGIS <i class="fas fa-chevron-right ml-2 text-[10px]"></i>
                        </a>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i> Tips Berjualan
                        </h3>
                        <div class="space-y-4">
                            <div class="flex space-x-3">
                                <div class="w-2 h-2 rounded-full bg-orange-400 mt-1.5 flex-shrink-0"></div>
                                <p class="text-xs text-gray-600 leading-relaxed">Gunakan foto produk dengan resolusi tinggi untuk menarik minat pelanggan.</p>
                            </div>
                            <div class="flex space-x-3">
                                <div class="w-2 h-2 rounded-full bg-blue-400 mt-1.5 flex-shrink-0"></div>
                                <p class="text-xs text-gray-600 leading-relaxed">Berikan deskripsi rasa (Tasting Notes) yang mendalam untuk varietas kopi Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="h-10"></div>
        </main>
    </div>
</x-app-layout>
