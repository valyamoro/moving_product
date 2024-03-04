<?php
declare(strict_types=1);

namespace App\Models;

class Product extends Model
{
    private int $id;

    public function __construct(
        private readonly string $title,
        private readonly int $price,
        private readonly int $quantity,
        private readonly string $createdAt,
        private readonly string $updatedAt,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

}
