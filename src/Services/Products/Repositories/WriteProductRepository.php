<?php
declare(strict_types=1);

namespace App\Services\Products\Repositories;

use App\Models\Product;
use App\Services\Base\BaseRepository;
use App\Services\Contracts\RepositoryInterface;

class WriteProductRepository extends BaseRepository implements RepositoryInterface
{
    // Получение данных по айди.
    public function getById(int $id): array
    {
    }

    // Запись данных в хранилище.
    public function create(Product $product): array
    {

    }

    // Обновление существующей записи.
    public function updated(Product $product): array
    {

    }

    // Уничтожение записи.
    public function destroy(int $id): bool
    {

    }

}
