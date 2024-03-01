<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\Exceptions\ExceptionEmptyQuantityProduct;
use App\Models\Product;
use App\Models\ProductStorage;
use App\Services\BaseService;

class ProductService extends BaseService
{
    /**
     * @throws ExceptionEmptyQuantityProduct
     */
    public function getAllAboutProduct(Product $product, ProductStorage $productStorage): ProductStorage
    {
        $productStorage = $this->getPastQuantityProductStorage($product, $productStorage);

        $productStorage->setQuantityDifferenceInCurrentStorage($productStorage->getPastQuantityFromStorage() - $productStorage->getMoveQuantity());
        $productStorage->setQuantitySumInCurrentStorage($productStorage->getPastQuantityToStorage() + $productStorage->getPastQuantityFromStorage());

        if ($productStorage->getPastQuantityToStorage() === 0) {
            $productStorage->setIsMoveProduct(true);
            $productStorage->setQuantityCurrentInStorage($productStorage->getQuantityDifferenceInCurrentStorage());
        } else {
            $productStorage->setIsMoveProduct(false);
            $productStorage->setQuantityCurrentInStorage($productStorage->getQuantitySumInCurrentStorage());
        }

        return $productStorage;
    }

    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function getById(int $id): array
    {
        return $this->repository->getById($id);
    }

    public function getAllProductInStorage(int $productId, int $storageId): array
    {
        return $this->repository->getAllProductStorage($productId, $storageId);
    }

}
