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

}
