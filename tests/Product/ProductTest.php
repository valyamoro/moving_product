<?php
declare(strict_types=1);

namespace Product;

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testCreateNewProduct(): void
    {
        $data = [
            'id' => 1,
            'title' => 'product1',
            'quantity' => 3,
            'price' => 500,
            'createdAt' => '04-03-2024',
            'updatedAt' => '04-03-2024',
        ];
        $product = \App\Factory\Product::create($data);

        $this->assertInstanceOf(\App\Models\Product::class, $product);

        $this->assertSame(1, $product->getId());
        $this->assertSame('product1', $product->getTitle());
        $this->assertSame(3, $product->getQuantity());
        $this->assertSame(500, $product->getPrice());
        $this->assertSame('04-03-2024', $product->getCreatedAt());
        $this->assertSame('04-03-2024', $product->getUpdatedAt());
    }

}
