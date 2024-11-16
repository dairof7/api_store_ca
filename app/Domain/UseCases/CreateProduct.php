<?php

namespace App\Domain\UseCases;

use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;

class CreateProduct
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(array $data): Product
    {
        $product = new Product($data);
        return $this->productRepository->create($product);
    }
}
