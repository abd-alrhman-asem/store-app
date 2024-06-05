<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
class CategoryController extends Controller
{
    public function __construct( public CategoryService $categoryService)
    {
    }
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return success($this->categoryService->getAllCategories());
    }
    /**
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->createCategory($request->validated());
        return successOperationResponse(
            'Category created successfully ',
            $category
        );
    }
    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        return success($this->categoryService->getCategory($category));
    }
    /**
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $updatedCategory = $this->categoryService->updateCategory(
            $category,
            $request->validated()
        );
        return successOperationResponse(
            "Category updated successfully ",
            $updatedCategory
        );
    }
    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->categoryService->deleteCategory($category);
        return successOperationResponse( 'category deleted successfully ');
    }
}
