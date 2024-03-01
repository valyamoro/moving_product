<?php
declare(strict_types=1);

namespace App\Models;

use App\core\Model;

class Storage extends Model
{
    private int $id;
    private Product $product;

    public function __construct(
        private readonly string $name,
        private readonly string $createdAt,
        private readonly string $updatedAt,
    ) {}

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setId(int $value): void
    {
        $this->id = $value;
    }

    public function setProduct(Product $value): void
    {
        $this->product = $value;
    }

}
