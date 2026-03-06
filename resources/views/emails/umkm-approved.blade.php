<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran UMKM Disetujui</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-w: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; border-top: 5px solid #E87A38;">
        <h2 style="color: #4e342e; text-align: center;">Selamat! Pendaftaran Disetujui</h2>
        <p>Halo, <strong>{{ $umkm->user->name }}</strong>.</p>
        <p>Kami memberitahukan bahwa pendaftaran usaha <strong>{{ $umkm->name }}</strong> Anda telah disetujui oleh tim verifikasi Kopi Temanggung.</p>
        <p>Kini lokasi usaha Anda dapat diakses dan dilihat oleh jutaan pencinta kopi melalui WebGIS Kopi Temanggung. Anda dapat mulai menambahkan katalog produk ke dalam profil usaha Anda melalui Dashboard Entrepreneur.</p>
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ config('app.url') }}/dashboard" style="background-color: #E87A38; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold;">Ke Dashboard Saya</a>
        </div>
        <p style="margin-top: 30px; font-size: 12px; color: #777;">Salam Hangat,<br>Tim Kopi Temanggung</p>
    </div>
</body>
</html>
