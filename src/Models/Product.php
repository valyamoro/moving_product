<?php
declare(strict_types=1);

namespace App\Models;

use App\core\Model;

class Product extends Model
{
    public function __construct(
        private readonly int $id,
        private readonly string $title,
        private readonly int $price,
        private readonly int $quantity,
        private readonly string $createdAt,
        private readonly string $updatedAt,
    ) {
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

}
