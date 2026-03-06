<footer class="bg-white border-t py-12 px-8 mt-16">
    <div class="max-w-[1200px] mx-auto flex flex-col md:flex-row justify-between">
        <div class="mb-8 md:mb-0 max-w-xs">
            <div class="flex items-center space-x-2 mb-4">
                <x-application-logo class="w-6 h-6 text-coffee-800" />
                <span class="font-extrabold text-lg text-gray-900">Kopi Temanggung</span>
            </div>
            <p class="text-gray-500 text-sm">Platform kolaborasi untuk memajukan komoditas kopi lokal Temanggung melalui teknologi GIS dan Marketplace.</p>
        </div>
        
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-8">
            <div>
                <h4 class="font-bold text-gray-900 mb-4">Navigasi</h4>
                <ul class="space-y-2 text-sm text-gray-500 font-medium">
                    <li><a href="/katalog" class="hover:text-primary">Katalog Produk</a></li>
                    <li><a href="/map" class="hover:text-primary">Peta Sebaran</a></li>
                    <li><a href="#" class="hover:text-primary">Profil Petani</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-primary">Daftar Jadi Penjual</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4">Dukungan</h4>
                <ul class="space-y-2 text-sm text-gray-500 font-medium">
                    <li><a href="#" class="hover:text-primary">Pusat Bantuan</a></li>
                    <li><a href="#" class="hover:text-primary">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-primary">Syarat Ketentuan</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4">Kontak</h4>
                <address class="text-sm text-gray-500 not-italic leading-relaxed mb-4 font-medium">
                    Pemerintah Kabupaten Temanggung<br>
                    Jawa Tengah, Indonesia
                </address>
                <div class="flex space-x-3">
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:text-primary"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:text-primary"><i class="far fa-envelope"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-[1200px] mx-auto mt-12 pt-8 border-t border-gray-100 text-center text-xs text-gray-400 font-medium">
        &copy; 2026 Kopi Temanggung WebGIS. All rights reserved.
    </div>
</footer>
