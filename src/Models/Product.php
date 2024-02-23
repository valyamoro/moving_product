<?php
declare(strict_types=1);

namespace App\Models;

use App\core\Model;

class Product extends Model
{
    private int $pastQuantityFromStorage;
    private int $pastQuantityToStorage;
    private readonly int $nowQuantityFromStorage;
    private readonly int $nowQuantityToStorage;
    private readonly int $quantityDifferenceInCurrentStorage;
    private readonly int $quantityCurrentInStorage;
    private readonly int $quantitySumInCurrentStorage;

    public function __construct(
        private readonly int $id,
        private readonly int $quantity,
        private readonly string $title,
    ) {
    }

    public function getPastQuantityFromStorage(): int
    {
        return $this->pastQuantityFromStorage;
    }

    public function getPastQuantityToStorage(): int
    {
        return $this->pastQuantityToStorage;
    }

    public function getNowQuantityFromStorage(): int
    {
        return $this->nowQuantityFromStorage;
    }

    public function getNowQuantityToStorage(): int
    {
        return $this->nowQuantityToStorage;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getQuantityFromStorage(): int
    {
        return $this->pastQuantityFromStorage;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setPastQuantityFromStorage(int $value): void
    {
        $this->pastQuantityFromStorage = $value;
    }

    public function setPastQuantityToStorage(int $value): void
    {
        $this->pastQuantityToStorage = $value;
    }
    public function setNowQuantityFromStorage(int $value): void
    {
        $this->nowQuantityFromStorage = $value;
    }

    public function setNowQuantityToStorage(int $value): void
    {
        $this->nowQuantityToStorage = $value;
    }

    public function setQuantityDifferenceInCurrentStorage(int $value): void
    {
        $this->quantityDifferenceInCurrentStorage = $value;
    }
    public function setQuantitySumInCurrentStorage(int $value): void
    {
        $this->quantitySumInCurrentStorage = $value;
    }

    public function setQuantityCurrentStorage(int $value): void
    {
        $this->quantityCurrentInStorage = $value;
    }

}
