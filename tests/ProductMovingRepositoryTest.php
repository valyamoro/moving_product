<?php
declare(strict_types=1);

class ProductMovingRepositoryTest extends \PHPUnit\Framework\TestCase
{
    private readonly \App\Services\ProductMoving\Repositories\ProductMovingRepository $repository;
    private readonly array $data;

    protected function setUp(): void
    {
        $data = [
            'product_id' => 1,
            'from_warehouse_id' => 1,
            'to_warehouse_id' => 2,
            'quantity' => 5,
        ];

        $this->data = $data;
        $configuration = require __DIR__ . '/../config/test_db.php';
        $this->repository = new \App\Services\ProductMoving\Repositories\ProductMovingRepository($configuration);
    }

    public function testCanGetProductData(): void
    {
        $result = $this->repository->getProductData($this->data['product_id'], $this->data['from_warehouse_id']);

        $this->assertEmpty($result['quantity']);
    }

    public function testCanAddProduct(): void
    {
        $result = $this->repository->addProduct($this->data['product_id'], $this->data['to_warehouse_id'], $this->data['quantity']);

        $this->assertSame(1, $result['product_id']);
        $this->assertSame(2, $result['warehouse_id']);
        $this->assertSame(5, $result['quantity']);
    }

    public function testCanUpdateProduct(): void
    {
        $result = $this->repository->updateProduct(3, $this->data['product_id'], $this->data['to_warehouse_id']);

        $this->assertTrue($result);
    }

    public function testCanDeleteProduct(): void
    {
        $result = $this->repository->deleteProduct($this->data['product_id'], $this->data['to_warehouse_id']);

        $this->assertTrue($result);
    }

}
