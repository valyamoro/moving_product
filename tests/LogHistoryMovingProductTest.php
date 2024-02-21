<?php
declare(strict_types=1);

class LogHistoryMovingProductTest extends \PHPUnit\Framework\TestCase
{
    public function testFormatData(): void
    {
        $data = [
            'product_title' => 'product 1',
            'past_warehouse_title' => 'склад 1',
            'now_warehouse_title' => 'склад 2',
            'moving_quantity' => '5',
            'past_quantity_past_warehouse' => '10',
            'now_quantity_past_warehouse' => '5',
            'now_quantity_now_warehouse' => '5',
            'past_quantity_now_warehouse' => '0',
        ];

        $service = new \App\L_18_02_24\Services\LogHistoryProductMoving\LogHistoryProductMovingService(new \App\L_18_02_24\Services\LogHistoryProductMoving\Repositories\LogHistoryProductMovingRepository());
        $result = $service->formatToInfoAboutMovingProduct($data);

        $this->assertSame("склад 1 product 1 был 10 стало 5\nсклад 2 product 1 было 0 перемещено 5 стало 5", $result);
    }

}
