<?php
declare(strict_types=1);

namespace App\Services\ProductMoving\Repositories;

use App\Services\BaseRepository;

class ProductMovingRepository extends BaseRepository
{
    public function updateProduct($quantity, $id, $wareHouseId): bool
    {
        $query = 'update product_warehouse set quantity=? where product_id=? and warehouse_id=?';

        $this->connection->prepare($query)->execute([
            $quantity,
            $id,
            $wareHouseId,
        ]);

        return (bool)$this->connection->rowCount();
    }

    public function deleteProduct($productId, $wareHouseId): bool
    {
        $query = 'delete from product_warehouse where product_id=? and warehouse_id=?';

        $this->connection->prepare($query)->execute([
            $productId,
            $wareHouseId,
        ]);

        return (bool)$this->connection->rowCount();
    }

    public function getById(int $id): array
    {
        $query = 'select * from product_warehouse where id=?';

        $this->connection->prepare($query)->execute([$id]);

        return $this->connection->fetch();
    }

    public function addProduct(int $productId, int $wareHouseId, int $quantity): array
    {
        $query = 'insert into product_warehouse(product_id, warehouse_id, quantity) values (?, ?, ?)';

        $this->connection->prepare($query)->execute([
            $productId,
            $wareHouseId,
            $quantity,
        ]);

        return $this->getById($this->connection->lastInsertId());
    }

    public function getProductData(int $productId, int $fromWareHouseId): ?array
    {
        $query = 'select product_id, warehouse_id, quantity 
        from product_warehouse 
        where product_id=:product_id and warehouse_id=:from_warehouse_id
        order by id asc';

        $this->connection->prepare($query)->execute([
            ':product_id' => $productId,
            ':from_warehouse_id' => $fromWareHouseId,
        ]);

        $result = $this->connection->fetch();

        return $result === [] ? null : $result;
    }

}
