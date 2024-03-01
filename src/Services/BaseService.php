<?php
declare(strict_types=1);

namespace App\Services;

use App\core\Http\Session;
use App\Models\Product;
use App\Models\ProductStorage;

abstract class BaseService
{
    public function __construct(
        protected BaseRepository $repository,
        protected Session $session,
    ) {
    }

    private function getQuantityProductFromAndToStorage(Product $product, ProductStorage $productStorage): array
    {
        $quantityProductFromStorage = $this->repository->getAllProductStorage(
            $product->getId(),
            $productStorage->getFromStorageId(),
        );
        $quantityProductFromStorage = $quantityProductFromStorage['quantity'] ?? 0;

        $quantityProductToStorage = $this->repository->getAllProductStorage(
            $product->getId(),
            $productStorage->getToStorageId(),
        );
        $quantityProductToStorage = $quantityProductToStorage['quantity'] ?? 0;

        return ['from' => $quantityProductFromStorage, 'to' => $quantityProductToStorage];
    }

    protected function getNowQuantityProductStorage(Product $product, ProductStorage $productStorage): ProductStorage
    {
        $quantityProductInStorage = $this->getQuantityProductFromAndToStorage($product, $productStorage);

        $productStorage->setNowQuantityFromStorage($quantityProductInStorage['from']);
        $productStorage->setNowQuantityToStorage($quantityProductInStorage['to']);


        return $productStorage;
    }

    protected function getPastQuantityProductStorage(Product $product, ProductStorage $productStorage): ?ProductStorage
    {
        $quantityProductInStorage = $this->getQuantityProductFromAndToStorage($product, $productStorage);
        if (!empty($quantityProductInStorage)) {
            $productStorage->setPastQuantityFromStorage($quantityProductInStorage['from']);
            $productStorage->setPastQuantityToStorage($quantityProductInStorage['to']);
        }

        return !empty($quantityProductInStorage) ? $productStorage : null;
    }

}
