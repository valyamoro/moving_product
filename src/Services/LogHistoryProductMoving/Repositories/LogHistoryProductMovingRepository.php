<?php
declare(strict_types=1);

namespace App\Services\LogHistoryProductMoving\Repositories;

use App\Services\BaseRepository;

class LogHistoryProductMovingRepository extends BaseRepository
{
    public function getProductTitleById(int $id): string
    {
        $query = 'select title from products where id=?';

        $this->connection->prepare($query)->execute([$id]);

        return $this->connection->fetch()['title'];
    }

    public function getStorageTitleById(int $id): string
    {
        $query = 'select name from storages where id=?';

        $this->connection->prepare($query)->execute([$id]);

        return $this->connection->fetch()['name'];
    }

    public function addHistoryProductMoving(int $id, string $data): bool
    {
        $query = 'insert into history_product_moving(product_id, description) values (?, ?)';

        $this->connection->prepare($query)->execute([$id, $data]);

        return (bool)$this->connection->rowCount();
    }

    public function getQuantityStorageProduct(int $productId, int $storageId): int
    {
        $query = 'select quantity from product_storage where product_id=? and storage_id=?';

        $this->connection->prepare($query)->execute([$productId, $storageId]);

        $result = $this->connection->fetch();

        return !empty($result) ? (int)$result['quantity'] : 0;
    }

}
