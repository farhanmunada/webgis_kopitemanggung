<x-app-layout>
    <div class="flex h-screen bg-gray-50 overflow-hidden">
        @include('layouts.sidebar')
        
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">
            <div class="max-w-7xl mx-auto mb-8 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.products.index') }}" class="w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-900 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-black text-gray-900">Review Submission Produk</h1>
                        <p class="text-sm text-gray-500 font-medium">Validasi detail produk sebelum dipublikasikan ke katalog umum.</p>
                    </div>
                </div>

                @if($product->status === 'pending')
                <div class="flex space-x-3">
                    <div x-data="{ open: false }" class="inline">
                        <button @click="open = true" class="px-6 py-3 bg-red-50 text-red-600 font-bold rounded-2xl border border-red-100 hover:bg-red-600 hover:text-white transition shadow-sm">
                            <i class="fas fa-times-circle mr-2"></i> Reject Product
                        </button>
                        
                        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;">
                            <div @click.away="open = false" class="bg-white rounded-[32px] p-8 w-full max-w-md shadow-2xl">
                                <h3 class="text-xl font-black text-gray-900 mb-2">Alasan Penolakan</h3>
                                <p class="text-sm text-gray-500 mb-6 font-medium">Jelaskan mengapa produk ini belum layak lolos verifikasi.</p>
                                <form action="{{ route('admin.product.reject', ['type' => $type, 'id' => $product->id]) }}" method="POST">
                                    @csrf
                                    <textarea name="rejected_reason" rows="4" class="w-full border-gray-100 bg-gray-50 rounded-2xl text-sm mb-6 p-4 focus:ring-2 focus:ring-red-500 border-none font-medium" placeholder="Contoh: Deskripsi produk kurang detail atau foto tidak jelas..." required></textarea>
                                    <div class="flex justify-end space-x-3">
                                        <button type="button" @click="open = false" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700">Kembali</button>
                                        <button type="submit" class="px-6 py-3 bg-red-600 text-white text-sm font-black rounded-2xl shadow-lg shadow-red-100">Tolak Produk</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.product.approve', ['type' => $type, 'id' => $product->id]) }}" method="POST" onsubmit="return confirm('Setujui produk ini?')">
                        @csrf
                        <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition transform active:scale-95">
                            <i class="fas fa-check-circle mr-2"></i> Approve & Publish
                        </button>
                    </form>
                </div>
                @else
                <div class="px-6 py-3 bg-gray-100 rounded-2xl border border-gray-200">
                    <span class="text-xs font-black text-gray-400 uppercase tracking-widest leading-none block mb-1">Status Saat Ini</span>
                    <span class="text-sm font-black {{ $product->status === 'approved' ? 'text-green-600' : 'text-red-600' }} uppercase italic tracking-tight">
                        {{ $product->status === 'approved' ? 'Active' : 'Rejected' }} 
                        @if($product->status === 'approved') <i class="fas fa-check-circle ml-1"></i> @else <i class="fas fa-times-circle ml-1"></i> @endif
                    </span>
                </div>
                @endif
            </div>

            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Product Visuals & Main Info -->
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-white rounded-[40px] shadow-sm border border-gray-100 p-10">
                            <div class="flex flex-col md:flex-row gap-12">
                                <div class="w-full md:w-80 space-y-4">
                                    <div class="aspect-square rounded-[32px] overflow-hidden shadow-2xl border border-gray-50">
                                        <img src="{{ $product->photo ? asset('storage/'.$product->photo) : 'https://placehold.co/400x400?text=Kopi' }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="p-6 bg-orange-50 rounded-3xl border border-orange-100 text-center">
                                        <p class="text-[10px] font-black text-orange-400 uppercase tracking-widest mb-1">Harga Satuan</p>
                                        <p class="text-3xl font-black text-orange-600 leading-none">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <p class="text-xs text-orange-400 font-bold mt-2 uppercase tracking-tight">Stok Dasar: {{ $product->stock }} Item</p>
                                    </div>
                                </div>
                                <div class="flex-1 space-y-6">
                                    <div>
                                        <div class="flex items-center space-x-2 mb-3">
                                            <span class="px-3 py-1 bg-gray-900 text-white text-[9px] font-black uppercase tracking-widest rounded-lg">{{ $type }}</span>
                                            <span class="text-gray-300">/</span>
                                            <span class="text-xs text-gray-500 font-bold">{{ $product->umkm->category->name }}</span>
                                        </div>
                                        <h2 class="text-4xl font-black text-gray-900 tracking-tight leading-none mb-4">{{ $product->name }}</h2>
                                        <p class="text-gray-600 font-medium leading-relaxed italic text-lg">{{ $product->description ?? 'Tidak ada deskripsi produk.' }}</p>
                                    </div>
                                    
                                    <div class="pt-6 border-t border-gray-100">
                                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Spesifikasi Detail</h3>
                                        <div class="grid grid-cols-2 gap-y-6 gap-x-8">
                                            @if($type === 'beverage')
                                                <div class="space-y-1">
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">Tipe Minuman</p>
                                                    <p class="text-sm font-bold text-gray-800">{{ $product->drink_type }}</p>
                                                </div>
                                                <div class="space-y-1">
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">Suhu Penyajian</p>
                                                    <p class="text-sm font-bold text-gray-800">{{ $product->temperature ?? 'Normal' }}</p>
                                                </div>
                                                <div class="col-span-full space-y-1">
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">Pilihan Ukuran</p>
                                                    <p class="text-sm font-bold text-gray-800">{{ $product->size_options ?? '-' }}</p>
                                                </div>
                                            @else
                                                <div class="space-y-1">
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">Varietas</p>
                                                    <p class="text-sm font-bold text-gray-800">{{ $product->variety ?? 'Mixed' }}</p>
                                                </div>
                                                <div class="space-y-1">
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">Asal (Origin)</p>
                                                    <p class="text-sm font-bold text-gray-800">{{ $product->origin ?? 'Temanggung' }}</p>
                                                </div>
                                                <div class="space-y-1">
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">Proses</p>
                                                    <p class="text-sm font-bold text-gray-800">{{ $product->process ?? '-' }}</p>
                                                </div>
                                                <div class="space-y-1">
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">Level Sangrai</p>
                                                    <p class="text-sm font-bold text-gray-800">{{ $product->roast_level ?? '-' }}</p>
                                                </div>
                                                <div class="space-y-1">
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">Berat Bersih</p>
                                                    <p class="text-sm font-bold text-gray-800">{{ $product->weight_gram }} gram</p>
                                                </div>
                                                @if($type === 'bean')
                                                <div class="space-y-1">
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">Ketinggian</p>
                                                    <p class="text-sm font-bold text-gray-800">{{ $product->altitude_masl ?? '-' }} MASL</p>
                                                </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Audit Trail -->
                        <div class="bg-white rounded-[40px] shadow-sm border border-gray-100 p-10">
                            <h3 class="text-xl font-black text-gray-900 mb-8 flex items-center uppercase tracking-tight">
                                <i class="fas fa-history text-gray-400 mr-3"></i> Penanggung Jawab & Riwayat
                            </h3>
                            <div class="space-y-6">
                                @forelse($auditTrails as $trail)
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mt-1">
                                        <div class="w-1.5 h-1.5 rounded-full bg-gray-400"></div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between">
                                            <p class="text-sm font-black text-gray-900 leading-none">{{ $trail->action }}</p>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $trail->created_at->format('d M, H:i') }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2 font-medium leading-relaxed">{{ $trail->notes }}</p>
                                    </div>
                                </div>
                                @empty
                                <p class="text-sm text-gray-400 italic">Belum ada riwayat aktivitas untuk produk ini.</p>
                                @endforelse
                                
                                @if($product->rejected_reason)
                                <div class="p-6 bg-red-50 rounded-3xl border border-red-100 mt-8">
                                    <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-2">Alasan Penolakan Terakhir</p>
                                    <p class="text-sm text-red-700 font-bold italic leading-relaxed">"{{ $product->rejected_reason }}"</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: UMKM Context -->
                    <div class="space-y-8">
                        <div class="bg-white rounded-[40px] shadow-sm border border-gray-100 p-8 sticky top-24">
                            <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center uppercase tracking-tight">
                                <i class="fas fa-store text-primary mr-3"></i> Tentang UMKM
                            </h3>
                            
                            <div class="flex items-center space-x-4 mb-8">
                                <div class="w-14 h-14 bg-gray-100 rounded-2xl overflow-hidden flex-shrink-0">
                                    @if($product->umkm->photo)
                                        <img src="{{ asset('storage/'.$product->umkm->photo) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-orange-100 text-orange-600 font-black italic">
                                            {{ substr($product->umkm->business_name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="font-black text-gray-900 truncate leading-none mb-1">{{ $product->umkm->business_name }}</h4>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $product->umkm->category->name }}</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Status UMKM</p>
                                    <p class="text-xs font-black {{ $product->umkm->status === 'approved' ? 'text-green-600' : 'text-orange-600' }} italic">
                                        {{ strtoupper($product->umkm->status) }}
                                    </p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kontak Person</p>
                                    <p class="text-xs font-bold text-gray-800">{{ $product->umkm->user->name }}</p>
                                    <p class="text-[10px] text-gray-500 font-medium">{{ $product->umkm->phone }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-8 pt-8 border-t border-gray-100">
                                <a href="{{ route('admin.umkm.show', $product->umkm->id) }}" class="w-full flex items-center justify-center py-4 rounded-2xl bg-gray-50 text-gray-600 font-black text-xs uppercase tracking-widest hover:bg-gray-100 transition border border-gray-100 shadow-sm">
                                    Lihat Profil Lengkap <i class="fas fa-chevron-right ml-2 text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="h-20"></div>
        </main>
    </div>
</x-app-layout>
