<?php
declare(strict_types=1);

namespace App\Services;

use App\Database\DatabaseConfiguration;
use App\Database\DatabasePDOConnection;
use App\Database\PDODriver;

abstract class BaseRepository
{
    public function __construct(protected PDODriver $connection)
    {
    }

    public function getQuantityProductInStorage(int $productId, int $storageId): int
    {
        $query = 'select quantity from product_storage where product_id=? and storage_id=? limit 1';

        $this->connection->prepare($query)->execute([$productId, $storageId]);

        $result = $this->connection->fetch();
        return !empty($result) ? (int)$result['quantity'] : 0;
    }

}
