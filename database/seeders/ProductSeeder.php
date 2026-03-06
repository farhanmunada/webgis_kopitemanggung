<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Umkm;
use App\Models\ProductBeverage;
use App\Models\ProductRoastery;
use App\Models\ProductBean;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ambil UMKM Coffee Shop (Ahmad Fauzi)
        $coffeeShop = Umkm::where('business_name', 'Kedai Kopi Lereng Sumbing')->first();
        if ($coffeeShop) {
            ProductBeverage::create([
                'umkm_id' => $coffeeShop->id,
                'name' => 'Kopi Susu Gula Aren Asli',
                'slug' => Str::slug('Kopi Susu Gula Aren Asli') . '-' . uniqid(),
                'drink_type' => 'signature',
                'temperature' => 'iced',
                'size_options' => 'Regular / Large',
                'is_customizable' => true,
                'price' => 20000,
                'stock' => 50,
                'description' => 'Minuman signature kopi susu dengan gula aren organik.',
                'status' => 'approved',
            ]);
            
            ProductBeverage::create([
                'umkm_id' => $coffeeShop->id,
                'name' => 'V60 Temanggung Arabica',
                'slug' => Str::slug('V60 Temanggung Arabica') . '-' . uniqid(),
                'drink_type' => 'manual_brew',
                'temperature' => 'hot',
                'price' => 18000,
                'stock' => 100,
                'description' => 'Seduhan manual dengan biji kopi pilihan dari lereng Sumbing.',
                'status' => 'approved',
            ]);
        }

        // 2. Ambil UMKM Roastery (Budi Sangrai)
        $roastery = Umkm::where('business_name', 'Sindoro Artisan Roastery')->first();
        if ($roastery) {
            ProductRoastery::create([
                'umkm_id' => $roastery->id,
                'name' => 'Jasa Roasting Premium',
                'slug' => Str::slug('Jasa Roasting Premium') . '-' . uniqid(),
                'service_type' => 'jasa_roasting',
                'variety' => 'Arabica / Robusta',
                'min_order_kg' => 5,
                'price' => 25000,
                'stock' => 999,
                'description' => 'Jasa roasting kopi dengan mesin Probat. Hasil konsisten dan merata.',
                'status' => 'approved',
            ]);

            ProductRoastery::create([
                'umkm_id' => $roastery->id,
                'name' => 'Fullwash Arabica Roasted Bean',
                'slug' => Str::slug('Fullwash Arabica Roasted Bean') . '-' . uniqid(),
                'service_type' => 'biji_sangrai',
                'variety' => 'Arabica',
                'origin' => 'Sindoro',
                'process' => 'washed',
                'roast_level' => 'medium',
                'weight_gram' => 250,
                'price' => 65000,
                'stock' => 20,
                'description' => 'Biji kopi sangrai kualitas premium.',
                'status' => 'approved',
            ]);
        }

        // 3. Ambil UMKM Toko Kopi (Citra Petani)
        $tokoKopi = Umkm::where('business_name', 'Koperasi Tani Makmur Kledung')->first();
        if ($tokoKopi) {
            ProductBean::create([
                'umkm_id' => $tokoKopi->id,
                'name' => 'Arabica Posong Green Bean',
                'slug' => Str::slug('Arabica Posong Green Bean') . '-' . uniqid(),
                'bean_status' => 'green_bean',
                'variety' => 'Arabica',
                'origin' => 'Posong, Kledung',
                'process' => 'washed',
                'weight_gram' => 1000,
                'altitude_masl' => 1400,
                'price' => 95000,
                'stock' => 200,
                'description' => 'Biji kopi mentah (green bean) Arabica dari posong kualitas ekspor.',
                'status' => 'approved',
            ]);
        }
    }
}
