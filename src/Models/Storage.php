<?php
declare(strict_types=1);

namespace App\Models;

use App\core\Model;

class Storage extends Model
{
    private Product $product;
    private int $id;
    private readonly string $createdAt;
    private readonly string $updatedAt;

    public function __construct(
        private readonly string $name,
    ) {
    }
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

    public function setCreatedAt(string $value): void
    {
        $this->createdAt = $value;
    }

    public function setUpdatedAt(string $value): void
    {
        $this->updatedAt = $value;
    }

}
