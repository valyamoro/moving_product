<?php
declare(strict_types=1);

namespace App\Services\ProductMovement;

use App\Models\Product;
use App\Models\Storage;
use App\Services\BaseService;

class ProductMovementService extends BaseService
{
    public function moveProduct(Product $product, Storage $storage): void
    {
        if (false === $storage->getIsAdd()) {
            if ($product->getQuantityFromStorage() <= $product->getQuantity()) {
                $this->repository->deleteProduct($product->getId(), $storage->getFromId());
            } else {
                $this->repository->updateProduct(
                    $product->getQuantityDifferenceInCurrentStorage(),
                    $product->getId(),
                    $storage->getFromId(),
                );
            }
            $this->repository->updateProduct(
                $product->getQuantitySumInCurrentStorage(),
                $product->getId(),
                $storage->getToId(),
            );
        } else {
            if ($product->getQuantityCurrentInStorage() === 0) {
                $this->repository->deleteProduct($product->getId(), $storage->getFromId());
            } else {
                $this->repository->updateProduct(
                    $product->getQuantityCurrentInStorage(),
                    $product->getId(),
                    $storage->getFromId(),
                );
            }

            $this->repository->addProduct($product->getId(), $storage->getToId(), $product->getQuantity());
        }
    }

    public function getNeedDataAboutProduct(Product $product, Storage $storage): array
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
        $product->setQuantitySumInCurrentStorage($product->getPastQuantityFromStorage() + $product->getQuantity());

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

}
