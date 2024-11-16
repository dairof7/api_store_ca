<?php

namespace App\Domain\UseCases;

use App\Domain\Repositories\ProductRepositoryInterface;

class UpdateProduct
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(int $id, array $data)
    {
        return $this->productRepository->update($id, $data);
    }
}
