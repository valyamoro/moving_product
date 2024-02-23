<?php
declare(strict_types=1);

namespace App\Services\HistoryProductMovement\Repositories;

use App\Services\BaseRepository;

class HistoryProductMovementRepository extends BaseRepository
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

    public function save(int $id, string $data): bool
    {
        $query = 'insert into history_product_moving(product_id, description) values (?, ?)';

        $this->connection->prepare($query)->execute([$id, $data]);

        return (bool)$this->connection->rowCount();
    }

}
