<?php
declare(strict_types=1);

namespace App\Services\HistoryProductMovement;

use App\Models\Product;
use App\Models\Storage;
use App\Services\BaseService;

class HistoryProductMovementService extends BaseService
{
    public function getStringProductInfo(Product $product, Storage $storage): string
    {
        $date = \date('d-m-Y H:i');
        $string = "{$storage->getFromTitle()} {$product->getTitle()} был {$product->getPastQuantityFromStorage()}
        стало {$product->getNowQuantityFromStorage()} {$date}\n";

        $string .= "| {$storage->getToTitle()} {$product->getTitle()} было {$product->getPastQuantityToStorage()}
        перемещено {$product->getQuantity()} стало {$product->getNowQuantityToStorage()} {$date}";

        return $string;
    }

    public function save(array $data): void
    {
        $result = $this->getStringProductInfo($data['product'], $data['storage']);
        $this->repository->save($data['product']->getId(), $result);
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

        $storage->setFromTitle($this->repository->getStorageTitleById($storage->getFromId()));
        $storage->setToTitle($this->repository->getStorageTitleById($storage->getToId()));
        $product->setTitle($this->repository->getProductTitleById($product->getId()));

        return ['product' => $product, 'storage' => $storage];
    }

    public function getPastQuantityProductInStorage(Product $product, Storage $storage): Product
    {
        $product->setPastQuantityFromStorage($this->repository->getQuantityProductInStorage(
            $product->getId(),
            $storage->getFromId(),
        ));

        $product->setPastQuantityToStorage($this->repository->getQuantityProductInStorage(
            $product->getId(),
            $storage->getToId(),
        ));

        return $product;
    }

}
