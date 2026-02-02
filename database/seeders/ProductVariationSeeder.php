<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductVariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        
        $availableVariationValues = [
            [
                'name' => 'Color',
                'options' => [
                    'Red', 'Blue', 'Green', 'Yellow', 'Pink', 'White', 'Black'
                ]
            ],
            [
                'name' => 'Size',
                'options' => [
                    'XS','S', 'M', 'L', 'XL', 'XXL', 'XXXL'
                ]
            ],
            [
                'name' => 'Model',
                'options' => [
                    "AeroFlex 200",
                    "NovaLite X3",
                    "QuantumEdge Pro",
                    "EcoStream 500",
                    "VeloMax S7",
                    "CrystalCore Z9",
                    "TitanWave One",
                ]
            ],
            [
                'name' => 'Design',
                'options' => [
                    "Aurora Pattern",
                    "Zenith Lines",
                    "Prism Flow",
                    "Cascade Grid",
                    "Lunar Weave",
                    "Solar Bloom",
                    "Nebula Twist",
                ]
            ],
        ];

        foreach($products as $product) {
            $hasVariation = fake()->boolean();

            if (!$hasVariation) {
                continue;
            }

            $variationCount = fake()->randomElement([1, 2]);
            $variationValues = Arr::random($availableVariationValues, $variationCount);
            
            foreach($variationValues as $value) {
                $productVariation = ProductVariation::create([
                    'product_id' => $product->id,
                    'name' => $value['name']
                ]);

                $optionCount = rand(3, 7);
                $optionValues = Arr::random($value['options'], $optionCount);
                
                foreach($optionValues as $optionValue) {
                    ProductVariationOption::create([
                        'product_variation_id' => $productVariation->id,
                        'name' => $optionValue
                    ]);
                }

            }
        }
    }
}
