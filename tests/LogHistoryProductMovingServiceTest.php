<?php
declare(strict_types=1);

class LogHistoryProductMovingServiceTest extends \PHPUnit\Framework\TestCase
{
    private readonly \App\Services\LogHistoryProductMoving\LogHistoryProductMovingService $service;
    private readonly array $dataForFormatToInfoAboutMovingProduct;
    private readonly array $dataForObtainingRemainingDataAboutMovementOfTheProduct;

    public function setUp(): void
    {
        $this->dataForFormatToInfoAboutMovingProduct = [
            'moving_quantity' => 5,
            'from_warehouse_past_quantity' => 5,
            'to_warehouse_past_quantity' => 0,
            'from_warehouse_now_quantity' => 0,
            'to_warehouse_now_quantity' => 5,
            'from_warehouse_title' => 'склад1',
            'to_warehouse_title' => 'склад2',
            'product_title' => 'продукт1',
        ];

        $this->dataForObtainingRemainingDataAboutMovementOfTheProduct = [
            'product_id' => 1,
            'from_warehouse_id' => 1,
            'to_warehouse_id' => 2,
        ];

        $repository = new \App\Services\LogHistoryProductMoving\Repositories\LogHistoryProductMovingRepository(require __DIR__ . '/../config/test_db.php');
        $this->service = new \App\Services\LogHistoryProductMoving\LogHistoryProductMovingService($repository);
    }

    public function testFormatToInfoAboutMovingProduct(): void
    {
        $result = $this->service->formatToInfoAboutMovingProduct($this->dataForFormatToInfoAboutMovingProduct);

        $this->assertSame("склад1 продукт1 был 5 стало 0\nсклад2 продукт1 было 0 перемещено 5 стало 5", $result);
    }

    public function testCanObtainingRemainingDataAboutMovementOfTheProduct(): void
    {
        $result = $this->service->obtainingRemainingDataAboutMovementOfTheProduct($this->dataForObtainingRemainingDataAboutMovementOfTheProduct);
        $this->assertSame(0, $result['from_warehouse_now_quantity']);
        $this->assertSame(5, $result['to_warehouse_now_quantity']);
        $this->assertSame('склад1', $result['from_warehouse_title']);
        $this->assertSame('склад2', $result['to_warehouse_title']);
        $this->assertSame('продукт1', $result['product_title']);
    }

}
