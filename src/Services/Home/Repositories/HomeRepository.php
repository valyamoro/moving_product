<?php
declare(strict_types=1);

namespace App\Services\Home\Repositories;

use App\Services\BaseRepository;

class HomeRepository extends BaseRepository
{
    public function getAllStorages(): array
    {
        $query = 'select * from storages order by id asc';

        $this->connection->prepare($query)->execute();

        return $this->connection->fetchAll();
    }

    public function getAllProducts(): array
    {
        $query = 'SELECT p.id, w.id AS storage_id, p.title, p.price, w.name, pw.quantity 
          FROM product_storage AS pw
          JOIN products AS p ON pw.product_id = p.id
          JOIN storages AS w ON pw.storage_id = w.id
          order by id asc';

        $this->connection->prepare($query)->execute();

        return $this->connection->fetchAll();
    }

    public function getAllHistoryMovementProducts(): array
    {
        $query = 'select * from history_product_moving order by id asc';

        $this->connection->prepare($query)->execute();

        return $this->connection->fetchAll();
    }

}
