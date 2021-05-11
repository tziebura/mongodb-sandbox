<?php


namespace App\Repository;


use App\Document\Product;
use App\Model\ProductRepository;
use Doctrine\ODM\MongoDB\DocumentManager;

class ProductMongoRepository implements ProductRepository
{
    private $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function save(Product $product): void
    {
        $this->dm->persist($product);
        $this->dm->flush();
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return $this->dm->getRepository(Product::class)->findAll();
    }

    public function find(string $id): ?Product
    {
        return $this->dm->getRepository(Product::class)->find($id);
    }

    public function remove(Product $product): void
    {
        $this->dm->remove($product);
        $this->dm->flush();
    }
}