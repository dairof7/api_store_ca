<?php

namespace App\Domain\UseCases;

use App\Domain\Repositories\ProductRepositoryInterface;

/**
 * UpdateProduct Use Case.
 *
 * This class handles the logic for updating an existing product by interacting with
 * the product repository.
 */
class UpdateProduct
{
    private ProductRepositoryInterface $productRepository;

    /**
     * UpdateProduct constructor.
     *
     * @param \App\Domain\Repositories\ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Execute the update of a product.
     *
     * This method updates an existing product with the provided data.
     * 
     * @param int $id The ID of the product to update.
     * @param array $data The new data to update the product with.
     * @return mixed The updated product.
     */
    public function execute(int $id, array $data)
    {
        return $this->productRepository->update($id, $data); // Update the product with the given data
    }
}
