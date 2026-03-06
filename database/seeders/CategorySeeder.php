<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Coffee Shop', 'color' => '#8B4513'],
            ['name' => 'Roastery', 'color' => '#A0522D'],
            ['name' => 'Toko Kopi', 'color' => '#D2691E'],
        ];

        foreach ($categories as $cat) {
            \Illuminate\Support\Facades\DB::table('categories')->insert([
                'name' => $cat['name'],
                'slug' => \Illuminate\Support\Str::slug($cat['name']),
                'color' => $cat['color'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
