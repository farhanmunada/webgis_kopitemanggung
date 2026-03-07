<x-app-layout>
    <div class="flex h-screen bg-gray-50 overflow-hidden">
        @include('layouts.sidebar')
        
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
            <header class="bg-white border-b h-16 flex items-center justify-between px-8 z-10 sticky top-0">
                <h1 class="text-xl font-bold text-gray-800">User & Seller Management</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 font-medium">{{ auth()->user()->name }}</span>
                    <img src="https://ui-avatars.com/api/?name=Admin&background=E87A38&color=fff" class="w-8 h-8 rounded-full">
                </div>
            </header>

            <div class="p-8 max-w-7xl mx-auto space-y-8">
                @if(session('success'))
                    <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- UMKM / Seller List -->
                <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                    <div class="px-6 py-5 border-b flex justify-between items-center bg-gray-50/50">
                        <h2 class="font-bold text-gray-800 text-lg">Seller Validation List</h2>
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ count($allUmkms) }} Total Sellers</span>
                    </div>
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-medium">
                            <tr>
                                <th class="px-6 py-4">Applicant / Business</th>
                                <th class="px-6 py-4">Category</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($allUmkms as $umkm)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-orange-100 text-primary flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($umkm->user->name, 0, 1) }}{{ substr($umkm->user->name, -1) }}
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-900 block">{{ $umkm->user->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $umkm->business_name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-md text-xs font-semibold">
                                        {{ $umkm->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($umkm->status == 'approved')
                                        <span class="text-green-600 font-bold text-xs"><i class="fas fa-check-circle mr-1"></i> Approved</span>
                                    @elseif($umkm->status == 'pending')
                                        <span class="text-orange-500 font-bold text-xs"><i class="fas fa-clock mr-1"></i> Pending</span>
                                    @else
                                        <span class="text-red-500 font-bold text-xs"><i class="fas fa-times-circle mr-1"></i> Rejected</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($umkm->status == 'pending')
                                        <a href="{{ route('admin.umkm.show', $umkm->id) }}" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-orange-700 transition shadow-lg shadow-orange-100">
                                            Review Application <i class="fas fa-arrow-right ml-2"></i>
                                        </a>
                                    @else
                                        <div class="flex flex-col items-end">
                                            <a href="{{ route('admin.umkm.show', $umkm->id) }}" class="text-[10px] font-black text-primary hover:underline uppercase tracking-widest">Detail View</a>
                                            <span class="text-[9px] text-gray-400 italic">Verified {{ $umkm->updated_at->format('d/m/y') }}</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">No UMKM found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- All Users List -->
                <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                    <div class="px-6 py-5 border-b bg-gray-50/50">
                        <h2 class="font-bold text-gray-800 text-lg">System Users</h2>
                    </div>
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-medium">
                            <tr>
                                <th class="px-6 py-4">User</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($allUsers as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-xs">
                                    <span class="px-2 py-0.5 rounded-full {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ strtoupper($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
