<?php
declare(strict_types=1);

namespace App\Services\Products;

use App\Collections\Collection;
use App\Collections\ProductCollection;
use App\Models\Product;
use App\Services\Contracts\ServiceInterface;
use App\Services\Storages\Repositories\ReadStorageRepository;

class ReadProductService implements ServiceInterface
{
    public function __construct(
        private ReadStorageRepository $repository,
        private ProductCollection $productCollection,
    ) {}

    // Создание модели продукта.
    public function getById(int $id): Product
    {
        // обращаемся к репозиторию и получаем данные.
        // передаем данные в productCollection, он обращается к фабричному методу

        // возвращаем созданную модель.
    }

    // Создание всех возможных моделей.
    public function getAll(): Collection
    {
        // обращаемся к репозиторию и получаем данные о всех продуктах.
        // передаем их в productCollection, формируем коллекцию объектов

        // возвращаем коллекцию.
    }

}
