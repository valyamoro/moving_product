<?php
declare(strict_types=1);

class LogHistoryProductMovingServiceTest extends \PHPUnit\Framework\TestCase
{
    private readonly \App\Services\LogHistoryProductMoving\LogHistoryProductMovingService $service;
    public function setUp(): void
    {
        $this->data = [
            'moving_quantity' => 5,
            'from_warehouse_past_quantity' => 5,
            'to_warehouse_past_quantity' => 0,
            'from_warehouse_now_quantity' => 0,
            'to_warehouse_now_quantity' => 5,
            'from_warehouse_title' => 'склад1',
            'to_warehouse_title' => 'склад2',
            'product_title' => 'продукт1',
        ];

        $repository = new \App\Services\LogHistoryProductMoving\Repositories\LogHistoryProductMovingRepository(require __DIR__ . '/../config/test_db.php');
        $this->service = new \App\Services\LogHistoryProductMoving\LogHistoryProductMovingService($repository);
    }

    public function testFormatToInfoAboutMovingProduct(): void
    {
        $result = $this->service->formatToInfoAboutMovingProduct($this->data);

        $this->assertSame("склад1 продукт1 был 5 стало 0\nсклад2 продукт1 было 0 перемещено 5 стало 5", $result);
    }

}
