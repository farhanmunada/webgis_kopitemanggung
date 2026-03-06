<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntrepreneurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Entrepreneur User
        $user = \App\Models\User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad@contoh.com',
            'password' => bcrypt('password'),
            'role' => 'umkm',
            'status' => 'active',
        ]);

        // Linked UMKM Profile
        $umkm = \App\Models\Umkm::create([
            'user_id' => $user->id,
            'category_id' => 1, // Let's say 1 is 'Coffee Shop'
            'business_name' => 'Kedai Kopi Lereng Sumbing',
            'slug' => \Illuminate\Support\Str::slug('Kedai Kopi Lereng Sumbing'),
            'description' => 'Menyajikan kopi asli Temanggung dengan suasana pedesaan.',
            'address' => 'Jl. Lereng Sumbing No.12, Parakan',
            'phone' => '081234567890',
            'operating_hours' => 'Senin-Minggu: 08:00 - 22:00',
            'latitude' => -7.284560,
            'longitude' => 110.076890,
            'status' => 'approved',
        ]);
        // User 2: Roastery
        $user2 = \App\Models\User::create([
            'name' => 'Budi Sangrai',
            'email' => 'budi.roastery@contoh.com',
            'password' => bcrypt('password'),
            'role' => 'umkm',
            'status' => 'active',
        ]);

        \App\Models\Umkm::create([
            'user_id' => $user2->id,
            'category_id' => 2, // Roastery
            'business_name' => 'Sindoro Artisan Roastery',
            'slug' => \Illuminate\Support\Str::slug('Sindoro Artisan Roastery'),
            'description' => 'Spesialis sangrai kopi Temanggung dengan mesin probat.',
            'address' => 'Jl. Pahlawan No.45, Temanggung',
            'phone' => '082111222333',
            'operating_hours' => 'Senin-Sabtu: 09:00 - 17:00',
            'latitude' => -7.319561,
            'longitude' => 110.169434,
            'status' => 'approved',
        ]);

        // User 3: Toko Kopi
        $user3 = \App\Models\User::create([
            'name' => 'Citra Petani',
            'email' => 'citra.tani@contoh.com',
            'password' => bcrypt('password'),
            'role' => 'umkm',
            'status' => 'active',
        ]);

        \App\Models\Umkm::create([
            'user_id' => $user3->id,
            'category_id' => 3, // Toko Kopi
            'business_name' => 'Koperasi Tani Makmur Kledung',
            'slug' => \Illuminate\Support\Str::slug('Koperasi Tani Makmur Kledung'),
            'description' => 'Pengepul dan penjual biji kopi mentah (green bean) langsung dari petani Kledung.',
            'address' => 'Desa Kledung RT 01/RW 02',
            'phone' => '083334445555',
            'operating_hours' => 'Setiap Hari: 07:00 - 15:00',
            'latitude' => -7.300123,
            'longitude' => 110.050456,
            'status' => 'approved',
        ]);
    }
}
