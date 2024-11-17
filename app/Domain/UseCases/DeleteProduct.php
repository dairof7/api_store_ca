<?php

namespace App\Domain\UseCases;

use App\Domain\Repositories\ProductRepositoryInterface;

/**
 * DeleteProduct Use Case.
 *
 * This class handles the logic for deleting a product by interacting with the
 * product repository.
 */
class DeleteProduct
{
    private ProductRepositoryInterface $productRepository;

    /**
     * DeleteProduct constructor.
     *
     * @param \App\Domain\Repositories\ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Execute the deletion of a product.
     *
     * This method calls the repository to delete a product by its ID.
     * 
     * @param int $id The ID of the product to be deleted.
     * @return bool True if the product was deleted, false otherwise.
     */
    public function execute(int $id): bool
    {
        return $this->productRepository->delete($id); // Delete the product and return the result
    }
}
