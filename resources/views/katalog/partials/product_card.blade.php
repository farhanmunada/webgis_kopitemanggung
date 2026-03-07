<!-- Premium Card -->
<div class="bg-white rounded-[32px] overflow-hidden shadow-sm border border-gray-100 hover:shadow-2xl hover:border-amber-100 transition duration-500 group">
    <a href="{{ route('product.show', ['type' => $product->type, 'slug' => $product->slug]) }}" class="block">
        <div class="relative h-60 bg-gray-100 overflow-hidden">
            <!-- Badge based on type -->
            @php
                $badgeColor = match($product->type) {
                    'beverage' => 'text-amber-700 border-amber-100 bg-amber-50',
                    'roastery' => 'text-orange-700 border-orange-100 bg-orange-50',
                    'bean' => 'text-emerald-700 border-emerald-100 bg-emerald-50',
                    default => 'text-gray-700 border-gray-100 bg-gray-50'
                };
                $typeName = match($product->type) {
                    'beverage' => 'Coffee Shop',
                    'roastery' => 'Roastery',
                    'bean' => 'Toko Kopi',
                    default => $product->type
                };
            @endphp
            <span class="absolute top-4 left-4 backdrop-blur-sm px-3 py-1.5 text-[10px] font-black rounded-xl uppercase tracking-widest shadow-sm z-10 border {{ $badgeColor }}">{{ $typeName }}</span>
            
            <img src="{{ $product->photo ? asset('storage/'.$product->photo) : 'https://placehold.co/600x400?text='.urlencode($product->name) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
            
            <!-- Floating Category Icon if exists -->
            @if(isset($product->umkm->category))
                <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-xs shadow-sm shadow-black/5 z-10" title="{{ $product->umkm->category->name }}">
                    <i class="fas {{ $product->umkm->category->icon ?? 'fa-store' }} text-amber-900"></i>
                </div>
            @endif

            <div class="absolute inset-x-0 bottom-0 p-6 bg-gradient-to-t from-black/60 to-transparent translate-y-full group-hover:translate-y-0 transition duration-500">
                <span class="text-white text-[10px] font-black uppercase tracking-widest">Detail Produk <i class="fas fa-arrow-right ml-2"></i></span>
            </div>
        </div>
    </a>
    <div class="p-7">
        <div class="mb-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest truncate max-w-[150px]">{{ $product->umkm->business_name }}</p>
                @if($product->views > 0)
                <span class="text-[9px] font-bold text-gray-400 flex items-center">
                    <i class="fas fa-eye mr-1"></i> {{ number_format($product->views) }}
                </span>
                @endif
            </div>
            <a href="{{ route('product.show', ['type' => $product->type, 'slug' => $product->slug]) }}" class="block">
                <h3 class="font-black text-gray-900 text-lg leading-tight hover:text-amber-600 transition h-12 line-clamp-2">{{ $product->name }}</h3>
            </a>
            
            <!-- Metadata for varieties/process -->
            @if(isset($product->variety) || isset($product->process))
                <div class="mt-2 flex flex-wrap gap-1">
                    @if(isset($product->variety))
                        <span class="text-[9px] bg-gray-50 text-gray-500 px-2 py-0.5 rounded-md border border-gray-100">{{ $product->variety }}</span>
                    @endif
                    @if(isset($product->process))
                        <span class="text-[9px] bg-gray-50 text-gray-500 px-2 py-0.5 rounded-md border border-gray-100">{{ $product->process }}</span>
                    @endif
                </div>
            @endif
        </div>
        <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-50">
            <div>
                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Mulai dari</p>
                <span class="text-xl font-black text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            </div>
            <div class="flex space-x-2">
                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $product->umkm->latitude }},{{ $product->umkm->longitude }}" target="_blank" class="w-10 h-10 bg-gray-900 text-white rounded-xl flex items-center justify-center hover:bg-amber-600 transition shadow-lg shadow-gray-200" title="Lokasi Seller">
                    <i class="fas fa-location-dot text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</div>
