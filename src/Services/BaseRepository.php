<?php
declare(strict_types=1);

namespace App\Services;

use App\Database\QueryBuilder;

abstract class BaseRepository
{
    public function __construct(protected QueryBuilder $connection)
    {
    }

    public function getAllProductStorage(int $productId, int $storageId): array
    {
        $query = 'select * from product_storage where product_id=? and storage_id=? limit 1';

        $this->connection->prepare($query)->execute([$productId, $storageId]);

        return $this->connection->fetch();
    }

    public function getAllAboutMovementProducts(): array
    {
        $query = 'SELECT p.id, s.id AS storage_id, p.title, p.price, s.name, ps.quantity, 
       s.created_at AS storage_created, s.updated_at AS storage_updated,
       p.created_at, p.updated_at
          FROM product_storage AS ps
          JOIN products AS p ON ps.product_id = p.id
          JOIN storages AS s ON ps.storage_id = s.id
          order by id asc, ps.storage_id asc';

        $this->connection->prepare($query)->execute();

        return $this->connection->fetchAll();
    }

}
