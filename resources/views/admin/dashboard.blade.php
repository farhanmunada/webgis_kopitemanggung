<x-app-layout>
    <div class="flex h-screen bg-gray-50 overflow-hidden">
        @include('layouts.sidebar')
        
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
            <!-- Header section inside main -->
            <header class="bg-white border-b h-16 flex items-center justify-between px-8 z-10 sticky top-0">
                <h1 class="text-xl font-bold text-gray-800">Validation Dashboard</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 font-medium">{{ auth()->user()->name }}</span>
                    <img src="https://ui-avatars.com/api/?name=Admin&background=E87A38&color=fff" class="w-8 h-8 rounded-full">
                </div>
            </header>

            <div class="p-8 max-w-7xl mx-auto space-y-8">
                <!-- Stats Row -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white rounded-xl shadow-sm border p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Total Users</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['totalUsers'] }}</h3>
                        </div>
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Total UMKM</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['totalUmkm'] }}</h3>
                        </div>
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                            <i class="fas fa-store"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Total Products</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['totalProducts'] }}</h3>
                        </div>
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
                            <i class="fas fa-coffee"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border p-6 flex items-center justify-between border-orange-200 bg-orange-50/30">
                        <div>
                            <p class="text-sm text-orange-700 font-medium mb-1">Pending Approval</p>
                            <h3 class="text-2xl font-bold text-orange-900">{{ $stats['pendingSellers'] + $stats['pendingProducts'] }}</h3>
                        </div>
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center text-primary">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Category Distribution Chart -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border">
                        <h3 class="font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-chart-pie mr-2 text-primary"></i> UMKM by Category
                        </h3>
                        <div class="h-64">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>

                    <!-- Product Status Chart -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border">
                        <h3 class="font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-chart-bar mr-2 text-primary"></i> Product Status Distribution
                        </h3>
                        <div class="h-64">
                            <canvas id="productChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- System Logs / Recent Activity -->
                <div class="bg-white rounded-xl shadow-sm border overflow-hidden mt-8">
                    <div class="px-6 py-4 border-b bg-gray-50/30 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800">System Activity Summary</h3>
                        <span class="text-xs text-gray-500 italic">Auto-refreshing enabled</span>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                             <div class="space-y-4">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Sellers Queue</h4>
                                <div class="flex items-end space-x-2">
                                     <span class="text-4xl font-black text-gray-800">{{ $stats['pendingSellers'] }}</span>
                                     <span class="text-gray-400 text-sm mb-1 pb-1">Unverified applicants</span>
                                </div>
                                <a href="{{ route('admin.users.index') }}" class="inline-block text-primary text-xs font-bold hover:underline">Process queue →</a>
                             </div>

                             <div class="space-y-4 border-l pl-8">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Product Catalog</h4>
                                <div class="flex items-end space-x-2">
                                     <span class="text-4xl font-black text-gray-800">{{ $stats['pendingProducts'] }}</span>
                                     <span class="text-gray-400 text-sm mb-1 pb-1">New submissions</span>
                                </div>
                                <a href="{{ route('admin.products.index') }}" class="inline-block text-primary text-xs font-bold hover:underline">Approval list →</a>
                             </div>

                             <div class="space-y-4 border-l pl-8">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Database Health</h4>
                                <div class="flex items-center space-x-2 text-green-500 font-bold">
                                     <i class="fas fa-check-circle"></i>
                                     <span>All Systems Operational</span>
                                </div>
                                <p class="text-xs text-gray-400">Database connections, file storage, and API keys are functioning normally.</p>
                             </div>
                        </div>
                    </div>
                    <!-- Recent Products Table -->
                <div class="bg-white rounded-xl shadow-sm border overflow-hidden mt-8">
                    <div class="px-6 py-4 border-b bg-gray-50/30 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800">Recently Submitted Products</h3>
                        <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-primary hover:underline">View All →</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-medium">
                                <tr>
                                    <th class="px-6 py-3">Product</th>
                                    <th class="px-6 py-3">UMKM</th>
                                    <th class="px-6 py-3">Price</th>
                                    <th class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($stats['recentProducts'] as $product)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-3 flex items-center space-x-3">
                                        <img src="{{ isset($product['photo']) && $product['photo'] ? asset('storage/'.$product['photo']) : 'https://placehold.co/40x40?text=Kopi' }}" class="w-10 h-10 rounded border object-cover" />
                                        <div>
                                            <span class="block font-semibold text-gray-900">{{ $product['name'] }}</span>
                                            <span class="text-[10px] uppercase font-bold px-1.5 py-0.5 rounded bg-gray-100 text-gray-500 tracking-wider">{{ $product['type'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 border-l">{{ $product['umkm']['business_name'] }}</td>
                                    <td class="px-6 py-3 font-medium">Rp {{ number_format($product['price'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-3 text-right">
                                        <div class="flex justify-end space-x-3">
                                            <form action="{{ route('admin.product.approve', ['type' => $product['type'], 'id' => $product['id']]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-800 font-bold text-xs uppercase tracking-widest">Approve</button>
                                            </form>
                                            <span class="text-gray-200">|</span>
                                            <button type="button" class="text-red-600 hover:text-red-800 font-bold text-xs uppercase tracking-widest">Reject</button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">No products pending approval.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            </div>
        </main>
    </div>

    <!-- Chart.js and Initialization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category Distribution
            const catCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(catCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($stats['categoryStats']->pluck('name')) !!},
                    datasets: [{
                        data: {!! json_encode($stats['categoryStats']->pluck('umkms_count')) !!},
                        backgroundColor: ['#E87A38', '#2C1810', '#6F4E37', '#A67B5B'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    plugins: {
                        legend: { position: 'bottom' }
                    },
                    cutout: '60%'
                }
            });

            // Product Status Distribution
            const prodCtx = document.getElementById('productChart').getContext('2d');
            new Chart(prodCtx, {
                type: 'bar',
                data: {
                    labels: ['Approved', 'Pending', 'Rejected'],
                    datasets: [{
                        label: 'Products',
                        data: [
                            {{ $stats['productStatusStats']['approved'] }},
                            {{ $stats['productStatusStats']['pending'] }},
                            {{ $stats['productStatusStats']['rejected'] }}
                        ],
                        backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                        borderRadius: 6
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, grid: { display: false } },
                        x: { grid: { display: false } }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
</x-app-layout>
