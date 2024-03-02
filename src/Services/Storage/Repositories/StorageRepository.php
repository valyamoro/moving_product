<?php
declare(strict_types=1);

namespace App\Services\Storage\Repositories;

use App\Models\ProductStorage;
use App\Services\BaseRepository;

class StorageRepository extends BaseRepository
{
    public function updateProduct($quantity, $productId, $storageId): array
    {
        $query = 'update product_storage set quantity=? where product_id=? and storage_id=?';

        $this->connection->prepare($query)->execute([
            $quantity,
            $productId,
            $storageId,
        ]);

        return $this->connection->rowCount() ? $this->getById($productId) : [];
    }

    public function deleteProduct($productId, $storageId): bool
    {
        $query = 'delete from product_storage where product_id=? and storage_id=?';

        $this->connection->prepare($query)->execute([$productId, $storageId]);

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
        $query = 'select id as storage_id, name, created_at, updated_at from storages';

        $this->connection->prepare($query)->execute();

        return $this->connection->fetchAll();
    }

    public function getHistoryAboutMovementProduct(int $productId): array
    {
        $query = 'select * from history_movement_product where product_id=? order by id asc';

        $this->connection->prepare($query)->execute([$productId]);

        return $this->connection->fetchAll();
    }

    public function saveHistory(int $productId, ProductStorage $productStorage): bool
    {
        $query = 'insert into history_movement_product(product_id, from_storage_id, to_storage_id,
                past_quantity_from_storage, now_quantity_from_storage,
                past_quantity_to_storage, now_quantity_to_storage, move_quantity)
                values (?, ?, ?, ?, ?, ?, ?, ?)';

        $this->connection->prepare($query)->execute([
            $productId,
            $productStorage->getFromStorageId(),
            $productStorage->getToStorageId(),
            $productStorage->getPastQuantityFromStorage(),
            $productStorage->getNowQuantityFromStorage(),
            $productStorage->getPastQuantityToStorage(),
            $productStorage->getNowQuantityToStorage(),
            $productStorage->getMoveQuantity(),
        ]);

        return (bool)$this->connection->rowCount();
    }

    public function getById(int $id): array
    {
        $query = 'select * from storages where id=? limit 1';

        $this->connection->prepare($query)->execute([$id]);

        return $this->connection->fetch();
    }

}
