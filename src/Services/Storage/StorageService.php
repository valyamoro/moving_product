<?php

namespace App\Services\Storage;

use App\Models\Product;
use App\Models\Storage;
use App\Services\BaseService;

class StorageService extends BaseService
{
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function getAllHistoryAboutMovementProduct(array $products): array
    {
        $result = [];

        $historyMoves = $this->repository->getAllHistoryAboutMovementProduct();

        foreach ($products as $value) {
            $string = '';
            foreach ($historyMoves as $historyMove) {
                if ($value['id'] === $historyMove['product_id']) {
                    $string .= ($historyMove['description'] . '<br>');
                }
            }

            if (!empty($string)) {
                $result[] = ['product_id' => $value['id'], 'description' => $string];
            }
        }

        return $this->deleteDuplicates($result, 'product_id');
    }

    private function deleteDuplicates(array $data, string $key): array
    {
        $uniqueIds = [];

        return \array_filter($data, function($item) use (&$uniqueIds, $key) {
            if (!\in_array($item[$key], $uniqueIds)) {
                $uniqueIds[] = $item[$key];
                return true;
            }

            return false;
        });
    }

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

    public function getStringProductInfo(Product $product, Storage $storage): string
    {
        $date = \date('d-m-Y H:i');
        $string = "{$storage->getFromTitle()} {$product->getTitle()} был {$product->getPastQuantityFromStorage()}
        стало {$product->getNowQuantityFromStorage()} {$date}\n";

        $string .= "| {$storage->getToTitle()} {$product->getTitle()} было {$product->getPastQuantityToStorage()}
        перемещено {$product->getQuantity()} стало {$product->getNowQuantityToStorage()} {$date}";

        return $string;
    }

    public function saveHistory(array $data): void
    {
        $result = $this->getStringProductInfo($data['product'], $data['storage']);
        $this->repository->saveHistory($data['product']->getId(), $result);
    }

    public function getInfoAboutProductMovement(Product $product, Storage $storage): array
    {
        $product->setNowQuantityFromStorage($this->repository->getQuantityProductInStorage(
            $product->getId(),
            $storage->getFromId(),
        ));

        $product->setNowQuantityToStorage($this->repository->getQuantityProductInStorage(
            $product->getId(),
            $storage->getToId(),
        ));

        $storage->setFromTitle($this->repository->getStorageNameById($storage->getFromId()));
        $storage->setToTitle($this->repository->getStorageNameById($storage->getToId()));

        return ['product' => $product, 'storage' => $storage];
    }

}
