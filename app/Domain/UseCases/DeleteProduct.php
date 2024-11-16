<?php

namespace App\Domain\UseCases;

use App\Domain\Repositories\ProductRepositoryInterface;

class DeleteProduct
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(int $id): bool
    {
        return $this->productRepository->delete($id);
    }
}
