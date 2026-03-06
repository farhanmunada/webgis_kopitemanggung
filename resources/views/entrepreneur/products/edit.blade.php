<x-app-layout>
    <div class="flex h-screen bg-gray-50 overflow-hidden">
        @include('layouts.sidebar')
        
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8 max-w-7xl mx-auto space-y-8">
            <!-- Header section -->
            <header class="flex justify-between items-end">
                <div>
                    <a href="{{ route('entrepreneur.product.index') }}" class="text-xs font-bold text-primary hover:underline flex items-center mb-2 uppercase tracking-widest">
                        <i class="fas fa-arrow-left mr-2 font-black"></i> Kembali ke Daftar
                    </a>
                    <h1 class="text-3xl font-extrabold text-gray-900">Edit Produk</h1>
                    <p class="text-gray-500 mt-1 uppercase text-xs font-bold tracking-widest">Kategori: {{ $umkm->category->name }}</p>
                </div>
            </header>

            <!-- Edit Form Wrapper -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
                <form action="{{ route('entrepreneur.product.update', ['type' => $type, 'id' => $product->id]) }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Alert Context -->
                        <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100 flex items-start">
                            <i class="fas fa-info-circle text-blue-600 mr-3 mt-1 text-lg"></i>
                            <div>
                                <p class="text-xs font-bold text-blue-800 uppercase tracking-wider mb-1">Status Produk</p>
                                <p class="text-[11px] text-blue-700 leading-relaxed font-medium">Setelah diperbarui, status produk akan kembali menjadi <strong>Pending</strong> untuk ditinjau ulang oleh Admin.</p>
                            </div>
                        </div>

                        <!-- Current Photo Preview if exists -->
                        @if($product->photo)
                        <div class="mb-6">
                            <x-input-label value="Foto Produk Saat Ini" class="mb-2" />
                            <div class="relative w-32 h-32">
                                <img src="{{ asset('storage/'.$product->photo) }}" class="w-32 h-32 rounded-2xl object-cover border-2 border-gray-100 shadow-sm" />
                                <div class="absolute -bottom-2 -right-2 bg-white rounded-lg shadow-md border px-2 py-1 text-[8px] font-black uppercase text-gray-500">Current</div>
                            </div>
                        </div>
                        @endif

                        <!-- Dynamic Form Content -->
                        <div class="grid grid-cols-1 gap-6">
                            @if($type == 'beverage')
                                @include('entrepreneur.products.forms.beverage', ['product' => $product])
                            @elseif($type == 'roastery')
                                @include('entrepreneur.products.forms.roastery', ['product' => $product])
                            @else
                                @include('entrepreneur.products.forms.bean', ['product' => $product])
                            @endif
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end space-x-3 border-t pt-8">
                        <a href="{{ route('entrepreneur.product.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">Batal</a>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition flex items-center">
                            Simpan Perubahan <i class="fas fa-save ml-2 text-sm opacity-70"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="h-10"></div>
        </main>
    </div>
</x-app-layout>
