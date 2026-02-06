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
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));

        // $categories = ['Technology', 'Clothing', 'Food', 'Health', 'Hardware'];

        return [
            'name' => $faker->productName(),
            'base_price' => fake()->numberBetween(100, 1000),
            'description' => fake()->sentence(),
            'category' => $faker->category,
            'stocks' => fake()->numberBetween(10, 100)
        ];
    }
}
