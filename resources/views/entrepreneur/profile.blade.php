<x-app-layout>
    <div class="flex h-screen bg-gray-50 overflow-hidden">
        @include('layouts.sidebar')
        
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8 max-w-4xl mx-auto space-y-8">
            <header>
                <h1 class="text-3xl font-extrabold text-gray-900">Pengaturan Profil Toko</h1>
                <p class="text-gray-500 mt-2">Perbarui informasi bisnis dan identitas visual UMKM Anda.</p>
            </header>

            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-400 mr-3"></i>
                    <p class="text-sm text-green-700 font-bold">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <form action="{{ route('entrepreneur.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Visual Identity Card -->
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b bg-gray-50/30">
                        <h2 class="font-bold text-gray-800 flex items-center tracking-tight">
                            <i class="fas fa-image text-amber-500 mr-3"></i> Identitas Visual
                        </h2>
                    </div>
                    <div class="p-8">
                        <div class="flex flex-col md:flex-row items-center gap-10">
                            <div class="relative group">
                                <div class="w-40 h-40 rounded-3xl overflow-hidden border-4 border-white shadow-xl bg-gray-100 flex items-center justify-center text-amber-600 text-5xl font-black uppercase">
                                    @if($umkm->photo)
                                        <img id="preview" src="{{ asset('storage/'.$umkm->photo) }}" class="w-full h-full object-cover">
                                    @else
                                        <div id="placeholder" class="bg-amber-50 w-full h-full flex items-center justify-center">
                                            {{ substr($umkm->business_name, 0, 1) }}
                                        </div>
                                        <img id="preview" class="w-full h-full object-cover hidden">
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 space-y-4 text-center md:text-left">
                                <div>
                                    <label class="block text-sm font-black text-gray-700 uppercase tracking-widest mb-2">Foto Profil / Logo Toko</label>
                                    <p class="text-xs text-gray-500 mb-4 leading-relaxed font-medium">Gunakan foto bangunan toko, logo bisnis, atau suasana tempat usaha Anda. Format: JPG, PNG, WEBP. Maks 2MB.</p>
                                </div>
                                <input type="file" name="photo" id="photoInput" class="hidden" accept="image/*">
                                <button type="button" onclick="document.getElementById('photoInput').click()" class="bg-gray-900 text-white px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-amber-600 transition shadow-lg shadow-gray-200">
                                    Pilih Foto Baru
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Info Card -->
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b bg-gray-50/30">
                        <h2 class="font-bold text-gray-800 flex items-center tracking-tight">
                            <i class="fas fa-store text-blue-500 mr-3"></i> Informasi Bisnis
                        </h2>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest">Nama Bisnis</label>
                                <input type="text" name="business_name" value="{{ old('business_name', $umkm->business_name) }}" class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary font-bold text-gray-800" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest">Kategori</label>
                                <select name="category_id" class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary font-bold text-gray-800" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $umkm->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest">Deskripsi Singkat</label>
                            <textarea name="description" rows="3" class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary font-bold text-gray-800 italic" required>{{ old('description', $umkm->description) }}</textarea>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest">Alamat Lengkap</label>
                            <input type="text" name="address" value="{{ old('address', $umkm->address) }}" class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary font-bold text-gray-800" required>
                        </div>

                        <div class="space-y-4">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest block">Lokasi Geografis (Map Picker)</label>
                            <div id="map" class="h-80 w-full rounded-[32px] border-2 border-dashed border-gray-100 bg-gray-50 overflow-hidden relative z-0"></div>
                            <p class="text-[10px] text-orange-600 font-bold italic"><i class="fas fa-info-circle mr-1"></i> Klik pada peta untuk mengubah titik lokasi usaha Anda.</p>
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $umkm->latitude) }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $umkm->longitude) }}">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-primary text-white px-12 py-5 rounded-2xl font-black text-sm uppercase tracking-[0.2em] hover:bg-coffee-900 transition transform active:scale-95 shadow-xl shadow-orange-100">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
            
            <div class="h-20"></div>
        </main>
    </div>

    <!-- Leaflet Assets -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startLat = {{ $umkm->latitude ?? -7.3275 }};
            const startLng = {{ $umkm->longitude ?? 110.1744 }};
            const map = L.map('map').setView([startLat, startLng], 15);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            let marker = L.marker([startLat, startLng]).addTo(map);

            map.on('click', function(e) {
                const lat = e.latlng.lat.toFixed(8);
                const lng = e.latlng.lng.toFixed(8);
                
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                
                marker.setLatLng(e.latlng);
            });
        });

        document.getElementById('photoInput').onchange = function (evt) {
            const [file] = this.files
            if (file) {
                const preview = document.getElementById('preview');
                const placeholder = document.getElementById('placeholder');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
