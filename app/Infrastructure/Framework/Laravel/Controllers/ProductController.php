<?php

namespace App\Infrastructure\Framework\Laravel\Controllers;

use App\Domain\UseCases\CreateProduct;
use App\Domain\UseCases\GetProducts;
use App\Domain\UseCases\UpdateProduct;
use App\Domain\UseCases\DeleteProduct;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

/**
 * ProductController
 *
 * This controller handles all HTTP requests related to products,
 * including creating, retrieving, updating, and deleting products.
 */
class ProductController
{
    private CreateProduct $createProduct;
    private GetProducts $getProducts;
    private UpdateProduct $updateProduct;
    private DeleteProduct $deleteProduct;

    /**
     * ProductController constructor.
     *
     * @param CreateProduct $createProduct
     * @param GetProducts $getProducts
     * @param UpdateProduct $updateProduct
     * @param DeleteProduct $deleteProduct
     */
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

    /**
     * Store a new product.
     *
     * Validates the request data and uses the CreateProduct use case to
     * create a new product.
     *
     * @param StoreProductRequest $request The validated product data.
     * @return \Illuminate\Http\JsonResponse The created product.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated(); // Validate the request data
        $product = $this->createProduct->execute($validated); // Create the product
        return response()->json($product, 201); // Return the created product with a 201 status
    }

    /**
     * List all products or get a specific product by ID.
     *
     * If an ID is provided, it retrieves that product. Otherwise, it retrieves all products.
     *
     * @param int|null $id The ID of the product (optional).
     * @return \Illuminate\Http\JsonResponse The product(s).
     */
    public function index($id = null)
    {
        $product = $this->getProducts->execute($id); // Retrieve the product(s)
        return response()->json($product); // Return the product(s)
    }

    /**
     * Update an existing product.
     *
     * Validates the request data and uses the UpdateProduct use case to
     * update the product with the given ID.
     *
     * @param UpdateProductRequest $request The validated data to update the product.
     * @param int $id The ID of the product to update.
     * @return \Illuminate\Http\JsonResponse The updated product.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $validated = $request->validated(); // Validate the request data
        $product = $this->updateProduct->execute($id, $validated); // Update the product
        return response()->json($product, 200); // Return the updated product with a 200 status
    }

    /**
     * Delete a product.
     *
     * Uses the DeleteProduct use case to delete the product with the given ID.
     *
     * @param int $id The ID of the product to delete.
     * @return \Illuminate\Http\JsonResponse The result of the deletion.
     */
    public function destroy($id)
    {
        $success = $this->deleteProduct->execute($id); // Attempt to delete the product
        if ($success) {
            return response()->json(['message' => 'Product deleted successfully'], 200); // Success response
        }

        return response()->json(['message' => 'Product not found'], 404); // Error response if not found
    }
}
