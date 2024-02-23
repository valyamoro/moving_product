<?php
declare(strict_types=1);

namespace App\Services\ProductMoving\Repositories;

use App\Services\BaseRepository;

class ProductMovingRepository extends BaseRepository
{
    public function updateProduct($quantity, $productId, $storageId): bool
    {
        $query = 'update product_storage set quantity=? where product_id=? and storage_id=?';

        $this->connection->prepare($query)->execute([
            $quantity,
            $productId,
            $storageId,
        ]);

        return (bool)$this->connection->rowCount();
    }

    public function deleteProduct($productId, $storageId): bool
    {
        $query = 'delete from product_storage where product_id=? and storage_id=?';

        $this->connection->prepare($query)->execute([
            $productId,
            $storageId,
        ]);

        return (bool)$this->connection->rowCount();
    }

    public function getAllById(int $id): array
    {
        $query = 'select * from product_storage where id=?';

        $this->connection->prepare($query)->execute([$id]);

        return $this->connection->fetch();
    }

    public function addProduct(int $productId, int $storageId, int $quantity): array
    {
        $query = 'insert into product_storage(product_id, storage_id, quantity) values (?, ?, ?)';

        $this->connection->prepare($query)->execute([
            $productId,
            $storageId,
            $quantity,
        ]);

        return $this->getAllById($this->connection->lastInsertId());
    }

}
