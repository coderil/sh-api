<?php

namespace Database\Factories;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    protected $model = Product::class;

    public function definition(): array
    {
        $categories = ['Technology', 'Clothing', 'Food', 'Health', 'Hardware'];

        return [
            'name' => fake()->word(),
            'price' => fake()->numberBetween(100, 1000),
            'description' => fake()->sentence(),
            'category' => fake()->randomElement($categories),
            'stocks' => 100
        ];
    }
}
