<x-app-layout>
    <div x-data="{}" class="flex h-screen bg-gray-50 overflow-hidden">
        @include('layouts.sidebar')
        
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8 max-w-7xl mx-auto space-y-8">
            <!-- Header section -->
            <header class="flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Manajemen Produk</h1>
                    <p class="text-gray-500 mt-2">Kelola daftar produk untuk kategori <strong>{{ $umkm->category->name }}</strong>.</p>
                </div>
                <button @click="$dispatch('open-modal', 'create-product')" class="bg-orange-600 text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-orange-200 hover:bg-orange-700 transition flex items-center transform hover:scale-105">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Produk Baru
                </button>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl flex items-center shadow-sm" role="alert">
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Products Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b bg-gray-50/50 flex justify-between items-center">
                    <h2 class="font-bold text-gray-800 text-lg">Daftar Produk Anda</h2>
                    <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-full text-[10px] font-black uppercase tracking-widest">{{ count($products) }} Items</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-gray-400 text-[10px] uppercase font-black tracking-widest">
                            <tr>
                                <th class="px-6 py-4">Informasi Produk</th>
                                <th class="px-6 py-4">Harga & Stok</th>
                                <th class="px-6 py-4 text-center">Statistik</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($products as $product)
                            <tr class="hover:bg-gray-50/80 transition group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="relative">
                                            <img src="{{ $product->photo ? asset('storage/'.$product->photo) : 'https://placehold.co/40x40?text=Kopi' }}" class="w-12 h-12 rounded-xl shadow-sm border object-cover" />
                                            @if($product->views > 100)
                                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-orange-500 text-white rounded-full flex items-center justify-center text-[8px] border-2 border-white">
                                                <i class="fas fa-fire"></i>
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-900 block group-hover:text-primary transition">{{ $product->name }}</span>
                                            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">{{ $product->type }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-black text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">Stok: <span class="font-bold text-gray-700">{{ $product->stock }}</span></p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold">
                                        <i class="fas fa-eye mr-1.5 opacity-70"></i> {{ $product->views }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->status == 'approved')
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase tracking-tighter shadow-sm border border-green-200">Aktif</span>
                                    @elseif($product->status == 'pending')
                                        <div class="flex flex-col">
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[10px] font-black uppercase tracking-tighter shadow-sm border border-yellow-200 w-max">Pending</span>
                                            <span class="text-[9px] text-gray-400 mt-1 italic tracking-tight">Menunggu Admin</span>
                                        </div>
                                    @else
                                        <div class="flex flex-col">
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-black uppercase tracking-tighter shadow-sm border border-red-200 w-max">Ditolak</span>
                                            @if($product->rejected_reason)
                                                <span class="text-[9px] text-red-400 mt-1 italic tracking-tight font-medium max-w-[120px]">"{{ $product->rejected_reason }}"</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('entrepreneur.product.edit', ['type' => $product->type, 'id' => $product->id]) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm border border-blue-100">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route('entrepreneur.product.destroy', ['type' => $product->type, 'id' => $product->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus produk ini? Tindakan ini tidak dapat dibatalkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition shadow-sm border border-red-100">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3 opacity-40">
                                        <i class="fas fa-box-open text-5xl"></i>
                                        <p class="font-bold text-gray-500">Belum ada produk yang didaftarkan.</p>
                                        <button @click="$dispatch('open-modal', 'create-product')" class="text-sm font-black text-primary hover:underline">Mulai Tambah Produk <i class="fas fa-arrow-right ml-1"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Create Product Modal Content -->
            <x-modal name="create-product" :show="$errors->any()" focusable>
                <form action="{{ route('entrepreneur.product.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    <div class="flex justify-between items-center mb-8 border-b pb-6">
                        <div>
                            <h2 class="text-2xl font-black text-gray-900 leading-none">Tambah Produk Baru</h2>
                            <p class="text-sm text-gray-500 mt-2 uppercase tracking-widest font-bold">Kategori: {{ $umkm->category->name }}</p>
                        </div>
                        <button type="button" @click="$dispatch('close')" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-gray-900 transition bg-gray-50 rounded-xl hover:bg-gray-100">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="space-y-6">
                        <!-- Common Fields Information Header -->
                        <div class="p-4 bg-orange-50 rounded-2xl border border-orange-100 flex items-start">
                            <i class="fas fa-info-circle text-orange-600 mr-3 mt-1 text-lg"></i>
                            <div>
                                <p class="text-xs font-bold text-orange-800 uppercase tracking-wider mb-1">Pemberitahuan</p>
                                <p class="text-[11px] text-orange-700 leading-relaxed font-medium">Lengkapi semua detail produk dengan akurat agar memudahkan verifikasi oleh Admin.</p>
                            </div>
                        </div>

                        <!-- Form Inclusions based on Category -->
                        <div class="grid grid-cols-1 gap-6">
                            @if($umkm->category->slug == 'coffee-shop')
                                @include('entrepreneur.products.forms.beverage')
                            @elseif($umkm->category->slug == 'roastery')
                                @include('entrepreneur.products.forms.roastery')
                            @else
                                @include('entrepreneur.products.forms.bean')
                            @endif
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end space-x-3 border-t pt-8">
                        <button type="button" @click="$dispatch('close')" class="px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">Batal</button>
                        <button type="submit" class="px-6 py-3 bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-100 hover:bg-orange-700 transition flex items-center">
                            Daftarkan Produk <i class="fas fa-check-circle ml-2"></i>
                        </button>
                    </div>
                </form>
            </x-modal>

            <div class="h-10"></div>
        </main>
    </div>

    <!-- Additional required styling for table and icons -->
    <style>
        .group:hover .group-hover\:text-primary { color: #f97316; }
    </style>
</x-app-layout>
