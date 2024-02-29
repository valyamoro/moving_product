<?php

namespace App\Services\Storage;

use App\Models\Product;
use App\Models\ProductStorage;
use App\Models\Storage;
use App\Services\BaseService;

class StorageService extends BaseService
{
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function moveProduct(Product $product, ProductStorage $storage): void
    {
        if (false === $storage->getIsAdd()) {
            if ($storage->getPastQuantityFrom() <= $product->getQuantity()) {
                $this->repository->deleteProduct($product->getId(), $storage->getFromId());
            } else {
                $this->repository->updateProduct(
                    $storage->getQuantityDifferenceInCurrent(),
                    $product->getId(),
                    $storage->getFromId(),
                );
            }

            $this->repository->updateProduct(
                $storage->getQuantitySumInCurrent(),
                $product->getId(),
                $storage->getToId(),
            );
        } else {
            if ($storage->getQuantityCurrentIn() === 0) {
                $this->repository->deleteProduct($product->getId(), $storage->getFromId());
            } else {
                $this->repository->updateProduct(
                    $storage->getQuantityCurrentIn(),
                    $product->getId(),
                    $storage->getFromId(),
                );
            }

            $this->repository->addProduct($product->getId(), $storage->getToId(), $storage->getMoveQuantity());
        }
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

    public function getStringProductInfo(Product $product, Storage $storage): string
    {
        $date = \date('d-m-Y H:i');
        $string = "{$storage->getFromTitle()} {$product->getTitle()} был {$storage->getPastQuantityFrom()}
        стало {$product->getNowQuantityFrom()} {$date}\n";

        $string .= "| {$storage->getToTitle()} {$product->getTitle()} было {$storage->getPastQuantityTo()}
        перемещено {$product->getQuantity()} стало {$product->getNowQuantityTo()} {$date}";

        return $string;
    }

    public function saveHistory(array $data): void
    {
        $result = $this->getStringProductInfo($data['product'], $data['storage']);
        $this->repository->saveHistory($data['product']->getId(), $result);
    }

    // Поменять название, я уже ничего не получаю, а изменяю существующие объекты.
    public function getInfoAboutProductMovement(Product $product, Storage $storage): void
    {
        $storage->setNowQuantityFrom($this->repository->getQuantityProductInStorage(
            $product->getId(),
            $storage->getFromId(),
        ));

        $storage->setNowQuantityTo($this->repository->getQuantityProductInStorage(
            $product->getId(),
            $storage->getToId(),
        ));

        $storage->setFromTitle($this->repository->getStorageNameById($storage->getFromId()));
        $storage->setToTitle($this->repository->getStorageNameById($storage->getToId()));
    }

}
