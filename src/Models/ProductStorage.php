<?php
declare(strict_types=1);

namespace App\Models;

class ProductStorage
{
    private bool $isMoveProduct;
    private int $nowQuantityFromStorage;
    private int $nowQuantityToStorage;
    private int $pastQuantityFromStorage;
    private int $pastQuantityToStorage;
    private int $quantityCurrentInStorage;
    private int $quantityDifferenceInCurrentStorage;
    private int $quantitySumInCurrentStorage;
    private Product $product;
    private Storage $toStorage;
    private Storage $fromStorage;

    public function __construct(
        private readonly int $fromStorageId,
        private readonly int $toStorageId,
        private readonly int $moveQuantity,
    ) {
    }

    public function getNowQuantityFromStorage(): int
    {
        return $this->nowQuantityFromStorage;
    }

    public function getNowQuantityToStorage(): int
    {
        return $this->nowQuantityToStorage;
    }


    public function getPastQuantityFromStorage(): int
    {
        return $this->pastQuantityFromStorage;
    }


    public function getPastQuantityToStorage(): int
    {
        return $this->pastQuantityToStorage;
    }


    public function getQuantityCurrentInStorage(): int
    {
        return $this->quantityCurrentInStorage;
    }

    public function getQuantityDifferenceInCurrentStorage(): int
    {
        return $this->quantityDifferenceInCurrentStorage;
    }


    public function getQuantitySumInCurrentStorage(): int
    {
        return $this->quantitySumInCurrentStorage;
    }

    public function getMoveQuantity(): int
    {
        return $this->moveQuantity;
    }

    public function getFromStorageId(): int
    {
        return $this->fromStorageId;
    }

    public function getToStorageId(): int
    {
        return $this->toStorageId;
    }

    public function getIsMoveProduct(): bool
    {
        return $this->isMoveProduct;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getFromStorage(): Storage
    {
        return $this->fromStorage;
    }
    public function getToStorage(): Storage
    {
        return $this->toStorage;
    }

    public function setNowQuantityToStorage(int $value): void
    {
        $this->nowQuantityToStorage = $value;
    }

    public function setPastQuantityFromStorage(int $value): void
    {
        $this->pastQuantityFromStorage = $value;
    }

    public function setPastQuantityToStorage(int $value): void
    {
        $this->pastQuantityToStorage = $value;
    }

    public function setQuantityCurrentInStorage(int $value): void
    {
        $this->quantityCurrentInStorage = $value;
    }

    public function setIsMoveProduct(bool $value): void
    {
        $this->isMoveProduct = $value;
    }

    public function setQuantityDifferenceInCurrentStorage(int $value): void
    {
        $this->quantityDifferenceInCurrentStorage = $value;
    }

    public function setNowQuantityFromStorage(int $value): void
    {
        $this->nowQuantityFromStorage = $value;
    }

    public function setQuantitySumInCurrentStorage(int $value): void
    {
        $this->quantitySumInCurrentStorage = $value;
    }

    public function setProduct(Product $value): void
    {
        $this->product = $value;
    }

    public function setFromStorage(Storage $value): void
    {
        $this->fromStorage = $value;
    }

    public function setToStorage(Storage $value): void
    {
        $this->toStorage = $value;
    }
}
