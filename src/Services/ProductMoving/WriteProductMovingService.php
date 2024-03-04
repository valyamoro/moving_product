<?php
declare(strict_types=1);

namespace App\Services\ProductMoving;

use App\Collections\ProductCollection;
use App\Collections\StorageCollection;
use App\Models\Product;
use App\Models\ProductMoving;
use App\Models\Storage;
use App\Services\Contracts\ServiceInterface;
use App\Services\ProductMoving\Repositories\WriteProductMovingRepository;

class WriteProductMovingService implements ServiceInterface
{
    public function __construct(
        private readonly WriteProductMovingRepository $repository,
        private readonly ProductMovingCollection $productMovingCollection,
        private readonly ProductCollection $productCollection,
        private readonly StorageCollection $storageCollection,
    ) {}

    // Получение данных и создание модели.
    public function getById(int $id): ProductMoving
    {

    }

    // Запись в хранилище данных из модели.
    public function create(ProductMoving $product): ProductMoving
    {
    }

    // Обновление существующей записи из хранилища.
    public function update(ProductMoving $product): ProductMoving
    {

    }

    // Уничтожение записи.
    public function destroy(int $id): bool
    {

    }

    // Логика передвижения продукта.
    public function productMoving(ProductMoving $productMoving): bool
    {

    }

    //

}
