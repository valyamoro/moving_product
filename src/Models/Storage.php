<?php
declare(strict_types=1);

namespace App\Models;

use App\core\Model;

class Storage extends Model
{
    private bool $isAdd;
    private string $fromTitle;
    private string $toTitle;
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

    public function getNowQuantityFrom(): int
    {
        return $this->nowQuantityFrom;
    }

    public function setNowQuantityFrom(int $nowQuantityFrom): void
    {
        $this->nowQuantityFrom = $nowQuantityFrom;
    }

    public function getNowQuantityTo(): int
    {
        return $this->nowQuantityTo;
    }

    public function setNowQuantityTo(int $nowQuantityTo): void
    {
        $this->nowQuantityTo = $nowQuantityTo;
    }

    public function getPastQuantityFrom(): int
    {
        return $this->pastQuantityFrom;
    }

    public function setPastQuantityFrom(int $pastQuantityFrom): void
    {
        $this->pastQuantityFrom = $pastQuantityFrom;
    }

    public function getPastQuantityTo(): int
    {
        return $this->pastQuantityTo;
    }

    public function setPastQuantityTo(int $pastQuantityTo): void
    {
        $this->pastQuantityTo = $pastQuantityTo;
    }

    public function getQuantityCurrentIn(): int
    {
        return $this->quantityCurrentIn;
    }

    public function setQuantityCurrentIn(int $quantityCurrentIn): void
    {
        $this->quantityCurrentIn = $quantityCurrentIn;
    }

    public function getQuantityDifferenceInCurrent(): int
    {
        return $this->quantityDifferenceInCurrent;
    }

    public function setQuantityDifferenceInCurrent(int $quantityDifferenceInCurrent): void
    {
        $this->quantityDifferenceInCurrent = $quantityDifferenceInCurrent;
    }

    public function getQuantitySumInCurrent(): int
    {
        return $this->quantitySumInCurrent;
    }

    public function setQuantitySumInCurrent(int $quantitySumInCurrent): void
    {
        $this->quantitySumInCurrent = $quantitySumInCurrent;
    }

    public function getMoveQuantity(): int
    {
        return $this->moveQuantity;
    }

    public function getToTitle(): string
    {
        return $this->toTitle;
    }

    public function getFromTitle(): string
    {
        return $this->fromTitle;
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

    public function setIsAdd(bool $value): void
    {
        $this->isAdd = $value;
    }

    public function setToTitle(string $value): void
    {
        $this->toTitle = $value;
    }

    public function setFromTitle(string $value): void
    {
        $this->fromTitle = $value;
    }

}
