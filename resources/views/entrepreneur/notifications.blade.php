<x-app-layout>
    <div class="flex h-screen bg-gray-50 overflow-hidden">
        @include('layouts.sidebar')
        
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8 max-w-4xl mx-auto space-y-8">
            <header>
                <h1 class="text-3xl font-extrabold text-gray-900">Pusat Notifikasi</h1>
                <p class="text-gray-500 mt-2">Pantau status pendaftaran dan approval produk Anda.</p>
            </header>

            <div class="space-y-4">
                @forelse($notifications as $notification)
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-start group hover:shadow-md transition">
                    <div class="w-12 h-12 bg-{{ $notification->data['color'] }}-50 text-{{ $notification->data['color'] }}-600 rounded-2xl flex items-center justify-center text-xl mr-5 flex-shrink-0 group-hover:scale-110 transition">
                        <i class="{{ $notification->data['icon'] }}"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h3 class="font-black text-gray-900 leading-none mb-2">{{ $notification->data['title'] }}</h3>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed font-medium">{{ $notification->data['message'] }}</p>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-3xl p-12 text-center border-2 border-dashed border-gray-100 italic">
                    <i class="fas fa-bell-slash text-4xl text-gray-200 mb-4 block"></i>
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">Belum ada notifikasi baru.</p>
                </div>
                @endforelse

                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            </div>
            
            <div class="h-10"></div>
        </main>
    </div>
</x-app-layout>
