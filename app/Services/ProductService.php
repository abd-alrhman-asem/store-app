<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService
{
    public function getAllProducts(): Collection
    {
        return Product::all();
//        return Product::all()->map(function ($product) {
//            $product->created_from = $product->created_at->diffForHumans();
//            return $product;
//        });
    }

    public function getProductById($id)
    {
        //        $product->created_from = $product->created_at->diffForHumans();
        return Product::findOrFail($id);
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function deleteProduct(Product $product): void
    {
        $product->delete();
    }
}
