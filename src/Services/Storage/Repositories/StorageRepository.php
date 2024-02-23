<?php
declare(strict_types=1);

namespace App\Services\Storage\Repositories;

use App\Services\BaseRepository;

class StorageRepository extends BaseRepository
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

    public function getAll(): array
    {
        $query = 'select * from storages';

        $this->connection->prepare($query)->execute();

        return $this->connection->fetchAll();
    }

    public function getAllHistoryAboutMovementProduct(): array
    {
        $query = 'select * from history_product_moving order by id asc';

        $this->connection->prepare($query)->execute();

        return $this->connection->fetchAll();
    }

    public function saveHistory(int $productId, string $data): bool
    {
        $query = 'insert into history_product_moving(product_id, description) values (?, ?)';

        $this->connection->prepare($query)->execute([$productId, $data]);

        return (bool)$this->connection->rowCount();
    }

    public function getStorageNameById(int $id): string
    {
        $query = 'select name from storages where id=? limit 1';

        $this->connection->prepare($query)->execute([$id]);

        return $this->connection->fetch()['name'];
    }

}
