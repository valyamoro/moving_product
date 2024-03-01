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

    public function moveProduct(Product $product, ProductStorage $productStorage): ?ProductStorage
    {
        if ($productStorage->getIsMoveProduct()) {
            if ($productStorage->getQuantityCurrentInStorage() <= 0) {
                if (!$this->repository->deleteProduct($product->getId(), $productStorage->getFromStorageId())) {
                    $this->session->setFlash(['error' => 'Товар не удалился со старого склада!']);
                    return null;
                }
            } else {
                if (empty($this->repository->updateProduct(
                    $productStorage->getQuantityCurrentInStorage(),
                    $product->getId(),
                    $productStorage->getFromStorageId(),
                ))) {
                    $this->session->setFlash(['error' => 'Количество товаров не обновилось на старом складе!']);
                    return null;
                }
            }

            if (empty($this->repository->addProduct(
                $product->getId(),
                $productStorage->getToStorageId(),
                $productStorage->getMoveQuantity(),
            ))) {
                $this->session->setFlash(['error' => 'Товар не был перемещен!']);
                return null;
            }
        } else {
            if ($productStorage->getPastQuantityFromStorage() <= $product->getQuantity()) {
                if (!$this->repository->deleteProduct($product->getId(), $productStorage->getFromStorageId())) {
                    $this->session->setFlash(['error' => 'Товар не удалился со старого склада!']);
                    return null;
                }
            } else {
                if (empty($this->repository->updateProduct(
                    $productStorage->getQuantityDifferenceInCurrentStorage(),
                    $product->getId(),
                    $productStorage->getFromStorageId(),
                ))) {
                    $this->session->setFlash(['error' => 'Количество товаров не обновилось на старом складе!']);
                    return null;
                }
            }

            if (empty($this->repository->updateProduct(
                $productStorage->getQuantitySumInCurrentStorage(),
                $product->getId(),
                $productStorage->getToStorageId(),
            ))) {
                $this->session->setFlash(['error' => 'Количество товаров не обновилось на новом складе!']);
                return null;
            }
        }

        return $productStorage;
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

    private function getById(int $id): array
    {
        return $this->repository->getById($id);
    }

    public function getStringProductInfo(Product $product, array $data): string
    {
        $string = "{$this->getById($data['from_storage_id'])['name']} {$product->getTitle()} был {$data['past_quantity_from_storage']}
        стало {$data['now_quantity_from_storage']} {$data['created_at']}";

        $string .= "| {$this->getById($data['to_storage_id'])['name']} {$product->getTitle()} было {$data['past_quantity_to_storage']}
        перемещено {$data['move_quantity']} стало {$data['now_quantity_to_storage']} {$data['created_at']}";

        return $string;
    }

    public function saveHistory(int $productId, ProductStorage $productStorage): bool
    {
        if (!$this->repository->saveHistory($productId, $productStorage)) {
            $this->session->setFlash(['error' => 'История о перемещении товара не была сохранена! Пожалуйста, обратитесь к администратору сайта']);
            return false;
        } else {
            return true;
        }
    }

    public function getInfoAboutProductMovement(Product $product, ProductStorage $productStorage): ProductStorage
    {
        return $this->getNowQuantityProductStorage($product, $productStorage);
    }

}
