<?php
declare(strict_types=1);

namespace App\Models;

class ProductMoving extends Model
{
    private int $id;
    private int $parentProductQuantity;
    private int $copyProductQuantity;
    private int $parentsBalance;
    private int $parentArticle;
    private int $copyArticle;
    private int $createDate;

    public function __construct(
        private readonly int $productId,
        private readonly int $storageFromId,
        private readonly int $storageToId,
        private readonly int $transferQuantity,
    ) {
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getStorageFromId(): int
    {
        return $this->storageFromId;
    }

    public function getStorageToId(): int
    {
        return $this->storageToId;
    }

    public function getTransferQuantity(): int
    {
        return $this->transferQuantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $value): void
    {
        $this->id = $value;
    }

    public function getParentProductQuantity(): int
    {
        return $this->parentProductQuantity;
    }

    public function setParentProductQuantity(int $value): void
    {
        $this->parentProductQuantity = $value;
    }

    public function getCopyProductQuantity(): int
    {
        return $this->copyProductQuantity;
    }

    public function setCopyProductQuantity(int $value): void
    {
        $this->copyProductQuantity = $value;
    }

    public function getParentsBalance(): int
    {
        return $this->parentsBalance;
    }

    public function setParentsBalance(int $value): void
    {
        $this->parentsBalance = $value;
    }

    public function getParentArticle(): int
    {
        return $this->parentArticle;
    }

    public function setParentArticle(int $value): void
    {
        $this->parentArticle = $value;
    }

    public function getCopyArticle(): int
    {
        return $this->copyArticle;
    }

    public function setCopyArticle(int $value): void
    {
        $this->copyArticle = $value;
    }

    public function getCreateDate(): int
    {
        return $this->createDate;
    }

    public function setCreateDate(int $value): void
    {
        $this->createDate = $value;
    }

}
