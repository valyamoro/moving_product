<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\Models\Product;
use App\Models\ProductStorage;
use App\Models\Storage;
use App\Services\BaseService;

class ProductService extends BaseService
{
    public function getAllAboutProduct(Product $product, ProductStorage $storage): void
    {
        $storage->setPastQuantityFrom($this->repository->getQuantityProductInStorage(
            $product->getId(),
            $storage->getFromId(),
        ));
        $storage->setPastQuantityTo($this->repository->getQuantityProductInStorage(
            $product->getId(),
            $storage->getToId(),
        ));

        $storage->setQuantityDifferenceInCurrent($storage->getPastQuantityFrom() - $storage->getMoveQuantity());
        $storage->setQuantitySumInCurrent($storage->getPastQuantityTo() + $storage->getPastQuantityFrom());

        if ($storage->getPastQuantityTo() === 0) {
            $storage->setIsAdd(true);
            $storage->setQuantityCurrentIn($storage->getQuantityDifferenceInCurrent());
        } else {
            $storage->setIsAdd(false);
            $storage->setQuantityCurrentIn($storage->getQuantitySumInCurrent());
        }
    }

    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function getById(int $id): array
    {
        return $this->repository->getById($id);
    }

    public function getQuantityProductInStorage(int $productId, int $storageId): int
    {
        return $this->repository->getQuantityProductInStorage($productId, $storageId);
    }

}
