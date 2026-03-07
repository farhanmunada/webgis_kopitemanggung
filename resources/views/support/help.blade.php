<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pusat Bantuan - Kopi Temanggung</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <x-frontend-navbar activePage="support" />

    <header class="bg-coffee-900 py-20 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
        <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-black mb-6">Pusat Bantuan</h1>
            <p class="text-coffee-200 text-lg font-medium">Punya pertanyaan seputar produk kopi atau cara bergabung menjadi mitra kami? Cari jawabannya di sini.</p>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-16">
        <div class="space-y-12">
            <!-- FAQ Section -->
            <section>
                <h2 class="text-2xl font-black text-gray-900 mb-8 flex items-center">
                    <i class="fas fa-question-circle text-amber-500 mr-3"></i> Pertanyaan Umum (FAQ)
                </h2>
                <div class="space-y-4">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-2">Bagaimana cara mendaftar sebagai mitra UMKM?</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Anda dapat mendaftar melalui tombol "Daftar Jadi Penjual" di footer atau navigasi. Setelah mendaftar akun, penuhi data profil UMKM Anda dan tunggu verifikasi dari admin.</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-2">Apakah ada biaya untuk bergabung di Kopi Temanggung?</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Saat ini pendaftaran dan penggunaan platform WebGIS Kopi Temanggung tidak dipungut biaya bagi seluruh pelaku usaha kopi di wilayah Kabupaten Temanggung.</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-2">Bagaimana cara memperbarui lokasi kebun/toko di peta?</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Anda dapat mengatur koordinat lokasi melalui dashboard Entrepreneur pada menu "Profil Toko". Masukkan titik latitude dan longitude yang akurat agar pelanggan mudah menemukan lokasi Anda.</p>
                    </div>
                </div>
            </section>

            <!-- Contact Support -->
            <section class="bg-amber-50 rounded-3xl p-10 border border-amber-100">
                <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 mb-2">Masih butuh bantuan?</h2>
                        <p class="text-gray-600 font-medium">Tim CS kami siap membantu Anda setiap Senin - Jumat jam 08.00 - 16.00 WIB.</p>
                    </div>
                    <a href="https://wa.me/628123456789" class="bg-gray-900 text-white px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-amber-600 transition shadow-xl shadow-amber-900/10">
                        Hubungi WhatsApp
                    </a>
                </div>
            </section>
        </div>
    </main>

    <x-footer />
</body>
</html>
