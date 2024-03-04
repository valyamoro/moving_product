<?php
declare(strict_types=1);

namespace App\Services\Products;

use App\Models\Model;
use App\Models\Product;
use App\Services\Contracts\ServiceInterface;
use App\Services\Products\Repositories\WriteStorageRepository;

class WriteProductServices implements ServiceInterface
{
    public function __construct(
        private WriteStorageRepository $repository,
    ) {}

    // Получение данных и создание модели.
    public function getById(int $id): Model
    {
    }

    // Запись в хранилище данных из модели.
    public function create(Product $product): Product
    {
    }

    // Обновление существующей записи из хранилища.
    public function update(Product $product): Product
    {
    }

    // Уничтожение записи.
    public function destroy(int $id): bool
    {
    }

}
