<?php

namespace App\Domain\UseCases;

use App\Domain\Repositories\ProductRepositoryInterface;

class GetProducts
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(int $id = null)
    {
        if ($id) {
            return $this->productRepository->getById($id);
        }

        return $this->productRepository->getAll();
    }
}
