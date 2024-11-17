<?php

namespace App\Domain\UseCases;

use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;

/**
 * CreateProduct Use Case.
 *
 * This class handles the logic for creating a new product by interacting with the
 * product repository and creating a product entity.
 */
class CreateProduct
{
    private ProductRepositoryInterface $productRepository;

    /**
     * CreateProduct constructor.
     *
     * @param \App\Domain\Repositories\ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Execute the creation of a new product.
     *
     * This method receives product data, creates a new product entity, and
     * persists it using the product repository.
     * 
     * @param array $data Product data to create the product.
     * @return \App\Domain\Entities\Product The created product.
     */
    public function execute(array $data): Product
    {
        $product = new Product($data); // Create a product entity from the data
        return $this->productRepository->create($product); // Save the product and return the created product
    }
}
