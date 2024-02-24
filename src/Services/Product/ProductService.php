<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\Models\Product;
use App\Models\Storage;
use App\Services\BaseService;

class ProductService extends BaseService
{
    public function getAllAboutProduct(Product $product, Storage $storage): array
    {
        $product->setPastQuantityFromStorage($this->repository->getQuantityProductInStorage(
            $product->getId(),
            $storage->getFromId(),
        ));
        $product->setPastQuantityToStorage($this->repository->getQuantityProductInStorage(
            $product->getId(),
            $storage->getToId(),
        ));

        $product->setQuantityDifferenceInCurrentStorage($product->getPastQuantityFromStorage() - $product->getQuantity());
        $product->setQuantitySumInCurrentStorage($product->getPastQuantityToStorage() + $product->getQuantity());

        if ($product->getPastQuantityToStorage() === 0) {
            $storage->setIsAdd(true);
            $product->setQuantityCurrentStorage($product->getQuantityDifferenceInCurrentStorage());
        } else {
            $storage->setIsAdd(false);
            $product->setQuantityCurrentStorage($product->getQuantitySumInCurrentStorage());
        }

        return [
            'product' => $product,
            'storage' => $storage,
        ];
    }

    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function getTitleById(int $id): string
    {
        return $this->repository->getTitleById($id);
    }

    public function getQuantityProductInStorage(int $productId, int $storageId): int
    {
        return $this->repository->getQuantityProductInStorage($productId, $storageId);
    }

}
