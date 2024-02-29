<?php
declare(strict_types=1);

namespace App\Models;

class ProductStorage
{
    private bool $isAdd;
    private string $fromName;
    private string $toName;
    private int $nowQuantityFrom;
    private int $nowQuantityTo;
    private int $pastQuantityFrom;
    private int $pastQuantityTo;
    private int $quantityCurrentIn;
    private int $quantityDifferenceInCurrent;
    private int $quantitySumInCurrent;

    public function __construct(
        private readonly int $fromId,
        private readonly int $toId,
        private readonly int $moveQuantity,
    ) {
    }

    public function getToName(): string
    {
        return $this->toName;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function getNowQuantityFrom(): int
    {
        return $this->nowQuantityFrom;
    }

    public function getNowQuantityTo(): int
    {
        return $this->nowQuantityTo;
    }


    public function getPastQuantityFrom(): int
    {
        return $this->pastQuantityFrom;
    }


    public function getPastQuantityTo(): int
    {
        return $this->pastQuantityTo;
    }


    public function getQuantityCurrentIn(): int
    {
        return $this->quantityCurrentIn;
    }

    public function getQuantityDifferenceInCurrent(): int
    {
        return $this->quantityDifferenceInCurrent;
    }


    public function getQuantitySumInCurrent(): int
    {
        return $this->quantitySumInCurrent;
    }

    public function getMoveQuantity(): int
    {
        return $this->moveQuantity;
    }

    public function getFromId(): int
    {
        return $this->fromId;
    }

    public function getToId(): int
    {
        return $this->toId;
    }

    public function getIsAdd(): bool
    {
        return $this->isAdd;
    }

    public function setNowQuantityTo(int $nowQuantityTo): void
    {
        $this->nowQuantityTo = $nowQuantityTo;
    }

    public function setPastQuantityFrom(int $pastQuantityFrom): void
    {
        $this->pastQuantityFrom = $pastQuantityFrom;
    }

    public function setPastQuantityTo(int $pastQuantityTo): void
    {
        $this->pastQuantityTo = $pastQuantityTo;
    }

    public function setQuantityCurrentIn(int $quantityCurrentIn): void
    {
        $this->quantityCurrentIn = $quantityCurrentIn;
    }

    public function setIsAdd(bool $value): void
    {
        $this->isAdd = $value;
    }

    public function setToName(string $value): void
    {
        $this->toTitle = $value;
    }

    public function setQuantityDifferenceInCurrent(int $quantityDifferenceInCurrent): void
    {
        $this->quantityDifferenceInCurrent = $quantityDifferenceInCurrent;
    }

    public function setFromName(string $value): void
    {
        $this->fromTitle = $value;
    }

    public function setNowQuantityFrom(int $nowQuantityFrom): void
    {
        $this->nowQuantityFrom = $nowQuantityFrom;
    }

    public function setQuantitySumInCurrent(int $quantitySumInCurrent): void
    {
        $this->quantitySumInCurrent = $quantitySumInCurrent;
    }

}
