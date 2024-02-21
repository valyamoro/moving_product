<?php
declare(strict_types=1);

class LogHistoryProductMovingRepositoryTest extends \PHPUnit\Framework\TestCase
{
    private readonly \App\Services\LogHistoryProductMoving\Repositories\LogHistoryProductMovingRepository $repository;

    public function setUp(): void
    {
        $this->repository = new \App\Services\LogHistoryProductMoving\Repositories\LogHistoryProductMovingRepository(require __DIR__ . '/../config/test_db.php');
    }

    public function testCanGetProductTitle(): void
    {
        $this->assertSame('продукт1', $this->repository->getProductTitleById(1));
    }

    public function testCanGetWareHouseTitle(): void
    {
        $this->assertSame('склад1', $this->repository->getWareHouseTitleById(1));
    }

    public function testCanAddHistoryProductMoving(): void
    {
        $result = $this->repository->addHistoryProductMoving(1, 'history');

        $this->assertTrue($result);
    }

}
