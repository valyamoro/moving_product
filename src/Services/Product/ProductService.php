<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\Models\Product;
use App\Models\ProductStorage;
use App\Models\Storage;
use App\Services\BaseService;

class ProductService extends BaseService
{
    public function getAllAboutProduct(Product $product, ProductStorage $productStorage): void
    {
        $productStorage->setPastQuantityFrom($this->repository->getQuantityProductInStorage(
            $product->getId(),
            $productStorage->getFromId(),
        ));
        $productStorage->setPastQuantityTo($this->repository->getQuantityProductInStorage(
            $product->getId(),
            $productStorage->getToId(),
        ));

        $productStorage->setQuantityDifferenceInCurrent($productStorage->getPastQuantityFrom() - $productStorage->getMoveQuantity());
        $productStorage->setQuantitySumInCurrent($productStorage->getPastQuantityTo() + $productStorage->getPastQuantityFrom());

        if ($productStorage->getPastQuantityTo() === 0) {
            $productStorage->setIsAdd(true);
            $productStorage->setQuantityCurrentIn($productStorage->getQuantityDifferenceInCurrent());
        } else {
            $productStorage->setIsAdd(false);
            $productStorage->setQuantityCurrentIn($productStorage->getQuantitySumInCurrent());
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
