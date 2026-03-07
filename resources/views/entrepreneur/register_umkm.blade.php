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

                        <!-- Documents Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="space-y-1">
                                <x-input-label for="ktp_file" :value="__('Scan KTP (Owner)')" class="text-[10px] font-black text-gray-500 uppercase tracking-widest" />
                                <input id="ktp_file" name="ktp_file" type="file" class="block w-full text-[10px] text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[9px] file:font-black file:bg-white file:text-gray-700 shadow-sm" required />
                            </div>
                            <div class="space-y-1">
                                <x-input-label for="nib_file" :value="__('Scan NIB (Opsi)')" class="text-[10px] font-black text-gray-500 uppercase tracking-widest" />
                                <input id="nib_file" name="nib_file" type="file" class="block w-full text-[10px] text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[9px] file:font-black file:bg-white file:text-gray-700 shadow-sm" />
                            </div>
                            <p class="col-span-full text-[9px] text-gray-400 font-medium italic"><i class="fas fa-info-circle mr-1"></i> Data dokumen ini hanya digunakan untuk validasi kredibilitas usaha oleh Admin.</p>
                        </div>

                        <div class="space-y-1">
                            <x-input-label for="address" :value="__('Alamat Lengkap')" class="text-xs font-bold text-gray-600" />
                            <x-text-input id="address" name="address" type="text" class="block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl h-10 text-sm" :value="old('address')" required placeholder="Jl. Raya Temanggung No. XX..." />
                        </div>

                        <div class="space-y-2">
                            <x-input-label :value="__('Pilih Lokasi di Peta')" class="text-xs font-bold text-gray-600" />
                            <div id="map" class="h-64 w-full rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 overflow-hidden relative z-0"></div>
                            <p class="text-[10px] text-orange-600 font-bold italic"><i class="fas fa-info-circle mr-1"></i> Klik pada peta untuk menentukan titik koordinat usaha Anda.</p>
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                            @error('latitude') <p class="text-[10px] text-red-500 font-bold mt-1">Silakan tentukan lokasi pada peta.</p> @enderror
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
        </div>
    </div>

    <!-- Leaflet Assets -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Default center: Temanggung
            const map = L.map('map').setView([-7.3275, 110.1744], 12);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            let marker;
            
            // Handle existing old values
            const oldLat = document.getElementById('latitude').value;
            const oldLng = document.getElementById('longitude').value;
            
            if (oldLat && oldLng) {
                const pos = [oldLat, oldLng];
                marker = L.marker(pos).addTo(map);
                map.setView(pos, 15);
            }

            map.on('click', function(e) {
                const lat = e.latlng.lat.toFixed(8);
                const lng = e.latlng.lng.toFixed(8);
                
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                
                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }
            });
        });
    </script>
</x-app-layout>
