<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * @return mixed
     */
    public function getAllCategories(): mixed
    {
        return Category::whereNull('parent_id')->with('Children', 'products')->get();
    }
    /**
     * @param Category $category
     * @return Category
     */
    public function getCategory(Category $category): Category
    {
        return $category->load('children', 'products');
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createCategory(array $data): mixed
    {
        return Category::create($data);
    }

    /**
     * @param Category $category
     * @param array $data
     * @return Category
     */
    public function updateCategory(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }

    /**
     * @param Category $category
     * @return void
     */
    public function deleteCategory(Category $category): void
    {
        $category->delete();
    }
}
