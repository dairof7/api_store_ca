<?php

namespace App\Domain\UseCases;

use App\Domain\Repositories\ProductRepositoryInterface;

/**
 * GetProducts Use Case.
 *
 * This class handles the logic for retrieving products, either all products or a
 * specific product by ID, by interacting with the product repository.
 */
class GetProducts
{
    private ProductRepositoryInterface $productRepository;

    /**
     * GetProducts constructor.
     *
     * @param \App\Domain\Repositories\ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Execute the retrieval of products.
     *
     * This method either fetches all products or a specific product by its ID.
     * 
     * @param int|null $id The ID of the product to retrieve (optional).
     * @return mixed A single product or a list of all products.
     */
    public function execute(int $id = null)
    {
        if ($id) {
            return $this->productRepository->getById($id); // Fetch a specific product by ID
        }

        return $this->productRepository->getAll(); // Fetch all products
    }
}
