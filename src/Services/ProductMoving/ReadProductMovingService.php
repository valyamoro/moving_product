<?php
declare(strict_types=1);

namespace App\Services\ProductMoving;

use App\Collections\Collection;
use App\Collections\ProductMovingCollection;
use App\Collections\StorageCollection;
use App\Models\Model;
use App\Models\Product;
use App\Models\ProductMoving;
use App\Models\Storage;
use App\Services\Contracts\ServiceInterface;
use App\Services\ProductMoving\Repositories\ReadProductMovingRepository;

class ReadProductMovingService implements ServiceInterface
{
    public function __construct(
        private readonly ReadProductMovingRepository $repository,
        private readonly StorageCollection $storageCollection,
        private readonly ProductMovingCollection $productMovingCollection,
    ) {}

    // Получить модель
    public function getById(int $id): Model
    {
        // TODO: Implement getById() method.
    }

    // Получаем все возможные данные из таблицы с историей и возвращаем коллекцию.
    public function getAll(): Collection
    {

    }

    // Заполняем модель оставшейся информацией для перемещения.
    public function getMovementProductInfo(ProductMoving $productStorage): ProductMoving
    {
        // Обращаемся к классам коллекций и получаем объекты продукта и складов.
        // Через них получаем нужную инфу и заполняем объект ProductMoving

        // Возвращаем объект.
    }

}
