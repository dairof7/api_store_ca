<?php

namespace App\Domain\Entities;

class Product
{
    public int $id;
    public string $name;
    public string $description;
    public float $price;
    public string $category;
    public string $created_at;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? 2;
        $this->name = $data['name'];
        $this->description = $data['description'] ?? '';
        $this->price = $data['price'];
        $this->category = $data['category'];
        $this->created_at = now();
    }
}
