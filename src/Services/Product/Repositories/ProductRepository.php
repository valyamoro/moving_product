<?php
declare(strict_types=1);

namespace App\Services\Product\Repositories;

use App\Services\BaseRepository;

class ProductRepository extends BaseRepository
{
    public function getAll(): array
    {
        $query = 'select * from products';

        $this->connection->prepare($query)->execute();

        return $this->connection->fetchAll();
    }

    public function getById(int $id): array
    {
        $query = 'select * from products where id=? limit 1';

        $this->connection->prepare($query)->execute([$id]);

        return $this->connection->fetch();
    }

}
