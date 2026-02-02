<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Shop;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $categories = ['Technology', 'Clothing', 'Food', 'Health', 'Hardware'];
        $shops = Shop::pluck('id');

        return [
            'shop_id' => fake()->randomElement($shops),
            'name' => fake()->word(),
            'base_price' => fake()->numberBetween(100, 1000),
            'description' => fake()->sentence(),
            'category' => fake()->randomElement($categories),
            'stocks' => 100
        ];
    }
}
