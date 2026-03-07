@php
    $isDark = isset($dark) && $dark;
    $cardBg = $isDark ? 'bg-white/5 border-white/10 hover:bg-white/10' : 'bg-white border-gray-100 hover:border-amber-100 hover:shadow-2xl';
    $textColor = $isDark ? 'text-white' : 'text-gray-900';
    $mutedColor = $isDark ? 'text-emerald-200/60' : 'text-gray-500';
@endphp

<div class="rounded-[40px] overflow-hidden border transition duration-500 group {{ $cardBg }}">
    <div class="relative h-48 overflow-hidden">
        <img src="{{ $umkm->photo ? asset('storage/'.$umkm->photo) : 'https://placehold.co/600x400?text='.urlencode($umkm->business_name) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
        <div class="absolute inset-0 bg-gradient-to-t {{ $isDark ? 'from-emerald-950/80' : 'from-black/60' }} to-transparent opacity-60"></div>
        
        <!-- Category Badge -->
        <span class="absolute top-6 left-6 px-3 py-1.5 {{ $isDark ? 'bg-emerald-500' : 'bg-amber-500' }} text-white text-[10px] font-black rounded-xl uppercase tracking-widest shadow-lg">
            {{ $umkm->category->name }}
        </span>

        <!-- Verification Badge -->
        @if($umkm->geo_verified_at)
        <div class="absolute top-6 right-6 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs shadow-lg" title="Terverifikasi">
            <i class="fas fa-check-circle"></i>
        </div>
        @endif
    </div>

    <div class="p-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center text-amber-500 text-xs">
                <i class="fas fa-star mr-1.5"></i>
                <span class="font-black {{ $textColor }}">{{ $umkm->avg_rating }}</span>
                <span class="{{ $mutedColor }} ml-1 font-bold">({{ count($umkm->reviews) }})</span>
            </div>
            <span class="{{ $mutedColor }} text-[10px] uppercase font-black tracking-widest">{{ count($umkm->getAllProducts()) }} Produk</span>
        </div>

        <h3 class="text-2xl font-black mb-3 leading-tight {{ $textColor }}">{{ $umkm->business_name }}</h3>
        <p class="{{ $mutedColor }} text-sm line-clamp-2 italic mb-8 font-medium leading-relaxed">"{{ $umkm->description }}"</p>
        
        <div class="flex items-center space-x-3 pt-6 border-t {{ $isDark ? 'border-white/10' : 'border-gray-50' }}">
            <a href="{{ route('katalog.umkm', $umkm->slug) }}" class="flex-1 text-center py-4 rounded-2xl font-black text-sm uppercase tracking-widest transition duration-300 {{ $isDark ? 'bg-white text-emerald-900 hover:bg-emerald-100' : 'bg-gray-900 text-white hover:bg-amber-600' }}">
                Lihat Profil
            </a>
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $umkm->latitude }},{{ $umkm->longitude }}" target="_blank" class="w-14 h-14 rounded-2xl flex items-center justify-center transition duration-300 {{ $isDark ? 'bg-emerald-800 text-emerald-100 hover:bg-emerald-700' : 'bg-gray-100 text-gray-500 hover:text-amber-600' }}" title="Lokasi di Map">
                <i class="fas fa-location-dot"></i>
            </a>
        </div>
    </div>
</div>
