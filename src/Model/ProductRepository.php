<?php


namespace App\Model;


use App\Document\Product;

interface ProductRepository
{
    public function save(Product $product): void;

    /**
     * @return Product[]
     */
    public function findAll(): array;

    public function find(string $id): ?Product;

    public function remove(Product $product): void;

}