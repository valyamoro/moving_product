<?php
declare(strict_types=1);

class ProductMovingTest extends \PHPUnit\Framework\TestCase
{
    private readonly \App\L_18_02_24\Models\ProductModel $model;
    private readonly \App\L_18_02_24\Services\ProductMoving\Repositories\ProductMovingRepository $repository;

    protected function setUp(): void
    {
        $data = [
            'id' => 1,
            'idWareHouse' => 1,
            'title' => 'product 1',
            'price' => 500,
            'quantity' => 5,
        ];

        $this->model = new \App\L_18_02_24\Models\ProductModel(...$data);
        $this->repository = new \App\L_18_02_24\Services\ProductMoving\Repositories\ProductMovingRepository();
    }

    public function testCanGetProductData(): void
    {
        $result = $this->repository->getProductData($this->model);

        $this->assertEmpty(empty($result['quantity']));
    }

    public function testCanAddProduct(): void
    {
        $result = $this->repository->addProduct($this->model);

        $this->assertSame($this->model->getId(), $result['product_id']);
        $this->assertSame($this->model->getIdWareHouse(), $result['warehouse_id']);
        $this->assertSame($this->model->getQuantity(), $result['quantity']);
    }

    public function testCanDeleteProduct(): void
    {
        $result = $this->repository->deleteProduct($this->model);

        $this->assertTrue($result);
    }

    public function testCanUpdateProduct(): void
    {
        $result = $this->repository->updateProduct($this->model);

        $this->assertTrue($result);
    }

}
