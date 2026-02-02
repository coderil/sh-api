<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $shops = Shop::pluck('id');
        
        for($i = 0; $i < 20; $i++) {
            Product::factory()->create([
                'shop_id' => fake()->randomElement($shops)
            ]);
        }
        
    }
}
