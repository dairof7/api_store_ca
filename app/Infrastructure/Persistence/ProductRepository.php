<?php

namespace App\Infrastructure\Persistence;

use App\Models\Product as modelProduct;
use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * ProductRepository
 *
 * This class implements the ProductRepositoryInterface and interacts with the database to
 * manage the persistence of Product entities.
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Create a new product.
     *
     * This method persists a new product in the database and returns the Product entity.
     *
     * @param Product $product The product entity to create.
     * @return Product The created product entity.
     */
    public function create(Product $product): Product
    {
        $model = modelProduct::create([
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'category' => $product->category,
        ]);

        // Convert Eloquent model to domain entity
        return new Product([
            'id' => $model->id,
            'name' => $model->name,
            'description' => $model->description,
            'price' => $model->price,
            'category' => $model->category,
            'created_at' => $model->created_at,
        ]);
    }

    /**
     * Retrieve all products.
     *
     * This method fetches all products from the database and returns an array of Product entities.
     *
     * @return array An array of Product entities.
     */
    public function getAll(): array
    {
        $products = modelProduct::all();

        return $products->map(function ($product) {
            return new Product([
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'category' => $product->category,
                'created_at' => $product->created_at,
            ]);
        })->toArray();
    }

    /**
     * Retrieve a product by its ID.
     *
     * This method finds a product by its ID and returns the corresponding Product entity.
     * If not found, returns null.
     *
     * @param int $id The ID of the product to find.
     * @return Product|null The product entity or null if not found.
     */
    public function getById(int $id): ?Product
    {
        $product = modelProduct::find($id);

        if ($product) {
            return new Product([
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'category' => $product->category,
                'created_at' => $product->created_at,
            ]);
        }

        return null;
    }

    /**
     * Update an existing product.
     *
     * This method updates a product in the database with the provided data and returns
     * the updated Product entity. Throws ModelNotFoundException if the product does not exist.
     *
     * @param int $id The ID of the product to update.
     * @param array $data The updated data for the product.
     * @return Product The updated product entity.
     * @throws ModelNotFoundException If the product does not exist.
     */
    public function update(int $id, array $data): ?Product
    {
        $product = modelProduct::find($id);

        if (!$product) {
            throw new ModelNotFoundException("Product with ID {$id} not found.");
        }

        $product->update($data);

        return new Product([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'category' => $product->category,
            'created_at' => $product->created_at,
        ]);
    }

    /**
     * Delete a product by its ID.
     *
     * This method deletes a product by its ID from the database. Throws ModelNotFoundException
     * if the product does not exist.
     *
     * @param int $id The ID of the product to delete.
     * @return bool True if the product was deleted, false if not found.
     * @throws ModelNotFoundException If the product does not exist.
     */
    public function delete(int $id): bool
    {
        $product = modelProduct::find($id);

        if (!$product) {
            throw new ModelNotFoundException("Product with ID {$id} not found.");
        }

        return $product->delete();
    }
}
