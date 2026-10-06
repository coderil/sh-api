<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesJson = file_get_contents(database_path('seeders/data/categories.json'));
        $categoriesData = json_decode($categoriesJson, true);
        $categoryImagePath = database_path('seeders/data/category_image.png');

        Storage::disk('public')->put('images/category_image.png', file_get_contents($categoryImagePath));

        foreach($categoriesData as $categoryData) {
            $category = Category::create([
                'name'       => $categoryData['name'],
                'image_path' => $categoryImagePath
            ]);

            foreach($categoryData['subcategories'] as $subCategory) {
                $category->subCategories()->create([
                    'name' => $subCategory,
                    'image_path' => $categoryImagePath
                ]);
            }
        }
    }
}
