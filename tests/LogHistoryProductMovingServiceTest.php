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
            'from_warehouse_title' => 'склад3',
            'to_warehouse_title' => 'склад4',
            'product_title' => 'продукт3',
        ];

        $this->dataForObtainingRemainingDataAboutMovementOfTheProduct = [
            'product_id' => 3,
            'from_warehouse_id' => 3,
            'to_warehouse_id' => 4,
        ];

        $repository = new \App\Services\LogHistoryProductMoving\Repositories\LogHistoryProductMovingRepository(require __DIR__ . '/../config/test_db.php');
        $this->service = new \App\Services\LogHistoryProductMoving\LogHistoryProductMovingService($repository);
    }

    public function testFormatToInfoAboutMovingProduct(): void
    {
        $result = $this->service->formatToInfoAboutMovingProduct($this->dataForFormatToInfoAboutMovingProduct);

        $this->assertSame("склад3 продукт3 был 5 стало 0\nсклад4 продукт3 было 0 перемещено 5 стало 5", $result);
    }

    public function testCanObtainingRemainingDataAboutMovementOfTheProduct(): void
    {
        $result = $this->service->obtainingRemainingDataAboutMovementOfTheProduct($this->dataForObtainingRemainingDataAboutMovementOfTheProduct);
        $this->assertSame(5, $result['from_warehouse_now_quantity']);
        $this->assertSame(5, $result['to_warehouse_now_quantity']);
        $this->assertSame('склад3', $result['from_warehouse_title']);
        $this->assertSame('склад4', $result['to_warehouse_title']);
        $this->assertSame('продукт3', $result['product_title']);
    }

}
