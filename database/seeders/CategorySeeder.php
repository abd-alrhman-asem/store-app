<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        Category::factory()->count(1000)->create()->each(function ($category) {
            if (rand(0, 1)) {
                $category->parent_id = Category::inRandomOrder()->first()->id;
                $category->save();
            }
        });
    }
}
