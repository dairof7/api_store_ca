<?php

namespace App\Infrastructure\Framework\Laravel\Controllers;

use App\Domain\UseCases\CreateProduct;
use App\Domain\UseCases\GetProducts;
use App\Domain\UseCases\UpdateProduct;
use App\Domain\UseCases\DeleteProduct;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController
{
    private CreateProduct $createProduct;
    private GetProducts $getProducts;
    private UpdateProduct $updateProduct;
    private DeleteProduct $deleteProduct;

    public function __construct(
        CreateProduct $createProduct,
        GetProducts $getProducts,
        UpdateProduct $updateProduct,
        DeleteProduct $deleteProduct
    ) {
        $this->createProduct = $createProduct;
        $this->getProducts = $getProducts;
        $this->updateProduct = $updateProduct;
        $this->deleteProduct = $deleteProduct;
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $product = $this->createProduct->execute($validated);
        return response()->json($product, 201);
    }

    public function index($id = null)
    {
        $product = $this->getProducts->execute($id);
        return response()->json($product);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $validated = $request->validated();
        $product = $this->updateProduct->execute($id, $validated);
        return response()->json($product);
    }

    public function destroy($id)
    {
        $success = $this->deleteProduct->execute($id);
        if ($success) {
            return response()->json(['message' => 'Product deleted successfully'], 200);
        }

        return response()->json(['message' => 'Product not found'], 404);
    }
}
