<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Syarat & Ketentuan - Kopi Temanggung</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white font-sans antialiased text-gray-800">
    <x-frontend-navbar activePage="support" />

    <header class="py-20 border-b border-gray-100">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">Syarat & Ketentuan</h1>
            <div class="w-24 h-1 bg-amber-500 mx-auto rounded-full"></div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-16">
        <article class="prose prose-gray max-w-none text-gray-600 font-medium leading-relaxed space-y-10">
            <section>
                <h2 class="text-2xl font-black text-gray-900 mb-4">1. Ketentuan Umum</h2>
                <p>Dengan mengakses platform Kopi Temanggung, Anda setuju untuk terikat oleh syarat dan ketentuan penggunaan ini, semua hukum dan peraturan yang berlaku, dan setuju bahwa Anda bertanggung jawab untuk kepatuhan terhadap hukum lokal yang berlaku.</p>
            </section>

            <section>
                <h2 class="text-2xl font-black text-gray-900 mb-4">2. Larangan Penggunaan</h2>
                <p>Pengguna dilarang keras untuk:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Mengunggah informasi produk palsu atau menyesatkan.</li>
                    <li>Melakukan tindakan yang dapat merusak integritas sistem WebGIS kami.</li>
                    <li>Menggunakan platform untuk kegiatan ilegal atau yang melanggar hukum di Indonesia.</li>
                    <li>Memanipulasi data rating atau ulasan produk.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-black text-gray-900 mb-4">3. Hak Kekayaan Intelektual</h2>
                <p>Semua konten yang ada di dalam platform ini, termasuk logo, teks, grafis, dan kode program, adalah milik WebGIS Kopi Temanggung dan dilindungi oleh hukum hak cipta Indonesia.</p>
            </section>

            <section class="border-t border-gray-100 pt-10">
                <div class="bg-blue-50 p-6 rounded-2xl flex items-start space-x-4">
                    <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                    <p class="text-sm text-blue-700 italic">Administrasi Kopi Temanggung berhak untuk mengubah syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya. Penggunaan berkelanjutan atas platform menandakan persetujuan Anda atas perubahan tersebut.</p>
                </div>
            </section>
        </article>
    </main>

    <x-footer />
</body>
</html>
