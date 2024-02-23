<?php
declare(strict_types=1);

class ProductMovingServiceTest extends \PHPUnit\Framework\TestCase
{
    private readonly \App\Services\ProductMoving\ProductMovementService $service;
    private readonly \App\Services\ProductMoving\Repositories\ProductMovementRepository $repository;
    private readonly array $data;

    protected function setUp(): void
    {
        $data = [
            'product_id' => 1,
            'from_warehouse_id' => 1,
            'to_warehouse_id' => 2,
            'moving_quantity' => 5,
        ];

        $this->data = $data;
        $configuration = require __DIR__ . '/../config/test_db.php';
        $this->repository = new \App\Services\ProductMoving\Repositories\ProductMovementRepository($configuration);

        $this->repository->addProduct($data['product_id'], $data['from_warehouse_id'], $data['moving_quantity']);

        $this->service = new \App\Services\ProductMoving\ProductMovementService($this->repository);
    }

    public function testCanGetNeedDataAboutProduct(): void
    {
        $result = $this->service->getNeedDataAboutProduct($this->data);

        $this->assertSame(true, $result['is_add']);
        $this->assertSame(0, $result['quantity_difference_current_warehouse']);
        $this->assertSame(5, $result['quantity_sum_current_warehouse']);
    }

    public function tearDown(): void
    {
        $this->repository->deleteProduct($this->data['product_id'], $this->data['to_warehouse_id']);
    }
}
