<?php
declare(strict_types=1);

namespace App\Services\Storage;

use App\Models\Product;
use App\Models\ProductStorage;
use App\Services\BaseService;

class StorageService extends BaseService
{
    public function addProductInStorage(array $storages, array $products): array
    {
        foreach ($storages as $storage) {
            foreach ($products as $key => $product) {
                unset($products[$key]);
                $storage->setProduct($product);
                break;
            }
        }

        return $storages;
    }

    public function getProductStoragesCollection(array $data, array $products): array
    {
        $storagesList = $this->getAll();
        $productStorages = [];
        foreach ($data as $key => $historyMovementProduct) {
            foreach ($historyMovementProduct as $value) {
                $productStorage = new \App\Models\ProductStorage(
                    (int)$value['from_storage_id'],
                    (int)$value['to_storage_id'],
                    (int)$value['move_quantity'],
                );
                $productStorage->setNowQuantityToStorage($value['now_quantity_to_storage']);
                $productStorage->setPastQuantityToStorage($value['past_quantity_from_storage']);
                $productStorage->setPastQuantityToStorage($value['past_quantity_to_storage']);
                $productStorage->setNowQuantityToStorage($value['now_quantity_to_storage']);
                $productStorage->setPastQuantityFromStorage($value['past_quantity_from_storage']);
                $productStorage->setNowQuantityFromStorage($value['now_quantity_from_storage']);

                foreach ($products as $product) {
                    if ($product->getId() === $key) {
                        $productStorage->setProduct($product);
                    }
                }

                $collectionStorages = [];
                foreach ($storagesList as $storageData) {
                    $storage = \App\Factory\StorageFactory::create([
                        'name' => $storageData['name'],
                    ]);
                    $storage->setCreatedAt($value['created_at']);
                    $storage->setUpdatedAt($value['updated_at']);
                    $storage->setId($storageData['storage_id']);
                    $collectionStorages[] = $storage;
                }

                foreach ($collectionStorages as $storage) {
                    if ($storage->getId() === $value['to_storage_id']) {
                        $productStorage->setToStorage($storage);
                    }
                    if ($storage->getId() === $value['from_storage_id']) {
                        $productStorage->setFromStorage($storage);
                    }
                }

                $productStorages[$key][] = $productStorage;
            }
        }

        return $productStorages;
    }

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

    public function getCollection(array $data = []): array
    {
        if (empty($data)) {
            $data = $this->repository->getAll();
        }

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
