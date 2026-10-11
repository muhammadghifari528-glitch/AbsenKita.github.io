<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $electronics = Category::firstOrCreate([
            'slug' => 'electronics',
        ], [
            'name' => 'Electronics',
        ]);

        $furniture = Category::firstOrCreate([
            'slug' => 'furniture',
        ], [
            'name' => 'Furniture',
        ]);

        $stationery = Category::firstOrCreate([
            'slug' => 'stationery',
        ], [
            'name' => 'Stationery',
        ]);

        Product::firstOrCreate(
            ['name' => 'Laptop Asus VivoBook'],
            [
                'category_id' => $electronics->id,
                'description' => 'Laptop ringan untuk kerja dan belajar.',
                'stock' => 12,
                'price' => 8500000,
                'is_active' => true,
            ]
        );

        Product::firstOrCreate(
            ['name' => 'Meja Kerja Minimalis'],
            [
                'category_id' => $furniture->id,
                'description' => 'Meja kerja dengan desain minimalis modern.',
                'stock' => 8,
                'price' => 1200000,
                'is_active' => true,
            ]
        );

        Product::firstOrCreate(
            ['name' => 'Notebook A5 Premium'],
            [
                'category_id' => $stationery->id,
                'description' => 'Buku catatan premium untuk kebutuhan harian.',
                'stock' => 30,
                'price' => 35000,
                'is_active' => true,
            ]
        );
    }
}
