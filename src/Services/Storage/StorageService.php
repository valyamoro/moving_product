<?php

namespace App\Services\Storage;

use App\Exceptions\ExceptionEmptyQuantityProduct;
use App\Models\Product;
use App\Models\ProductStorage;
use App\Services\BaseService;

class StorageService extends BaseService
{
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function moveProduct(Product $product, ProductStorage $productStorage): bool
    {
        if ($productStorage->getIsMoveProduct()) {
            if ($productStorage->getQuantityCurrentInStorage() <= 0) {
                if (!$this->repository->deleteProduct($product->getId(), $productStorage->getFromStorageId())) {
                    $this->session->setFlash(['error' => 'Товар не удалился со старого склада!']);
                    return false;
                }
            } else {
                if (empty($this->repository->updateProduct(
                    $productStorage->getQuantityCurrentInStorage(),
                    $product->getId(),
                    $productStorage->getFromStorageId(),
                ))) {
                    $this->session->setFlash(['error' => 'Количество товаров не обновилось на старом складе!']);
                    return false;
                }
            }

            if (empty($this->repository->addProduct(
                $product->getId(),
                $productStorage->getToStorageId(),
                $productStorage->getMoveQuantity(),
            ))) {
                $this->session->setFlash(['error' => 'Товар не был перемещен!']);
                return false;
            }
        } else {
            if ($productStorage->getPastQuantityFromStorage() <= $product->getQuantity()) {
                if (!$this->repository->deleteProduct($product->getId(), $productStorage->getFromStorageId())) {
                    $this->session->setFlash(['error' => 'Товар не удалился со старого склада!']);
                    return false;
                }
            } else {
                if (empty($this->repository->updateProduct(
                    $productStorage->getQuantityDifferenceInCurrentStorage(),
                    $product->getId(),
                    $productStorage->getFromStorageId(),
                ))) {
                    $this->session->setFlash(['error' => 'Количество товаров не обновилось на старом складе!']);
                    return false;
                }
            }

            if (empty($this->repository->updateProduct(
                $productStorage->getQuantitySumInCurrentStorage(),
                $product->getId(),
                $productStorage->getToStorageId(),
            ))) {
                $this->session->setFlash(['error' => 'Количество товаров не обновилось на новом складе!']);
                return false;
            }
        }

        return true;
    }

    public function getAllHistoryAboutMovementProduct(int $productId): array
    {
        $result = [];

        $data = $this->repository->getHistoryAboutMovementProduct($productId);
        foreach ($data as $value) {
            if ($value['product_id'] === $productId) {
                $result[] = $value;
            }
        }

        return $result;
    }

    public function saveHistory(int $productId, ProductStorage $productStorage): bool
    {
        return $this->repository->saveHistory($productId, $productStorage);
    }

    public function getInfoAboutProductMovement(Product $product, ProductStorage $productStorage): ProductStorage
    {
        return $this->getNowQuantityProductStorage($product, $productStorage);
    }

}
