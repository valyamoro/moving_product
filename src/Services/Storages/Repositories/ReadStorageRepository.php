<?php
declare(strict_types=1);

namespace App\Services\Storages\Repositories;

use App\Services\Base\BaseRepository;
use App\Services\Contracts\RepositoryInterface;

class ReadStorageRepository extends BaseRepository implements RepositoryInterface
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

    public function getAllMovementsProducts(): array
    {
    }


}
