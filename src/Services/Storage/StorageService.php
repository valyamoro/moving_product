<?php

namespace App\Services\Storage;

use App\Models\Product;
use App\Models\ProductStorage;
use App\Services\BaseService;

class StorageService extends BaseService
{
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function moveProduct(Product $product, ProductStorage $productStorage): void
    {
        if (false === $productStorage->getIsAdd()) {
            if ($productStorage->getPastQuantityFrom() <= $product->getQuantity()) {
                $this->repository->deleteProduct($product->getId(), $productStorage->getFromId());
            } else {
                $this->repository->updateProduct(
                    $productStorage->getQuantityDifferenceInCurrent(),
                    $product->getId(),
                    $productStorage->getFromId(),
                );
            }

            $this->repository->updateProduct(
                $productStorage->getQuantitySumInCurrent(),
                $product->getId(),
                $productStorage->getToId(),
            );
        } else {
            if ($productStorage->getQuantityCurrentIn() === 0) {
                $this->repository->deleteProduct($product->getId(), $productStorage->getFromId());
            } else {
                $this->repository->updateProduct(
                    $productStorage->getQuantityCurrentIn(),
                    $product->getId(),
                    $productStorage->getFromId(),
                );
            }

            $this->repository->addProduct($product->getId(), $productStorage->getToId(),
                $productStorage->getMoveQuantity());
        }
    }

    public function getAllHistoryAboutMovementProduct(Product $product): ?array
    {
        $result = [];

        $string = '';
        $historyMoves = $this->repository->getHistoryAboutMovementProduct($product->getId());

//        $historyMoves = $this->deleteDuplicates($this->repository->getHistoryAboutMovementProduct($product->getId()), 'product_id');
        foreach ($historyMoves as $value) {
            if ($value['product_id'] === $product->getId()) {
                $string = $this->getStringProductInfo($product, $value);
            }

            if (!empty($string)) {
                $result[] = ['product_id' => $product->getId(), 'description' => $string];
            }
        }

        return $result;
    }

    private function deleteDuplicates(array $data, string $key): array
    {
        $uniqueIds = [];

        return \array_filter($data, function ($item) use (&$uniqueIds, $key) {
            if (is_array($item)) {
                if (!isset($item[$key])) {
                    return false;
                }
                if (!\in_array($item[$key], $uniqueIds)) {
                    $uniqueIds[] = $item[$key];
                    return true;
                }
            }
            return false;
        });
    }

    public function getStringProductInfo(Product $product, array $data): string
    {
        $string = "{$this->getById($data['from_storage_id'])['name']} {$product->getTitle()} был {$data['past_quantity_from_storage']}
        стало {$data['now_quantity_from_storage']} {$data['created_at']}\n";

        $string .= "| {$this->getById($data['to_storage_id'])['name']} {$product->getTitle()} было {$data['past_quantity_to_storage']}
        перемещено {$data['move_quantity']} стало {$data['now_quantity_to_storage']} {$data['created_at']}";

        return $string;
    }

    private function getById(int $id): array
    {
        return $this->repository->getById($id);
    }

    public function saveHistory(int $productId, ProductStorage $productStorage): void
    {
        $this->repository->saveHistory($productId, $productStorage);
    }

// Поменять название, я уже ничего не получаю, а изменяю существующие объекты.
    public function getInfoAboutProductMovement(Product $product, ProductStorage $productStorage): void
    {
        $productStorage->setNowQuantityFrom($this->repository->getQuantityProductInStorage(
            $product->getId(),
            $productStorage->getFromId(),
        ));

        $productStorage->setNowQuantityTo($this->repository->getQuantityProductInStorage(
            $product->getId(),
            $productStorage->getToId(),
        ));

//        $productStorage->setFromName($this->repository->getStorageNameById($storage->getFromId()));
//        $productStorage->setToName($this->repository->getStorageNameById($storage->getToId()));
    }

}
