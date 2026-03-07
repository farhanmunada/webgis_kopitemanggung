<x-app-layout>
    <div class="flex h-screen bg-gray-50 overflow-hidden">
        @include('layouts.sidebar')
        
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">
            <!-- Header Navigation -->
            <div class="max-w-7xl mx-auto mb-8 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.users.index') }}" class="w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-900 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-black text-gray-900">Review Aplikasi UMKM</h1>
                        <p class="text-sm text-gray-500 font-medium">Validasi data dan dokumen sebelum memberikan akses pengusaha.</p>
                    </div>
                </div>

                @if($umkm->status === 'pending')
                <div class="flex space-x-3">
                    <div x-data="{ open: false }" class="inline">
                        <button @click="open = true" class="px-6 py-3 bg-red-50 text-red-600 font-bold rounded-2xl border border-red-100 hover:bg-red-600 hover:text-white transition shadow-sm">
                            <i class="fas fa-times-circle mr-2"></i> Reject Submission
                        </button>
                        
                        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;">
                            <div @click.away="open = false" class="bg-white rounded-[32px] p-8 w-full max-w-md shadow-2xl">
                                <h3 class="text-xl font-black text-gray-900 mb-2">Alasan Penolakan</h3>
                                <p class="text-sm text-gray-500 mb-6 font-medium">Berikan alasan yang jelas agar pendaftar dapat memperbaiki data mereka.</p>
                                <form action="{{ route('admin.umkm.reject', $umkm->id) }}" method="POST">
                                    @csrf
                                    <textarea name="rejected_reason" rows="4" class="w-full border-gray-100 bg-gray-50 rounded-2xl text-sm mb-6 p-4 focus:ring-2 focus:ring-red-500 border-none font-medium" placeholder="Contoh: Lokasi pada peta tidak sesuai dengan alamat tertulis..." required></textarea>
                                    <div class="flex justify-end space-x-3">
                                        <button type="button" @click="open = false" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700">Kembali</button>
                                        <button type="submit" class="px-6 py-3 bg-red-600 text-white text-sm font-black rounded-2xl shadow-lg shadow-red-100">Kirim Penolakan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.umkm.approve', $umkm->id) }}" method="POST" onsubmit="return confirm('Setujui UMKM ini?')">
                        @csrf
                        <button type="submit" class="px-8 py-3 bg-green-600 text-white font-black rounded-2xl shadow-lg shadow-green-100 hover:bg-green-700 transition transform active:scale-95">
                            <i class="fas fa-check-circle mr-2"></i> Approve & Activate
                        </button>
                    </form>
                </div>
                @else
                <div class="px-6 py-3 bg-gray-100 rounded-2xl border border-gray-200">
                    <span class="text-xs font-black text-gray-400 uppercase tracking-widest leading-none block mb-1">Status Saat Ini</span>
                    <span class="text-sm font-black {{ $umkm->status === 'approved' ? 'text-green-600' : 'text-red-600' }} uppercase italic tracking-tight">
                        {{ $umkm->status === 'approved' ? 'Disetujui' : 'Ditolak' }} 
                        @if($umkm->status === 'approved') <i class="fas fa-check-circle ml-1"></i> @else <i class="fas fa-times-circle ml-1"></i> @endif
                    </span>
                </div>
                @endif
            </div>

            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Primary Details -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Business Card -->
                        <div class="bg-white rounded-[40px] shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-10 flex flex-col md:flex-row gap-8 items-start">
                                <div class="w-32 h-32 rounded-3xl overflow-hidden shadow-xl flex-shrink-0 bg-gray-100">
                                    @if($umkm->photo)
                                        <img src="{{ asset('storage/'.$umkm->photo) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-orange-50 text-orange-600 text-4xl font-black italic">
                                            {{ substr($umkm->business_name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 space-y-4">
                                    <div>
                                        <div class="flex items-center space-x-3 mb-2">
                                            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest rounded-lg border border-blue-100">{{ $umkm->category->name }}</span>
                                            <span class="text-gray-300">|</span>
                                            <span class="text-xs text-gray-500 font-bold">Terdaftar pada {{ $umkm->created_at->format('d M Y') }}</span>
                                        </div>
                                        <h2 class="text-4xl font-black text-gray-900 tracking-tight">{{ $umkm->business_name }}</h2>
                                    </div>
                                    <p class="text-gray-600 leading-relaxed font-medium italic">{{ $umkm->description }}</p>
                                    
                                    <div class="grid grid-cols-2 gap-6 pt-4">
                                        <div class="bg-gray-50 p-4 rounded-2xl">
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Owner / Pendaftar</p>
                                            <p class="font-bold text-gray-900">{{ $umkm->user->name }}</p>
                                            <p class="text-[11px] text-gray-500 font-medium">{{ $umkm->user->email }}</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-2xl">
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kontak WhatsApp</p>
                                            <p class="font-bold text-gray-900">{{ $umkm->phone }}</p>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->phone) }}" target="_blank" class="text-[11px] text-primary font-black uppercase tracking-widest hover:underline">Chat via WhatsApp →</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Verification Documents -->
                        <div class="bg-white rounded-[40px] shadow-sm border border-gray-100 p-10">
                            <h3 class="text-xl font-black text-gray-900 mb-8 flex items-center uppercase tracking-tight">
                                <i class="fas fa-file-contract text-blue-500 mr-3"></i> Dokumen Verifikasi
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                @forelse($umkm->verificationDocuments as $doc)
                                <div class="group relative bg-gray-50 rounded-3xl p-6 border border-gray-100 hover:border-primary/50 transition duration-500">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-primary text-lg">
                                                <i class="fas {{ $doc->type === 'ktp' ? 'fa-id-card' : 'fa-briefcase' }}"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-xs font-black text-gray-900 uppercase tracking-widest">{{ strtoupper($doc->type) }} Scan</p>
                                                <p class="text-[10px] text-gray-400 font-medium">Original File Uploaded</p>
                                            </div>
                                        </div>
                                        <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-gray-400 hover:text-primary transition">
                                            <i class="fas fa-external-link-alt text-xs"></i>
                                        </a>
                                    </div>
                                    
                                    <div class="aspect-video w-full rounded-2xl overflow-hidden bg-gray-200 border border-gray-100">
                                        @if(in_array(pathinfo($doc->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp']))
                                            <img src="{{ asset('storage/'.$doc->file_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100">
                                                <i class="fas fa-file-pdf text-4xl text-red-400 mb-3"></i>
                                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">PDF Document</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @empty
                                <div class="col-span-full py-10 bg-gray-50 rounded-[32px] border-2 border-dashed border-gray-200 text-center">
                                    <p class="text-sm text-gray-400 font-medium italic">Tidak ada dokumen verifikasi tambahan yang diunggah.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Audit Trail & Notes -->
                        <div class="bg-white rounded-[40px] shadow-sm border border-gray-100 p-10">
                            <h3 class="text-xl font-black text-gray-900 mb-8 flex items-center uppercase tracking-tight">
                                <i class="fas fa-history text-gray-400 mr-3"></i> Riwayat Aktivitas & Catatan
                            </h3>
                            
                            <div class="space-y-6">
                                @forelse($auditTrails as $trail)
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mt-1">
                                        <div class="w-2 h-2 rounded-full bg-gray-300"></div>
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
                                <p class="text-sm text-gray-400 italic">Belum ada riwayat aktivitas.</p>
                                @endforelse
                                
                                @if($umkm->admin_note)
                                <div class="p-6 bg-red-50 rounded-3xl border border-red-100 mt-8">
                                    <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-2">Catatan Penolakan Terakhir</p>
                                    <p class="text-sm text-red-700 font-bold italic leading-relaxed">"{{ $umkm->admin_note }}"</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Map & Location -->
                    <div class="space-y-8">
                        <div class="bg-white rounded-[40px] shadow-sm border border-gray-100 p-8 sticky top-24">
                            <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center uppercase tracking-tight">
                                <i class="fas fa-map-marker-alt text-red-500 mr-3"></i> Verifikasi Lokasi
                            </h3>
                            
                            <div id="map" class="h-64 w-full rounded-3xl border border-gray-100 overflow-hidden relative z-0 mb-6"></div>
                            
                            <div class="space-y-4">
                                <div class="p-4 bg-gray-50 rounded-2xl">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Alamat Tertulis</p>
                                    <p class="text-sm font-bold text-gray-800 leading-relaxed">{{ $umkm->address }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-4 bg-gray-50 rounded-2xl">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Latitude</p>
                                        <p class="text-xs font-black text-gray-900">{{ number_format($umkm->latitude, 6) }}</p>
                                    </div>
                                    <div class="p-4 bg-gray-50 rounded-2xl">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Longitude</p>
                                        <p class="text-xs font-black text-gray-900">{{ number_format($umkm->longitude, 6) }}</p>
                                    </div>
                                </div>
                                
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $umkm->latitude }},{{ $umkm->longitude }}" target="_blank" class="w-full flex items-center justify-center py-4 rounded-2xl bg-gray-900 text-white font-black text-xs uppercase tracking-widest hover:bg-black transition shadow-lg shadow-gray-200">
                                    Buka di Google Maps <i class="fas fa-external-link-alt ml-2 text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="h-20"></div>
        </main>
    </div>

    <!-- Leaflet Assets -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lat = {{ $umkm->latitude }};
            const lng = {{ $umkm->longitude }};
            const map = L.map('map').setView([lat, lng], 15);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup("{{ $umkm->business_name }}")
                .openPopup();
        });
    </script>
</x-app-layout>
