<?php
declare(strict_types=1);

namespace App\Services;

use App\core\Http\Session;
use App\Exceptions\ExceptionEmptyQuantityProduct;
use App\Models\Product;
use App\Models\ProductStorage;

abstract class BaseService
{
    public function __construct(
        protected BaseRepository $repository,
        protected Session $session,
    )
    {

    }

    /**
     * @throws ExceptionEmptyQuantityProduct
     */
    private function getQuantityProductFromAndToStorage(Product $product, ProductStorage $productStorage): array
    {
        $quantityProductFromStorage = $this->repository->getAllProductStorage(
            $product->getId(),
            $productStorage->getFromStorageId(),
        );
        if (empty($quantityProductFromStorage['quantity'])) {
            throw new ExceptionEmptyQuantityProduct("Склад с номером {$productStorage->getFromStorageId()} не найден");
        }

        $quantityProductToStorage = $this->repository->getAllProductStorage(
            $product->getId(),
            $productStorage->getToStorageId(),
        );
        if (empty($quantityProductToStorage['quantity'])) {
            throw new ExceptionEmptyQuantityProduct("Склад с номером {$productStorage->getToStorageId()} не найден");
        }

        return ['from' => $quantityProductToStorage['quantity'], 'to' => $quantityProductToStorage['quantity']];
    }

    /**
     * @throws ExceptionEmptyQuantityProduct
     */
    protected function getNowQuantityProductStorage(Product $product, ProductStorage $productStorage): ProductStorage
    {
        $quantityProductInStorage = $this->getQuantityProductFromAndToStorage($product, $productStorage);

        $productStorage->setNowQuantityFromStorage($quantityProductInStorage['from']);
        $productStorage->setNowQuantityToStorage($quantityProductInStorage['to']);

        return $productStorage;
    }

    /**
     * @throws ExceptionEmptyQuantityProduct
     */
    protected function getPastQuantityProductStorage(Product $product, ProductStorage $productStorage): ProductStorage
    {
        $quantityProductInStorage = $this->getQuantityProductFromAndToStorage($product, $productStorage);

        $productStorage->setPastQuantityFromStorage($quantityProductInStorage['from']);
        $productStorage->setPastQuantityToStorage($quantityProductInStorage['to']);

        return $productStorage;
    }

}
