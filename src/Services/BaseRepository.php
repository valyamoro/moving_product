<?php
declare(strict_types=1);

namespace App\Services;

use App\Database\DatabaseConfiguration;
use App\Database\DatabasePDOConnection;
use App\Database\PDODriver;

abstract class BaseRepository
{
    protected PDODriver $connection;
    public function __construct(array $configuration) {
        $this->connection = $this->connectionDB($configuration);
    }

    private function connectionDB($configuration): PDODriver
    {
        $dataBaseConfiguration = new DatabaseConfiguration(...$configuration);
        $dataBasePDOConnection = new DatabasePDOConnection($dataBaseConfiguration);

        return new PDODriver($dataBasePDOConnection->connection());
    }

    public function getQuantityWareHousesProduct(int $productId, int $wareHouseId): int
    {
        $query = 'select quantity from product_warehouse where product_id=? and warehouse_id=?';

        $this->connection->prepare($query)->execute([$productId, $wareHouseId]);

        $result = $this->connection->fetch();
        return empty($result) ? 0 : $result['quantity'];
    }

}
