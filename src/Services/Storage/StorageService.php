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

    public function moveProduct(Product $product, ProductStorage $productStorage): ?Product
    {
        if ($productStorage->getIsAdd()) {
            if ($productStorage->getPastQuantityFromStorage() <= $product->getQuantity()) {
                $this->repository->deleteProduct($product->getId(), $productStorage->getFromStorageId());
            } else {
                $this->repository->updateProduct(
                    $productStorage->getQuantityDifferenceInCurrentStorage(),
                    $product->getId(),
                    $productStorage->getFromStorageId(),
                );
            }

            $result = $this->repository->updateProduct(
                $productStorage->getQuantitySumInCurrentStorage(),
                $product->getId(),
                $productStorage->getToStorageId(),
            );

            // здесь необязательно.
            return $result ? new Product(...$result) : null;
        } else {
            if ($productStorage->getQuantityCurrentIn() === 0) {
                $this->repository->deleteProduct($product->getId(), $productStorage->getFromStorageId()); // переместить вверх
            } else {
                $this->repository->updateProduct(
                    $productStorage->getQuantityCurrentIn(),
                    $product->getId(),
                    $productStorage->getFromStorageId(),
                );
            }

            $result = $this->repository->addProduct(
                $product->getId(),
                $productStorage->getToStorageId(),
                $productStorage->getMoveQuantity(),
            );

            return $result ? new Product(...$result) : null;
        }
    }

    public function getAllHistoryAboutMovementProduct(Product $product): array
    {
        $result = [];

        $string = '';
        $historyMoves = $this->repository->getHistoryAboutMovementProduct($product->getId());

        foreach ($historyMoves as $value) {
            if ($value['product_id'] === $product->getId()) {
                $string .= $this->getStringProductInfo($product, $value);
            }

            if (!empty($string)) {
                $result = ['product_id' => $product->getId(), 'description' => $string];
            }
        }

        return $result;
    }

    public function deleteDuplicates(array $data, string $key): array
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
        стало {$data['now_quantity_from_storage']} {$data['created_at']}";

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

    /**
     * @throws ExceptionEmptyQuantityProduct
     */
    public function getInfoAboutProductMovement(Product $product, ProductStorage $productStorage): ProductStorage
    {
        return $this->getNowQuantityProductStorage($product, $productStorage);
    }

}
