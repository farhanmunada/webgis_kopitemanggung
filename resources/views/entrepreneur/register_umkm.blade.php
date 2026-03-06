<x-app-layout>
    <div class="min-h-screen bg-[#faf9f8] py-8 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
        <div class="max-w-xl w-full">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-14 h-14 bg-orange-100 rounded-2xl text-orange-600 mb-3 shadow-sm">
                    <i class="fas fa-store text-xl"></i>
                </div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight">Daftarkan UMKM Kopi</h1>
                <p class="mt-1 text-xs text-gray-500 font-medium">Lengkapi data usaha Anda dengan ringkas.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
                <form action="{{ route('umkm.register.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
                    @csrf

                    <!-- Section: Profil Bisnis -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2 border-b border-gray-50 pb-3">
                            <span class="w-6 h-6 bg-gray-900 text-white rounded-lg flex items-center justify-center text-[10px] font-bold">01</span>
                            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Profil Bisnis</h2>
                        </div>

                        <div class="space-y-4">
                            <div class="space-y-1">
                                <x-input-label for="business_name" :value="__('Nama Brand')" class="text-xs font-bold text-gray-600" />
                                <x-text-input id="business_name" name="business_name" type="text" class="block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl h-10 text-sm" :value="old('business_name')" required placeholder="Contoh: Kopi Sindoro Artisan" />
                            </div>

                            <div class="space-y-1">
                                <x-input-label for="category_id" :value="__('Kategori')" class="text-xs font-bold text-gray-600" />
                                <select id="category_id" name="category_id" class="block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl h-10 text-sm font-medium pr-10" required>
                                    <option value="" disabled selected>Pilih Kategori...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-1">
                                <x-input-label for="description" :value="__('Deskripsi')" class="text-xs font-bold text-gray-600" />
                                <textarea id="description" name="description" rows="2" class="block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl text-xs p-3" required placeholder="Ceritakan sedikit tentang keunikan usaha Anda...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Lokasi -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2 border-b border-gray-50 pb-3">
                            <span class="w-6 h-6 bg-gray-900 text-white rounded-lg flex items-center justify-center text-[10px] font-bold">02</span>
                            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Kontak & Lokasi</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <x-input-label for="phone" :value="__('WhatsApp')" class="text-xs font-bold text-gray-600" />
                                <x-text-input id="phone" name="phone" type="text" class="block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl h-10 text-sm" :value="old('phone')" required placeholder="08XXXXXXXXXX" />
                            </div>

                            <div class="space-y-1">
                                <x-input-label for="photo" :value="__('Foto Banner')" class="text-xs font-bold text-gray-600" />
                                <input id="photo" name="photo" type="file" class="block w-full text-[10px] text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition cursor-pointer" />
                            </div>
                        </div>

                        <div class="space-y-1">
                            <x-input-label for="address" :value="__('Alamat Lengkap')" class="text-xs font-bold text-gray-600" />
                            <x-text-input id="address" name="address" type="text" class="block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl h-10 text-sm" :value="old('address')" required placeholder="Jl. Raya Temanggung No. XX..." />
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="pt-6 border-t border-gray-50 flex flex-col items-center gap-4">
                        <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white py-3.5 rounded-2xl font-black shadow-lg transition-all transform active:scale-[0.98] flex items-center justify-center group tracking-wide">
                            Kirim Pendaftaran <i class="fas fa-paper-plane ml-2 text-xs group-hover:translate-x-1 group-hover:-translate-y-1 transition duration-300"></i>
                        </button>
                        <p class="text-[10px] text-gray-400 text-center px-4 leading-tight font-medium">
                            Dengan mendaftar, Anda setuju untuk divalidasi oleh tim Kopi Temanggung.
                        </p>
                    </div>
                </form>
    </div>
</x-app-layout>
