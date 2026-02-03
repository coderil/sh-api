<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductConfiguration;
use App\Models\ProductItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create product item: base model for product combination
        
        //check product variation count
         //if 1, as is direct to product item
         //if 2, combine 

        $products = Product::has('variations')->get();

        foreach($products as $product) {

            $variationCount = $product->variations->count();

            if ($variationCount == 1) {

                $variationOptions = $product->variations()->first()->options;

                foreach($variationOptions as $option) {
                    $productItem = ProductItem::create([
                        'product_id' => $product->id,
                        'price' => fake()->numberBetween(20, 1000),
                        'stocks' => fake()->numberBetween(20, 200)
                    ]);

                    ProductConfiguration::create([
                        'product_item_id' => $productItem->id,
                        'product_variation_id' => $option->product_variation_id,
                        'product_variation_option_id' => $option->id
                    ]);
                }
            } else {

                $firstVariationOptions = $product->variations()->first()->options;
                $secondVariationOptions = $product->variations()->skip(1)->take(1)->first()->options;

                foreach($firstVariationOptions as $firstOption) {
                    
                    foreach($secondVariationOptions as $secondOption) {
                        $productItem = ProductItem::create([
                            'product_id' => $product->id,
                            'price' => fake()->numberBetween(20, 1000),
                            'stocks' => fake()->numberBetween(20, 200)
                        ]);

                        ProductConfiguration::create([
                            'product_item_id' => $productItem->id, 
                            'product_variation_id' => $firstOption->product_variation_id, 
                            'product_variation_option_id' => $firstOption->id
                        ]);

                        ProductConfiguration::create([
                            'product_item_id' => $productItem->id, 
                            'product_variation_id' => $secondOption->product_variation_id, 
                            'product_variation_option_id' => $secondOption->id
                        ]);
                    }
                }
            }
        }
    }
}


// 3 : 3