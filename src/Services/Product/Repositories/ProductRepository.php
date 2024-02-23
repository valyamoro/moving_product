<?php
declare(strict_types=1);

namespace App\Services\Product\Repositories;

use App\Services\BaseRepository;

class ProductRepository extends BaseRepository
{
    public function getAll(): array
    {
        $query = 'SELECT p.id, w.id AS storage_id, p.title, p.price, w.name, pw.quantity 
          FROM product_storage AS pw
          JOIN products AS p ON pw.product_id = p.id
          JOIN storages AS w ON pw.storage_id = w.id
          order by id asc';

        $this->connection->prepare($query)->execute();

        return $this->connection->fetchAll();
    }

    public function getTitleById(int $id): string
    {
        $query = 'select title from products where id=? limit 1';

        $this->connection->prepare($query)->execute([$id]);

        return $this->connection->fetch()['title'];
    }

}
