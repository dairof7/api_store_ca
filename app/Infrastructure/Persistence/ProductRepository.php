<?php

namespace App\Infrastructure\Persistence;

use App\Models\Product as modelProduct;
use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductRepository implements ProductRepositoryInterface
{
    public function create(Product $product): Product
    {
        $model = modelProduct::create([
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'category' => $product->category,
        ]);

        // Convertir el modelo Eloquent a la entidad de dominio Product
        return new Product([
            'id' => $model->id,
            'name' => $model->name,
            'description' => $model->description,
            'price' => $model->price,
            'category' => $model->category,
            'created_at' => $model->created_at,
        ]);
    }

    public function getAll(): array
    {
        // Usar el modelo Eloquent para obtener todos los productos
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

    public function getById(int $id): ?Product
    {
        // Usar el modelo Eloquent para buscar por ID
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

    public function update(int $id, array $data): ?Product
    {
        // Buscar el producto y actualizar sus datos
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

    public function delete(int $id): bool
    {
        // Buscar el producto y eliminarlo
        $product = modelProduct::find($id);

        if (!$product) {
            throw new ModelNotFoundException("Product with ID {$id} not found.");
        }

        return $product->delete();
    }
}
