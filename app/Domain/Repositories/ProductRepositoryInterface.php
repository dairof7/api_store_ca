<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Product;

/**
 * Interface for product operations.
 */
interface ProductRepositoryInterface
{
    public function create(Product $product): Product;
    public function getAll(): array;
    public function getById(int $id): ?Product;
    public function update(int $id, array $data): ?Product;
    public function delete(int $id): bool;
}
