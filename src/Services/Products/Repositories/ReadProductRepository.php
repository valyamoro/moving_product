<?php
declare(strict_types=1);

namespace App\Services\Products\Repositories;

use App\Services\Base\BaseRepository;
use App\Services\Contracts\RepositoryInterface;

class ReadProductRepository extends BaseRepository implements RepositoryInterface
{
    // Получение данных из хранилища по айди.
    public function getById(int $id): array
    {

    }

    // Получение всех данных.
    public function getAll(): array
    {

    }

    public function sortById()
    {

    }


}
