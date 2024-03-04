<?php
declare(strict_types=1);

namespace App\Services\Storages;

use App\Collections\Collection;
use App\Collections\StorageCollection;
use App\Models\Product;
use App\Models\Storage;
use App\Services\Contracts\ServiceInterface;
use App\Services\Storages\Repositories\ReadStorageRepository;

class ReadStorageService implements ServiceInterface
{
    public function __construct(
        private ReadStorageRepository $repository,
        private StorageCollection $productCollection,
    ) {}

    // Создание модели.
    public function getById(int $id): Product
    {
    }

    // Создание всех возможных моделей.
    public function getAll(): Collection
    {
        // вызываем у репозитория метод getAll и передаем в makeMany данные,
        // возвращаем объект collection со свойством collection, в котором хранятся коллекции.
    }

    public function makeCollection(array $data): Collection
    {
        // Передаем в collection->makeMany данные, формируем коллекцию объектов.
        // записываем эту коллекцию в свойство класса collection.
    }

    public function getAllMovementsProducts(): array
    {

    }
}
