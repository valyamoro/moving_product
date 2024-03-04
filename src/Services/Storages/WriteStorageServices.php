<?php
declare(strict_types=1);

namespace App\Services\Products;

use App\Collections\StorageCollection;
use App\Models\Model;
use App\Models\Product;
use App\Services\Contracts\ServiceInterface;
use App\Services\Storages\Repositories\WriteStorageRepository;

class WriteStorageServices implements ServiceInterface
{
    public function __construct(
        private WriteStorageRepository $repository,
        private StorageCollection $storageCollection,
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
