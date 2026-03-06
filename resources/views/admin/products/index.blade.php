<x-app-layout>
    <div class="flex h-screen bg-gray-50 overflow-hidden">
        @include('layouts.sidebar')
        
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
            <header class="bg-white border-b h-16 flex items-center justify-between px-8 z-10 sticky top-0">
                <h1 class="text-xl font-bold text-gray-800">Product Approval</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 font-medium">{{ auth()->user()->name }}</span>
                    <img src="https://ui-avatars.com/api/?name=Admin&background=E87A38&color=fff" class="w-8 h-8 rounded-full">
                </div>
            </header>

            <div class="p-8 max-w-7xl mx-auto">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                    <div class="px-6 py-5 border-b flex justify-between items-center bg-gray-50/50">
                        <h2 class="font-bold text-gray-800 text-lg">Product Management List</h2>
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ count($allProducts) }} Total Products</span>
                    </div>
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-medium">
                            <tr>
                                <th class="px-6 py-4">Product Name</th>
                                <th class="px-6 py-4">UMKM</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($allProducts as $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 flex items-center space-x-3">
                                    <img src="{{ isset($product['photo']) && $product['photo'] ? asset('storage/'.$product['photo']) : 'https://placehold.co/40x40?text=Kopi' }}" class="w-10 h-10 rounded border object-cover" />
                                    <div>
                                        <span class="font-semibold text-gray-900 block">{{ $product['name'] }}</span>
                                        <span class="text-[10px] text-white bg-coffee-600 px-1.5 py-0.5 rounded font-bold uppercase tracking-widest">{{ $product['type'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-500">{{ $product['umkm']['business_name'] }}</td>
                                <td class="px-6 py-4">
                                    @if($product['status'] == 'approved')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-[10px] font-bold border border-green-200">APPROVED</span>
                                    @elseif($product['status'] == 'pending')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-[10px] font-bold border border-yellow-200">PENDING</span>
                                    @else
                                        <div class="flex flex-col">
                                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-[10px] font-bold border border-red-200 w-max">REJECTED</span>
                                            @if(isset($product['rejected_reason']))
                                                <span class="text-[10px] text-red-400 mt-1 italic max-w-xs">{{ $product['rejected_reason'] }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($product['status'] == 'pending')
                                        <div class="flex justify-end space-x-2">
                                            <form action="{{ route('admin.product.approve', ['type' => $product['type'], 'id' => $product['id']]) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" title="Approve" class="w-9 h-9 flex items-center justify-center rounded-lg bg-green-600 text-white hover:bg-green-700 transition shadow-sm"><i class="fas fa-check"></i></button>
                                            </form>
                                            <form action="{{ route('admin.product.reject', ['type' => $product['type'], 'id' => $product['id']]) }}" method="POST" class="inline" onsubmit="let r = prompt('Alasan penolakan?'); if(r) { this.rejected_reason.value = r; return true; } return false;">
                                                @csrf
                                                <input type="hidden" name="rejected_reason">
                                                <button type="submit" title="Reject" class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-600 text-white hover:bg-red-700 transition shadow-sm"><i class="fas fa-times"></i></button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="text-gray-400 italic text-[10px] font-medium uppercase tracking-tighter">
                                             Verified At {{ \Carbon\Carbon::parse($product['updated_at'])->format('d M Y') }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">No products found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
