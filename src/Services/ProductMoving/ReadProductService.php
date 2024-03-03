<?php
declare(strict_types=1);

namespace App\Services\ProductMoving;

use App\Collections\Collection;
use App\Models\Product;
use App\Models\Storage;
use App\Services\Contracts\ServiceInterface;
use App\Services\ProductMoving\Repositories\ReadProductRepository;

class ReadProductService implements ServiceInterface
{
    public function __construct(
        private ReadProductRepository $repository,
        private ProductCollection $productCollection,
    ) {}
    public function getById(int $id): Product
    {
    }

    public function getAll(): Collection
    {
    }

    public function movingProduct(Product $product, Storage $storage): Product
    {
    }

    private function make(): Product
    {

    }

}
