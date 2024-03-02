<?php
declare(strict_types=1);

namespace App\Services\Storage;

use App\Models\Product;
use App\Models\ProductStorage;
use App\Services\BaseService;

class StorageService extends BaseService
{
    public function getMovementProducts(array $productsCollections): array
    {
        $result = [];

        foreach ($productsCollections as $value) {
            $result[$value->getId()] = $this->getMovementProduct($value->getId());
        }

        return $result;
    }

    private function getMovementProduct(int $productId): array
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

    public function getStoragesCollection(array $data): array
    {
        $result = [];

        foreach ($data as $value) {
            $storage = \App\Factory\StorageFactory::create([
                'name' => $value['name'],
            ]);
            $storage->setId($value['storage_id']);

            $result[] = $storage;
        }

        return $result;
    }
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function moveProduct(Product $product, ProductStorage $productStorage): bool
    {
        if ($productStorage->getIsMoveProduct()) {
            if ($productStorage->getQuantityCurrentInStorage() <= 0) {
                if (!$this->repository->deleteProduct($product->getId(), $productStorage->getFromStorageId())) {
                    $this->session->setFlash(['error' => 'Товар не был перемещен со склада! Пожалуйста, попробуйте снова.']);
                    return false;
                }
            } else {
                if (empty($this->repository->updateProduct(
                    $productStorage->getQuantityCurrentInStorage(),
                    $product->getId(),
                    $productStorage->getFromStorageId(),
                ))) {
                    $this->session->setFlash(['error' => 'Количество товаров не обновилось на складе из которого вы их перемещаете! Пожалуйста, попробуйте снова.']);
                    return false;
                }
            }

            if (empty($this->repository->addProduct(
                $product->getId(),
                $productStorage->getToStorageId(),
                $productStorage->getMoveQuantity(),
            ))) {
                $this->session->setFlash(['error' => 'Товар не был перемещен на склад! Пожалуйста, попробуйте снова.']);
                return false;
            }
        } else {
            if ($productStorage->getPastQuantityFromStorage() <= $product->getQuantity()) {
                if (!$this->repository->deleteProduct($product->getId(), $productStorage->getFromStorageId())) {
                    $this->session->setFlash(['error' => 'Товар не был перемещен со склада! Пожалуйста, попробуйте снова.']);
                    return false;
                }
            } else {
                if (empty($this->repository->updateProduct(
                    $productStorage->getQuantityDifferenceInCurrentStorage(),
                    $product->getId(),
                    $productStorage->getFromStorageId(),
                ))) {
                    $this->session->setFlash(['error' => 'Количество товаров не обновилось на складе из которого вы их перемещаете! Пожалуйста, попробуйте снова.']);
                    return false;
                }
            }

            if (empty($this->repository->updateProduct(
                $productStorage->getQuantitySumInCurrentStorage(),
                $product->getId(),
                $productStorage->getToStorageId(),
            ))) {
                $this->session->setFlash(['error' => 'Товар не был перемещен на новый склад! Пожалуйста, попробуйте снова.']);
                return false;
            }
        }

        return true;
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
